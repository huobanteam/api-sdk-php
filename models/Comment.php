<?php
/**
 * HuobanComment
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanComment {

    /**
     * create
     *
     * @return array
     */
    public static function create($item_id, $attributes = array()) {
        return Huoban::post("/comment/item/{$item_id}", $attributes);
    }

    public static function delete($comment_id) {
        return Huoban::delete("/comment/{$comment_id}");
    }

    public static function get_all($item_id, $attributes = array()) {
        return Huoban::get("/comments/item/{$item_id}", $attributes);
    }
}