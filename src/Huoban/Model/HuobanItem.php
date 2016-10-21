<?php
/**
 * HuobanItem
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanItem {

    /**
     * create
     *
     * @return array
     */
    public static function stats($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/item/table/{$table_id}/stats", $attributes, $options);
    }

    public static function create($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/item/table/{$table_id}", $attributes, $options);
    }

    public static function get($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/item/{$item_id}", array(), $attributes, $options);
    }

    public static function update($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::put("/item/{$item_id}", $attributes, $options);
    }

    public static function delete($item_id, $attributes = array()) {
        return HuobanClient::delete("/item/{$item_id}", $attributes);
    }

    public static function bulk_create($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/item/table/{$table_id}/create", $attributes, $options);
    }

    public static function bulk_update($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/item/table/{$table_id}/update", $attributes, $options);
    }

    public static function bulk_delete($table_id, $attributes = array()) {
        return HuobanClient::post("/item/table/{$table_id}/delete", $attributes);
    }

    public static function find($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/item/table/{$table_id}/find", $attributes, $options);
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