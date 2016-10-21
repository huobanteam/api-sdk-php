<?php
/**
 * HuobanTicket
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;
use Huoban\Lib\HuobanException;

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

    /**
     * parse
     *
     * @param  array  $attributes
     * @return
     */
    public static function parse($attributes = array(), $options = array()) {
        return HuobanClient::get("/ticket/parse", $attributes, $options);
    }

    public static function get_table_id() {

        try {
            $parse_info = self::parse();

            if (empty($parse_info['table_id'])) {
                throw new HuobanException("未查到table_id");
            }

            return $parse_info['table_id'];
        } catch (HuobanException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
    }
}
