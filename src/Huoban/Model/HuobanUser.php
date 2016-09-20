<?php
/**
 * HuobanUser
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanUser {

    /**
     * get
     *
     * @return array
     */
    public static function get($attributes = array(), $options = array()) {
        return HuobanClient::post("/user", $attributes, $options);
    }
}