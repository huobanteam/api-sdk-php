<?php
/**
 * HuobanStorage
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanStorage {

    /**
     * get
     *
     * @return array
     */
    public static function get($key, $options = array()) {
        $attributes = array(
            'key' => $key,
        );
        return Huoban::get("/storage", $attributes, $options);
    }

    /**
     * set
     *
     * @return array
     */
    public static function set($key, $value, $options = array()) {
        $attributes = array(
            'key' => $key,
            'value' => $value,
        );
        return Huoban::post("/storage", $attributes, $options);
    }
}
