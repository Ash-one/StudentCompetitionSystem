<?php
/**
 * @name Db_Mongodb
 * @author guoyi
 * @desc MongoDB数据库操作封装
 */
class Db_Mongodb {

    protected $host = 'localhost';
    protected $port = '27017';

    protected $manager = null;
    protected static $connection = [];

    public $fields = [];
    protected $db = 'student_competition_system';
    public $collection = '';

    protected $primary_key;

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

    /**
     * 插入数据
     * @param  array  $arr 插入的数据 ['name' => 'admin','sex' => '0']
     * @return bool
     */
    public function insert(array $arr){
        //若插入数组为空
        if(empty($arr))
            throw new Exception('Insert data is empty.');

        $bulk = new MongoDB\Driver\BulkWrite;

        //未定义字段
        if(empty($this->fields))
            throw new Exception('Please defiend the fields first.');

        //将字段默认值置为arr设定值
        foreach ($this->fields as $field => &$value) {
            if(isset($arr[$field]))
                $value = $arr[$field];
        }
        $newFields = $this->fields;

        //插入新字段并获取_id
        $_id = Tools::object_array($bulk->insert($newFields))['oid'];
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $result = $this->manager->executeBulkWrite("{$this->db}.{$this->collection}", $bulk, $writeConcern);
        //获取本次成功插入条数
        $isSuccess = (bool) $result->getInsertedCount();
        //若插入成功返回_id
        return $isSuccess === true ? $_id : false;
    }

    /**
     * 删除数据
     * @param  array  $match   匹配条件 参考查询、修改匹配条件语法
     * @param  array  $options limit 为0 只删除符合条件的一条记录；为1则删除所有匹配记录
     * @return [type]          [description]
     */
    public function delete(array $match, $options = ['limit'=>0]){
        //若传入匹配条件为空
        if(empty($match))
        {
            throw new Exception('Not safe for none match fields');
        }

        //若设置的limit值不为0/1
        if(isset($options['limit']) && !in_array($options['limit'], [0,1]))
        {
            throw new Exception('Invalid limit option.');
        }

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete($match, $options);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $this->manager->executeBulkWrite("{$this->db}.{$this->collection}", $bulk, $writeConcern);
        $isSuccess = $result->getDeletedCount();

        return (bool)$isSuccess;
    }

    /**
     * 原生语句执行
     * @param array $cmd
     * @return mixed
     */
    protected function execute(array $cmd) {
        $cmd = new MongoDB\Driver\Command($cmd);
        return $this->manager->executeCommand($this->db, $cmd);
    }

    /**
     * 查询记录总量
     * @param array $filter
     * @param array $options
     * @return int
     */
    public function count($filter = [], $options = []){
        $query = new MongoDB\Driver\Query($filter, $options);
        $cmd = [
            'count' => $this->collection,
            'query' => $query
        ];
        $cursor = $this->execute($cmd);
        $info = $cursor->toArray();
        $count = $info[0]->n;
        return (int)$count;
    }
}
?>