<?php
/**
 * HuobanTicket
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanTicket {

    /**
     * create
     *
     * @param  array  $attributes
     * @return
     */
    public static function create($attributes = array()) {
        return Huoban::post("/ticket", $attributes);
    }
}
