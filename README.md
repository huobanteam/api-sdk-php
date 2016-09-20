# Huoban api SDK for PHP

## 概述

Huoban api sdk for PHP是伙伴云表格为第三方开发者提供的php sdk包。开发者可以同过该sdk包进行简单的api调用请求。


## 运行环境
- PHP 5.3+
- cURL extension

## 快速使用

### 常用类

| 类名 | 解释 |
|:------------------|:------------------------------------|
|Huoban\Lib\HuobanClient | Huoban客户端类，用户通过HuobanClient的实例实现调用初始化 |
|Huoban\Lib\HuobanException | Huoban异常类，用户在使用的过程中，只需要注意这个异常|

### HuobanClient初始化

SDK的操作通过初始化HuobanClient类，然后通过Model里面不同方法进行调用，下面代码初始化一个HuobanClient对象:

```php
<?php
$application_id = "<您从Huoban获得的应用ID>"; ;
$application_secret = "<您从Huoban获得的应用秘钥>";
$token = "<您从Huoban获得的token>";
$ticket = "<您从Huoban获得的ticket>";
$app_id = "<您从安装应用中获得的app_id>";
```
获得不同的信息可以采用不同方法进行初始化
```
try {
    HuobanClient::setup_with_app_id($app_id, $application_id, $application_secret);
} catch (HuobanException $e) {
    print $e->getMessage();
}
```
或
```
try {
    HuobanClient::setup_with_token($app_id, $token);
} catch (HuobanException $e) {
    print $e->getMessage();
}
```
或
```
try {
    HuobanClient::setup_with_ticket($ticket);
} catch (HuobanException $e) {
    print $e->getMessage();
}
```

### 返回结果处理

HuobanClient提供的接口返回返回数据分为两种：

* Delete类接口，接口返回null，如果没有HuobanException，即可认为操作成功
* Put，Get，Post类接口，接口返回对应的数据，如果没有HuobanException，即可认为操作成功。

### 运行examples程序

1. 修改 `examples/Config.php`， 补充配置信息
2. 执行 `cd examples/ && php [文件名]`
