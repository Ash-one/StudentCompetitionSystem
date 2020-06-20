<?php

/* 定义这个常量是为了在application.ini中引用*/
define('APPLICATION_PATH', dirname(dirname(__FILE__)));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

// 初始化各种配置
define('LOG_DIR', $application->getConfig()->product->logDirectory);

$application->getDispatcher()->autoRender($application->getConfig()->product->autoRender);

$application->bootstrap()->run();
?>
