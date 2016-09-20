<?php

use Huoban\Lib\HuobanClient;
use Huoban\Model\HuobanItem;

if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

final class Config {
    const TOKEN = 'w3oLGmAA1s2rqeiPJGw6XzavQPFHGDkJoSV5I12q';
    const TICKET = 'azc55cCPA7TynXNuD8i3vUGVX2uAvC27OecD6mlJ';
    const IS_TEST = true;
    const APPLICATION_ID = '1000003';
    const APPLICATION_SECRET = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
}