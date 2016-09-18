<?php
/**
 * HuobanItem
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanItem {

    /**
     * create
     *
     * @return array
     */
    public static function stats($table_id, $attributes = array(), $options = array()) {
        return Huoban::post("/item/table/{$table_id}/stats", $attributes, $options);
    }

    public static function create($table_id, $attributes = array()) {
        return Huoban::post("/item/table/{$table_id}", $attributes);
    }

    public static function get($item_id, $options = array()) {
        return Huoban::get("/item/{$item_id}", array(), $options);
    }

    public static function update($item_id, $attributes = array()) {
        return Huoban::put("/item/{$item_id}", $attributes);
    }

    public static function delete($item_id) {
        return Huoban::delete("/item/{$item_id}");
    }

    public static function find($table_id, $attributes = array(), $options = array()) {
        return Huoban::post("/item/table/{$table_id}/find", $attributes, $options);
    }

    public static function find_by_item_ids($table_id, $item_ids) {
        $where = array(
            'and' => array(),
        );

        $where['and'][] = array(
            'field' => 'item_id',
            'query' => array(
                'in' => $item_ids,
            ),
        );

        $attributes = array(
            'where' => $where,
            'limit' => 500,
        );

        return self::find($table_id, $attributes);
    }

}