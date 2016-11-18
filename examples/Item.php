<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanItem;
use Huoban\Model\HuobanTable;
use Huoban\Lib\HuobanException;

require_once __DIR__ . '/Config.php';

try {

    Config::set_up();

    if ($_GET['table_id']) {
        $table_id = $_GET['table_id'];
    } else {
        $table_id = HuobanTicket::get_table_id();
    }

    $table = HuobanTable::get($table_id);
    $fields = $table['fields'];
    $data_fields = array();
    foreach ($fields as $field) {
        $type = $field['type'];
        $field_id = $field['field_id'];
        switch ($type) {
            case 'text':
                $data_fields[$field_id] = "测试";
                break;
            case 'number':
                $data_fields[$field_id] = 123;
                break;
            default:
                break;
        }
    }

    $data = array(
        'fields' => $data_fields
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
