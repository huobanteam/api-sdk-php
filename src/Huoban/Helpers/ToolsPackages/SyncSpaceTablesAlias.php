<?php

namespace Huoban\Helpers\ToolsPackages;

use Huoban\Helpers\Tools;
use Huoban\Huoban;

/**
 * 初始化同步两个工作区的表格别名使用
 */
trait SyncSpaceTablesAlias
{
    /**
     * 同步字段别名
     *
     * @param Huoban $huoban_source_obj
     * @param Huoban $huoban_target_obj
     * @param integer|null $expired
     * @return array
     */
    public static function syncAlias(Huoban $huoban_source_obj, Huoban $huoban_target_obj, ?int $expired): array
    {

        $source_tables = Tools::getTablesForSpaceId($huoban_source_obj, null);
        $target_tables = Tools::getTablesForSpaceId($huoban_target_obj, null);

        $source_tables = Tools::extractCloumnForArray('name', $source_tables);
        $target_tables = Tools::extractCloumnForArray('name', $target_tables);

        $responses   = [];
        $table_names = array_column($source_tables, 'name');

        foreach ($table_names as $table_name) {

            if (isset($source_tables[$table_name]) && isset($target_tables[$table_name])) {

                $table_body  = static::getTargetAliasTable($source_tables[$table_name], $target_tables[$table_name]);
                $responses[] = $huoban_target_obj->_table->setAlias($target_tables[$table_name]['table_id'], $table_body);
            }
        }

        return $responses;
    }

    /**
     * 获取设定别名之后的表结构
     *
     * @param array $source_table
     * @param array $target_table
     * @return array
     */
    public static function getTargetAliasTable(array $source_table, array $target_table): array
    {

        $source_fields = Tools::extractCloumnForArray('name', $source_table['fields']);
        $target_fields = Tools::extractCloumnForArray('name', $target_table['fields']);

        $field_names = array_column($source_fields, 'name');

        $field_body = [];
        foreach ($field_names as $field_name) {

            if (isset($source_fields[$field_name]) && isset($target_fields[$field_name])) {

                static::getTargetAliasField($source_fields[$field_name], $target_fields[$field_name], $field_body);
            }
        }
        return ['alias' => $source_table['alias'] ?? '', 'fields' => $field_body, 'install_style' => 'old'];

    }

    /**
     * 根据提供的两个字段，返回设定好别名的结构体
     *
     * @param array $source_field
     * @param array $target_field
     * @param array $field_body
     * @return void
     */
    public static function getTargetAliasField(array $source_field, array $target_field, array &$field_body): void
    {

        $source_field_alias = $source_field['alias'] ?? '';
        $source_field_alias = explode('.', $source_field_alias);
        $source_field_alias = $source_field_alias[1] ?? '';

        $target_field_field_id = $target_field['field_id'];

        $field_body[$target_field_field_id] = $source_field_alias;
    }
}
