<?php
/*
 * @Author: SanQian
 * @Date: 2021-08-18 11:37:13
 * @LastEditTime: 2021-10-11 14:02:47
 * @LastEditors: SanQian
 * @Description:
 * @FilePath: /huoban_tools_php/src/Models/Package/Items.php
 *
 */

namespace Huoban\Models\Package;

/**
 * 二次封装伙伴基础模型
 */
trait Items
{
    /**
     * 根据筛选器集合，返回对应格式化数据集合
     *
     * @param [type] $table 表格：id/别名
     * @param [array] $body
     * @return array
     */
    public function findFormatItems($table, $body = [], $options = [])
    {
        $response          = $this->find($table, $body, $options);
        $response['items'] = $this->handleItems($response['items']);
        return isset($options['all_fields']) ? $response : $response['items'];
    }

    /**
     * 根据筛选器集合，返回对应格式化数据集合(全量)
     *
     * @param [type] $table 表格：id/别名
     * @param [array] $body
     * @return array
     */
    public function findAllFormatItems($table, $body = [], $options = [])
    {
        $response          = $this->findAll($table, $body, $options);
        $response['items'] = $this->handleItems($response['items']);
        return isset($options['all_fields']) ? $response : $response['items'];
    }

    /**
     * 根据item_ids集合，返回对应数据集合
     *
     * @param [type] $table 表格：id/别名
     * @param [array] $item_ids
     * @return array
     */
    public function findForItemIds($table, array $item_ids, $options)
    {
        $body = [
            'where' => [
                'and' => [
                    [
                        "field" => 'item_id',
                        "query" => [
                            "in" => $item_ids,
                        ],
                    ],
                ],
            ],
        ];
        return $this->find($table, $body, $options);
    }

    /**
     * 根据item_ids集合，返回对应格式化数据集合
     *
     * @param [type] $table 表格：id/别名
     * @param [array] $item_ids
     * @return array
     */
    public function findFormatItemsForItemIds($table, array $item_ids, $options = [])
    {
        $response          = $this->findForItemIds($table, $item_ids, $options);
        $response['items'] = $this->handleItems($response['items']);
        return $response;
    }

}
