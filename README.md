# Huoban api SDK for PHP

## 概述

Huoban api sdk for PHP是伙伴云表格为第三方开发者提供的php sdk包。开发者可以通过该sdk包进行简单的api调用请求。


## 运行环境
- PHP 7.2+

## 安装方法

1. 如果您通过composer管理您的项目依赖，可以在你的项目根目录运行：

        $ composer require huoban/api-sdk-php

   或者在你的`composer.json`中声明对Huoban api SDK for PHP的依赖：

        "require": {
            "huoban/api-sdk-php": "~1.0"
        }

   然后通过`composer install`安装依赖。composer安装完成后，在您的PHP代码中引入依赖即可：

        require_once __DIR__ . '/vendor/autoload.php';

2. 下载SDK源码，在您的代码中引入SDK目录下的`autoload.php`文件：

        require_once '/path/to/api-sdk-php/autoload.php';

## 快速使用

### 常用类

| 类名 | 解释 |
|:------------------|:------------------------------------|
|Huoban\Huoban | Huoban工场类，用户通过Huoban工场创建相应操作实例 |

### 可创建的实例

| 类名 | 解释 |
|:------------------|:------------------------------------|
|table | 操作表格类，对应 Huoban\\Models\\HuobanTable |
|bi | bi数据仓库类，对应 Huoban\\Models\\HuobanBi |
|bitable | bi数据仓库表表格类，对应 Huoban\\Models\\HuobanBiTable |
|comment | 操作评论类，对应 Huoban\\Models\\HuobanComment |
|company | 公司信息类，对应 Huoban\\Models\\HuobanCompany |
|file | 文件操作类，对应 Huoban\\Models\\HuobanFile |
|item | 表格数据类，对应 Huoban\\Models\\HuobanItem |
|members | 用户类，对应 Huoban\\Models\\HuobanMembers |
|order | 订单类，对应 Huoban\\Models\\HuobanOrder |
|share | 分享类，对应 Huoban\\Models\\HuobanShare |

### Huoban初始化

SDK的操作通过初始化Huoban类，然后通过Model里面不同方法进行调用，下面代码初始化一个Huoban对象:

```php
$config = [
    'ticket' => 'xxxx',
    'application_id' => 'xxxx',
    'application_secret' => 'xxxxx',
];
```
获得不同的信息可以采用不同方法进行初始化，下面为表格应用
```php
$huoban = new Huoban([
   'ticket' => 'xxxx'
]);
$table = $huoban->create('table'); 

$table->get('table_id');
```
或工作区应用
```php
$huoban = new Huoban([
   'application_id' => 'xxxx',
   'application_secret' => 'xxxx'
]);
$table = $huoban->create('table');

$table->get('table_id');
```

