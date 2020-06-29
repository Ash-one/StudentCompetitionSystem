<?php
require "../vendor/autoload.php"; //调用composer引入的外部库
ob_start(); //打开缓冲区

/* 定义这个常量是为了在application.ini中引用*/
define('APPLICATION_PATH', dirname(dirname(__FILE__)));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

// 初始化各种配置
define('LOG_DIR', $application->getConfig()->product->logDirectory);
// session 相关
$sessionPath = $application->getConfig()->session->savePath;
if (!file_exists($sessionPath)) { 
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);

$application->getDispatcher()->autoRender($application->getConfig()->product->autoRender);

$application->bootstrap()->run();
ob_end_flush(); //输出全部内容到浏览器
//Db_Mongodb::dropDatabase();
?>
