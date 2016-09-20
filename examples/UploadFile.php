<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanFile;

require_once __DIR__ . '/Config.php';

// 正常是从url地址获取
// $ticket = $_GET['ticket'];

HuobanClient::setup_with_ticket(Config::TICKET, Config::IS_TEST);

$file_path = dirname(__FILE__) . '/pic/aaa.png';

uploadFile($file_path, 'aaa.png');


function uploadFile($file_path, $file_name) {
    try {
        HuobanFile::upload($file_path, $file_name);
    } catch (HuobanExcrption $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}