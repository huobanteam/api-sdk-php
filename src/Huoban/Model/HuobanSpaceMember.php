<?php
/**
 * HuobanSpaceMember
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanSpaceMember {

    /**
     * get
     *
     * @return array
     */
    public static function get_all($space_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/space/{$space_id}/members", $attributes, $options);
    }
}