<?php
/**
 * HuobanSpace
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanSpace {

    /**
     * get
     *
     * @return array
     */
    public static function get_joined($attributes = array(), $options = array()) {
        return HuobanClient::get("/spaces/joined", $attributes, $options);
    }
}