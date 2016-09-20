<?php
/**
 * HuobanComment
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanComment {

    /**
     * create
     *
     * @return array
     */
    public static function create($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/comment/item/{$item_id}", $attributes, $options);
    }

    public static function delete($comment_id, $attributes = array()) {
        return HuobanClient::delete("/comment/{$comment_id}", $attributes);
    }

    public static function get_all($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/comments/item/{$item_id}", $attributes, $options);
    }
}