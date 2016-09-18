<?php
/**
 * HuobanUser
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanUser {

    /**
     * get
     *
     * @return array
     */
    public static function get() {
        return Huoban::post("/user");
    }
}