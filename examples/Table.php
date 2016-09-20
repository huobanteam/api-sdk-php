<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanTable;

require_once __DIR__ . '/Config.php';

// 正常是从url地址获取
// $app_id = $_GET['app_id'];

$app_id = 8;
HuobanClient::setup_with_app_id($app_id, Config::APPLICATION_ID, Config::APPLICATION_SECRET, Config::IS_TEST);

$table_id = 24;
getTable($table_id);

function getTable($table_id) {
    try {
        HuobanTable::get($table_id);
    } catch (HuobanExcrption $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}
