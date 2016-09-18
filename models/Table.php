<?php
/**
 * HuobanTable
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanTable {

    /**
     * get
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function get($table_id, $options = array()) {
        return Huoban::get("/table/{$table_id}", $options);
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