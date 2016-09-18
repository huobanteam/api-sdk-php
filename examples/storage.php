<?php
require_once '../autoload.php';

// 正常是从url地址获取
// $ticket = $_GET['ticket'];

$ticket = 'K6sjbj8zooC1ugBP/drf9WQLRA1F0vmmFG6KBCrmmORy3ObYSXZ+rDmoN+qTDy/HLujRvvBnqluIK4yv2hdOYpXccbTZfogJMV2VxB81Jri5LAs2sEL8YorJPfbaLf6iPGRSRraMUKf39huLfqsyq6xEOo5DIVz5e7Lksv0CZTo=';
$is_test = true;

Huoban::setup($ticket, $is_test);

try {
    $key = 'task|11001|project';
    $value = array(
        'project_id' => 1,
        'name' => '这是项目1',
    );

    HuobanStorage::set($key, $value);

    $result = HuobanStorage::get($key);
    print_r($result);
} catch (Exception $e) {
    print_r($e);
}