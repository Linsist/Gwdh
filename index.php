<?php
define('THINK_PATH', './Core/');

// 定义项目名称和路径
define('APP_NAME', 'App');
define('APP_PATH', './App/');

// ucenter配置文件
require("./config.inc.php");
// ucenter客户端入口
require("./uc_client/client.php");

// 加载框架入口文件
require("Core/ThinkPHP.php");
