<?php
/**
 * HuobanNotification
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanNotification {

    /**
     * create
     *
     * @param  array  $attributes
     * @return array
     */
    public static function create($attributes = array(), $options = array()) {
        return HuobanClient::post("/notification", $attributes, $options);
    }
}