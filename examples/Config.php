<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanItem;

if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

final class Config {
    const IS_TEST = true;
    const APPLICATION_ID = '1000003';
    const APPLICATION_SECRET = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

    public static function set_up() {
        $app_id = $_GET['app_id'];
        $ticket = $_GET['ticket'];
        $table_id = $_GET['table_id'];

        if ($ticket) {
            HuobanClient::setup_with_ticket($ticket, Config::IS_TEST);
        } elseif ($app_id) {
            HuobanClient::setup_with_app_id($app_id, Config::APPLICATION_ID, Config::APPLICATION_SECRET, Config::IS_TEST);
        }
    }
}