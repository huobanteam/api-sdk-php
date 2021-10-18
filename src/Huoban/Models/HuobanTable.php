<?php

namespace Huoban\Models;

use Huoban\RequestInterface;;
use Huoban\Models\Package\Table;

class HuobanTable
{
    use Table;

    public $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }
    /**
     * 获取表结构
     *
     * @param [type] $table
     * @param [type] $body
     * @param array $options
     * @return void
     */
    public function get($table, $body = null, $options = [])
    {
        return $this->request->execute('GET', "/table/{$table}", $body, $options);
    }
    /**
     * 创建表
     *
     * @param [type] $space_id
     * @param [type] $body
     * @param array $options
     * @return void
     */
    public function create($space_id, $body = null, $options = [])
    {
        return $this->request->execute('POST', "/table/space/{$space_id}", $body, $options);

        /**
         * 创建格式化body实例
         */
//        $fields[] = $this->getFieldTextBasic('test', 'field_A');
//        $body     = $this->getTableBasic('test1', 'table_test1', $fields);
    }

    public function update($table, $body = null, $options = [])
    {
        return $this->request->execute('PUT', "/table/{$table}", $body, $options);
    }

    public function copy($table, $body = null, $options = [])
    {
        return $this->request->execute('POST', "/table/{$table}/copy", $body, $options);
    }

    public function setAlias($table, $body = null, $options = [])
    {
        return $this->request->execute('POST', "/table/{$table}/alias", $body, $options);
    }

    public function getTables($space_id, $body = null, $options = [])
    {
        return $this->request->execute('GET', "/tables/space/{$space_id}", $body, $options);
    }

    public function getPermissions($table, $body = null, $options = [])
    {
        return $this->request->execute('POST', "/permissions/table/{$table}", $body, $options);
    }

    /**
     * 获取表基础结构
     *
     * @param [type] $name  表格名称
     * @param [type] $alias 表格别名
     * @param array $fields
     * @return array
     */
    public function getTableBasic($name, $alias = null, $fields = [])
    {
        return [
            'table_id'                  => '',
            'name'                      => $name,
            'alias'                     => $alias ?: md5(uniqid(microtime(true), true)),
            'item_name'                 => '',
            'icon'                      => [
                'id'    => 600,
                'color' => 'a',
            ],
            'fields'                    => $fields,
            'field_layout'              => [
                array_column($fields, 'field_id'),
            ],
            'list_layout'               => array_column($fields, 'field_id'),
            'lock'                      => [
                'permission'  => 0,
                'item_delete' => 0,
            ],
            'layout_fields'             => [],
            'item_title'                => [
                'type'     => 'first_field',
                'template' => '',
            ],
            'default_view_id'           => '',
            'default_app_id'            => 0,
            'allow_comment'             => 1,
            'allow_upload_file'         => 1,
            'display_filter_field_ids'  => [],
            'hidden_filter_field_ids'   => [],
            'search_field_ids'          => [],
            'rights'                    => [
                'view',
                'update',
                'delete',
                'item_create',
                'bulk_update',
                'bulk_delete',
            ],
            'allow_order_system_fields' => [],
            'allow_order_fields'        => [],
            'space_id'                  => 4000000002765282,
            'space'                     => [
                'space_id' => 4000000002765282,
            ],
            'field_layout_type'         => 1,
            'field_view_conditions'     => [],
            'field_sync'                => 1,
        ];
    }

    /**
     * 获取文本字段基础结构
     *
     * @param [type] $name  字段名称
     * @param [type] $alias 字段别名
     * @param array $fields
     * @return array
     */
    public function getFieldTextBasic($name, $alias = null)
    {
        return [
            'field_id'        => 'rcacwzha',
            'name'            => $name,
            'alias'           => $alias ?: md5(uniqid(microtime(true), true)),
            'type'            => 'text',
            '_new'            => 1,
            'value'           => [
                [
                    'value' => '',
                ],
            ],
            'preserved'       => 1,
            'icon'            => '&#xe654',
            'manual'          => '1',
            'config'          => [
                'type' => 'input',
            ],
            'default_setting' => [
                'type'  => '',
                'value' => '',
            ],
            'lock'            => [
                'update'      => 0,
                'delete'      => 0,
                'item_update' => 0,
            ],
        ];
    }
}
