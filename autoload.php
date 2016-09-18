<?php
/**
 * 初始化文件
 *
 *     作者: 韩洋 (hanyang@huoban.com)
 * 创建时间: 2016-08-31 10:30:08
 * 修改记录:
 *
 * $Id$
 */

require_once 'lib/Exception.php';
require_once 'lib/Huoban.php';

require_once 'models/Application.php';
require_once 'models/Comment.php';
require_once 'models/File.php';
require_once 'models/Follow.php';
require_once 'models/Item.php';
require_once 'models/Notification.php';
require_once 'models/Storage.php';
require_once 'models/Stream.php';
require_once 'models/Table.php';
require_once 'models/Ticket.php';
require_once 'models/User.php';

// 平台给应用颁发的 使用应用态去获取某些接口的时候 才会用到
define('HUOBAN_APPLICATION_ID', '11001');
define('HUOBAN_APPLICATION_SECRET', 'xxxx');