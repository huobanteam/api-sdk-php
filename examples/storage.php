<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanStorage;
use Huoban\Lib\HuobanException;

require_once __DIR__ . '/Config.php';

try {
    // 正常是从url地址获取
    // $ticket = $_GET['ticket'];

    HuobanClient::setup_with_ticket(Config::TICKET, Config::IS_TEST);


    $key = 'task|11001|project';
    $value = array(
        'project_id' => 1,
        'name' => '这是项目1',
    );

    setStorage($key, $value);

    getStorage($key);
} catch (HuobanException $e) {
    printf($e->getMessage() . "\n");
    return;
}

function setStorage($key, $value) {
    try {
        HuobanStorage::set($key, $value);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}

function getStorage($key) {
    try {
        HuobanStorage::get($key);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}