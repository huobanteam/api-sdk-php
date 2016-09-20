<?php
/**
 * HuobanStorage
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

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
        return HuobanClient::get("/storage", $attributes, $options);
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
        return HuobanClient::post("/storage", $attributes, $options);
    }
}
