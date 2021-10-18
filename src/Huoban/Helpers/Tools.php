<?php

namespace Huoban\Helpers;

use Huoban\Helpers\ToolsPackages\SyncSpaceTablesAlias;
use Huoban\Huoban;

class Tools
{
    use SyncSpaceTablesAlias;

    /**
     * 提取某一列为键名生成数组
     *
     * @param String $col_name
     * @param array $array
     * @return array
     */
    public static function extractCloumnForArray(String $col_name, array $array): array
    {
        return array_combine(array_column($array, $col_name), $array);
    }

    /**
     * 获取配置文件，部分默认
     *
     * @param array $config
     * @return array
     */
    public static function getConfig(array $config): array
    {
        return $config + [
            'alias_model' => true,
            'app_type'    => 'enterprise',
            'api_url'     => 'https://api.nb-health.com',
            'upload_url'  => 'https://upload.huoban.com',
        ];
    }

    /**
     * 获取工作区内所有表格（一般提供给初始化使用）
     *
     * @param Huoban $huoban_obj
     * @param integer|null $expired
     * @return array
     */
    public static function getTablesForSpaceId(Huoban $huoban_obj, ?int $expired): array
    {
        $expired = $expired ?: 1209600;

        $space = $huoban_obj->_cache->remember($huoban_obj->config['name'] . 'space', $expired, function () use ($huoban_obj) {
            return $huoban_obj->_space->getSpace($huoban_obj->config['space_id']);
        });

        foreach ($space['table_ids'] as $table_id) {
            $tables[] = $huoban_obj->_cache->remember($huoban_obj->config['name'] . $table_id, $expired, function () use ($huoban_obj, $table_id) {
                return $huoban_obj->_table->get($table_id);
            });
        }

        return $tables;
    }
}
