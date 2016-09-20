<?php
/**
 * HuobanApplication
 *
 * $Id$
 */
namespace Huoban\Model;

use Huoban\Lib\HuobanClient;

class HuobanApplication {

    public static function get_ticket($app_id, $application_id = '', $application_secret = '') {

        $params = array(
            'app_id' => $app_id,
            'expired' => 86400,
        );

        if ($application_id) {
            $params['application_id'] = $application_id;
        }

        if ($application_secret) {
            $params['application_secret'] = $application_secret;
        }

        return HuobanClient::post('/ticket', $params);
    }
}