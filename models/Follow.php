<?php
/**
 * HuobanFollow
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanFollow {

    /**
     * create
     *
     * @return array
     */
    public static function create($item_id) {
        return Huoban::post("/follow/item/{$item_id}");
    }

    public static function delete($ref_id) {
        return Huoban::delete("/follow/item/{$ref_id}");
    }

    public static function get_all($item_id, $attributes = array()) {
        return Huoban::post("/follow/item/{$item_id}/find", $attributes);
    }
}