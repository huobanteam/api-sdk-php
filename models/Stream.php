<?php
/**
 * HuobanStream
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanStream {

    /**
     * 获取item动态
     * $attributes = array(
     *     'limit' => 10,
     *     'last_stream_id' => 11001,
     * );
     */
    public static function get_for_item($item_id, $attributes = array()) {
        return Huoban::get("/streams/item/{$item_id}", $attributes);
    }

}