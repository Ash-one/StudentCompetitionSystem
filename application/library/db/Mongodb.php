<?php
/**
 * mongodb 数据库操作封装
 * @author guoyi
 */
class Db_Mongodb {

    protected $host = 'localhost';
    protected $port = '27017';

    public $manager = null;
    protected static $connection = [];

    /**
     * 禁止外部克隆
     */
    protected function __clone()
    {

    }

    /**
     * 构造函数
     */
    public function __construct()
    {
        try
        {
            if(!extension_loaded('mongodb')) {
                //如果还未安装mongodb扩展
                self::log('mongodb extension not install.');
                throw new Exception('mongodb extension not install.');
            }

            if(!isset(self::$connection[$this->host][$this->port]))
            {
                self::connect();
            }

            $this->manager = self::$connection[$this->host][$this->port];
        } catch (Exception $exception) {
            self::log($exception->getMessage());
        }
    }

    /**
     * 连接数据库
     */
    private function connect() {
        $uri = "mongodb://{$this->host}:{$this->port}";

        self::$connection[$this->host][$this->port] = new MongoDB\Driver\Manager(
            $uri
        );
    }
}
?>