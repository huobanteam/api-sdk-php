<?php
/**
 * HuobanTicket
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanTicket {

    /**
     * create
     *
     * @param  array  $attributes
     * @return
     */
    public static function create($attributes = array(), $options = array()) {
        return HuobanClient::post("/ticket", $attributes, $options);
    }
}
