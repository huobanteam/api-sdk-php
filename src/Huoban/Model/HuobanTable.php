<?php
/**
 * HuobanTable
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanTable {

    /**
     * get
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function get($table_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/table/{$table_id}", $attributes, $options);
    }

    /**
     * get_for_space
     *
     * @param  integer $space_id
     * @param  array  $options
     * @return array
     */
    public static function get_for_space($space_id, $attributes = array(), $options = array()) {
        return HuobanClient::get("/tables/space/{$space_id}", $attributes, $options);
    }

    /**
     * get_alias_fields
     *
     * @param  array $table
     * @param  integer $app_id
     * @return
     */
    public static function get_alias_fields($table, $app_id) {

        $fields = array();
        if ($table && $table['fields']) {
            foreach ($table['fields'] as $key => $value) {

                if ($value['app_id'] != $app_id) {
                    continue;
                }

                $fields[$value['application_alias']] = $value;
            }
        }

        return $fields;
    }
}