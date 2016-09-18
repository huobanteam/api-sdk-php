<?php
require_once '../autoload.php';

// 正常是从url地址获取
// $ticket = $_GET['ticket'];

$ticket = 'K6sjbj8zooC1ugBP/drf9WQLRA1F0vmmFG6KBCrmmORy3ObYSXZ+rDmoN+qTDy/HLujRvvBnqluIK4yv2hdOYpXccbTZfogJMV2VxB81Jri5LAs2sEL8YorJPfbaLf6iPGRSRraMUKf39huLfqsyq6xEOo5DIVz5e7Lksv0CZTo=';
$is_test = true;

Huoban::setup($ticket, $is_test);

try {
    // 创建item
    $table_id = 1000203;
    $data = array(
        'fields' => array(
            '1001683' => '这是标题',
        ),
    );
    $item = HuobanItem::create($table_id, $data);
    print_r($item);

    // 获取某个item
    $items = HuobanItem::get($item['item_id']);
    print_r($items);

    // 获取items信息
    $items = HuobanItem::find($table_id);
    print_r($items);
    // 获取所有item
} catch (Exception $e) {
    print_r($e);
}