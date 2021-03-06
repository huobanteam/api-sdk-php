<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanFile;
use Huoban\Lib\HuobanException;

require_once __DIR__ . '/Config.php';
try {
    // 正常是从url地址获取
    // $ticket = $_GET['ticket'];

    Config::set_up();

    $file_path = dirname(__FILE__) . '/pic/aaa.png';

    uploadFile($file_path, 'aaa.png');
} catch (HuobanException $e) {
    printf($e->getMessage() . "\n");
    return;
}

function uploadFile($file_path, $file_name) {
    try {
        HuobanFile::upload($file_path, $file_name);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}