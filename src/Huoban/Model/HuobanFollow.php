<?php
/**
 * HuobanFollow
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanFollow {

    /**
     * create
     *
     * @return array
     */
    public static function create($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/follow/item/{$item_id}", $attributes, $options);
    }

    public static function delete($ref_id, $attributes = array()) {
        return HuobanClient::delete("/follow/item/{$ref_id}", $attributes);
    }

    public static function get_all($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/follow/item/{$item_id}/find", $attributes, $options);
    }
}