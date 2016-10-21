<?php
/**
 * HuobanPreference
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanPreference {

    /**
     * update
     *
     * @return array
     */
    public static function update($ref_type, $ref_id, $attributes = array(), $options = array()) {
        return HuobanClient::post("/preference/{$ref_type}/{$ref_id}", $attributes, $options);
    }

    /**
     * get
     *
     * @return array
     */
    public static function get($ref_type, $ref_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/preference/{$ref_type}/{$ref_id}", $attributes, $options);
    }
}
