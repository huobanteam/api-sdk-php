<?php
require_once '../autoload.php';

// 正常是从url地址获取
// $ticket = $_GET['ticket'];

$ticket = 'K6sjbj8zooC1ugBP/drf9WQLRA1F0vmmFG6KBCrmmORy3ObYSXZ+rDmoN+qTDy/HLujRvvBnqluIK4yv2hdOYpXccbTZfogJMV2VxB81Jri5LAs2sEL8YorJPfbaLf6iPGRSRraMUKf39huLfqsyq6xEOo5DIVz5e7Lksv0CZTo=';
$is_test = true;

Huoban::setup($ticket, $is_test);

try {
    $file_path = dirname(__FILE__) . '/pic/aaa.png';

    $file = HuobanFile::upload($file_path, 'aaa.png');

    print_r($file);
} catch (Exception $e) {
    print_r($e);
}