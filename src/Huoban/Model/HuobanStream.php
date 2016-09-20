<?php
/**
 * HuobanStream
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanStream {

    /**
     * 获取item动态
     * $attributes = array(
     *     'limit' => 10,
     *     'last_stream_id' => 11001,
     * );
     */
    public static function get_for_item($item_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/streams/item/{$item_id}", $attributes, $options);
    }

}