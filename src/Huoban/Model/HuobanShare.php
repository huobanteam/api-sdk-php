<?php
/**
 * HuobanShare
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanShare {

    /**
     * create
     *
     * @return array
     */
    public static function create($ref_type, $ref_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/share/{$ref_type}/{$ref_id}", $attributes, $options);
    }

    /**
     * get_all
     *
     * @return array
     */
    public static function get_all($ref_type, $ref_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/share/{$ref_type}/{$ref_id}", $attributes, $options);
    }
}
