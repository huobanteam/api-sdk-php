<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanItem;
use Huoban\Lib\HuobanException;

require_once __DIR__ . '/Config.php';
// 正常是从url地址获取
// $app_id = $_GET['app_id'];

try {

    $app_id = 8;
    HuobanClient::setup_with_token($app_id, Config::TOKEN, Config::IS_TEST);

    $table_id = 24;
    $data = array(
        'fields' => array(
            '23' => '这是标题',
        ),
    );

    // 创建item
    $item = createItem($table_id, $data);
    // 获取某个item
    getItem($item['item_id']);
    // 获取items信息
    findItem($table_id);
} catch (HuobanException $e) {
    printf($e->getMessage() . "\n");
}

function createItem($table_id, $data) {
    try {
        $item = HuobanItem::create($table_id, $data);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");

    return $item;
}

function getItem($item_id) {
    try {
        $item = HuobanItem::get($item_id);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}

function findItem($table_id) {
    try {
        $item = HuobanItem::find($table_id);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}
