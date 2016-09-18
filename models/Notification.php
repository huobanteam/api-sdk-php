<?php
/**
 * HuobanNotification
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */
class HuobanNotification {

    /**
     * create
     *
     * @param  array  $attributes
     * @return array
     */
    public static function create($attributes = array(), $options = array()) {
        return Huoban::post("/notification", $attributes, $options);
    }
}