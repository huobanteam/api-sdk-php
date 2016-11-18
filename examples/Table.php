<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanTable;
use Huoban\Lib\HuobanException;
use Huoban\Model\HuobanTicket;

require_once __DIR__ . '/Config.php';
try {

    Config::set_up();

    if ($_GET['table_id']) {
        $table_id = $_GET['table_id'];
    } else {
        $table_id = HuobanTicket::get_table_id();
    }

    getTable($table_id);
} catch (HuobanException $e) {
    printf($e->getMessage() . "\n");
    return;
}

function getTable($table_id) {
    try {
        HuobanTable::get($table_id);
    } catch (HuobanException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    print(__FUNCTION__ . ": OK" . "\n");
}
