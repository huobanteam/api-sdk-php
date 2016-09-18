<?php
/**
 * HuobanApplication
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

class HuobanApplication {

    public static function get_ticket($app_id) {

        $params = array(
            'app_id' => $appId,
            'application_id' => HUOBAN_APPLICATION_ID,
            'application_secret' => HUOBAN_APPLICATION_SECRET,
            'expired' => 86400,
        );

        return Huoban::post('/ticket', $params);
    }
}