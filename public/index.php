<?php

/* 定义这个常量是为了在application.ini中引用*/
define('APPLICATION_PATH', dirname(dirname(__FILE__)));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

// 初始化各种配置
define('LOG_DIR', $application->getConfig()->product->logDirectory);

$application->getDispatcher()->autoRender($application->getConfig()->product->autoRender);

$application->bootstrap()->run();

//数据库小测试
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// 插入数据
#$bulk = new MongoDB\Driver\BulkWrite;
#$bulk->insert(['x' => 1, 'name' => 'hh', 'url' => 'http://www.hh.com']);
#$bulk->insert(['x' => 2, 'name' => 'Google', 'url' => 'http://www.google.com']);
#$bulk->insert(['x' => 3, 'name' => 'taobao', 'url' => 'http://www.taobao.com']);
#$manager->executeBulkWrite('test.sites', $bulk);

//gt表示greater than，x>1
$filter = ['x' => ['$gt' => 1]];
$options = [
    'projection' => ['_id' => 0],
    'sort' => ['x' => -1],
];

// 查询数据
$query = new MongoDB\Driver\Query($filter, $options);
$cursor = $manager->executeQuery('test.sites', $query);

foreach ($cursor as $document) {
    print_r($document);
}
?>
