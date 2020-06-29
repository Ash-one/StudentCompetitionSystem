<?php
/**
 * @name Db_Mongodb
 * @author guoyi
 * @desc MongoDB数据库操作封装
 */
abstract class Db_Mongodb {
    protected $host = 'localhost';
    protected $port = '27017';

    protected $manager = null;
    protected static $connection = [];

    public $fields = [];
    protected $db = 'student_competition_system';
    public $collection = '';

    protected $primary_key = '_id';

    protected static $op = [
        '$inc',
        '$addToSet'
    ];

    /**
     * 禁止外部克隆
     */
    protected function __clone()
    {

    }

    /**
     * 构造函数，禁止外部将之实例化
     */
    protected function __construct()
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

    abstract static public function getInstance();

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
        try {
            //若插入数组为空
            if (empty($arr))
                throw new Exception('Insert data is empty.');

            $bulk = new MongoDB\Driver\BulkWrite;

            //未定义字段
            if (empty($this->fields)) {
                throw new Exception('Please defiend the fields first.');
            }
        } catch (Exception $exception) {
            self::log($exception->getMessage());
        }

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
     * 将传入的字符串转换成类型为MongoDB\BSON\ObjectID的对象返回，用于_id在数据库中的匹配
     * @param     string           $_id
     * @return    MongoDB\BSON\ObjectID
     */
    public function makeObjectId($_id = ''){
        try{
            $oid = new MongoDB\BSON\ObjectID($_id);
        }
        catch (Exception $e){
            $oid = false;
        }

        return $oid;
    }

    /**
     * 删除数据
     * @param  array  $match   匹配条件 参考查询、修改匹配条件语法
     * @param  array  $options limit 为0 只删除符合条件的一条记录；为1则删除所有匹配记录
     * @return [type]          [description]
     */
    public function delete(array $match, $options = ['limit' => 0]){
        try {
            //若传入匹配条件为空
            if (empty($match)) {
                throw new Exception('Not safe for none match fields');
            }

            //若设置的limit值不为0/1
            if (isset($options['limit']) && !in_array($options['limit'], [0, 1])) {
                throw new Exception('Invalid limit option.');
            }
        } catch (Exception $exception) {
            self::log($exception->getMessage());
        }

        //将主键的值从字符串类型转为MongoDB\BSON\ObjectID类型
        if(isset($match[$this->primary_key])){
            $oid = $this->makeObjectId($match[$this->primary_key]);
            if(false === $oid)
            {
                return false;
            }
            $match[$this->primary_key] = $oid;
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

    /**
     * 更新数据
     * @param  array  $match    查询条件 ['name' => '江夏蓝']
     * @param  array  $update   修改字段 ['username' => 'emma','age' => 23]
     *                          $inc:  如下例，使'num'字段值加10，使'age'字段值减12
     *                                 ['$inc' => ['num' => 10, 'age' => -12]]
     *                          注意单个语句中$set（$set操作符可省略）与$inc取其一，请勿混用
     * @param  array  $options  可选参数
     * 'multi' => true, 'upsert'=>false
     * multi  默认是false,只更新找到的第一条记录，如果这个参数为true,就把按条件查出来多条记录全部更新
     * upsert 如果不存在update的记录，是否插入新纪录, true为插入, 默认是false不插入
     * ['multi' => false, 'upsert' => false]
     */
    public function update(array $match, array $update, $options = ['multi'=>true, 'upsert'=>false]) {
        try {
            if(empty($match) || empty($update)) {
                throw new Exception('Not safe for none match or update fields');
            }
        } catch (Exception $exception) {
            self::log($exception->getMessage());
            return false;
        }

        //若在match条件中设置了主键
        if(isset($match[$this->primary_key])) {
            //若match中主键的值不是数组
            //将match中主键的值从字符串转换为ObjectID对象
            $oid = $this->makeObjectId($match[$this->primary_key]);
            if(false == $oid) {
                return false;
            }
            //将ObjectID对象写回
            $match[$this->primary_key] = $oid;
        }

        //标记update语句是否为self::$op(如$inc) 类型操作符
        $flag = false;
        //遍历$update
        foreach ($update as $field => &$val) {
            //处理 self::$op(如$inc) 类型操作符
            if($flag = in_array($field, self::$op)){
                foreach ($val as $fk => $fv) {
                    if(!isset($this->fields[$fk])){
                        //限制定义的字段，若修改未定义字段则修改无效
                        unset($val[$fk]);
                    }
                }

                //限制主键不能修改
                if(isset($val[$this->primary_key])){
                    unset($val[$this->primary_key]);
                }
                //继续下一个修改
                continue;
            }

            //处理其它（如$set）类型操作符
            if(!isset($this->fields[$field])) {
                //限制定义的字段，若修改未定义字段则修改无效
                unset($update[$field]);
            }
        }

        //限制主键不能修改
        if(isset($update[$this->primary_key])) {
            unset($update[$this->primary_key]);
        }

        $bulk = new MongoDB\Driver\BulkWrite;

        if($flag === true) {
            //$inc
            $bulk->update($match, $update, $options);
        }
        else {
            //$set
            $bulk->update($match, ['$set' => $update], $options);
        }

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        $result = $this->manager->executeBulkWrite("{$this->db}.{$this->collection}", $bulk, $writeConcern);

        //获取修改数返回，未修改则返回false
        $successCount = $result->getModifiedCount();
        return (((bool)$successCount === true) ? $successCount : false);
    }

    /**
     * 插入库中不存在的记录
     * @param $doc
     */
    public function uniqueInsert($doc) {
        $this->update($doc,$doc,['multi'=>false, 'upsert'=>true]);
    }

    /**
     * 通过主键 _id 修改记录字段值
     * @param     string           $_id
     * @param     array            $update ['$set' => ['name' => 'emma', 'age' => 12]]
     *                                     ['$inc' => ['num' => 10, 'age' => -12]]
     * @param     array            $options
     * @return    bool
     */
    public function updateById($_id, array $update, $options = ['multi' => true, 'upsert'=>false]){
        $match = [
            $this->primary_key => $_id
        ];
        //根据主键更新对应记录
        return $this->update($match, $update, $options);
    }

    /**
     * 查询数据
     * @param  array  $filter  条件 $filter = ['x' => ['$gt' => 1]];
     * @param  array  $options 额外参数
     * $options = [
     *    'projection' => ['_id' => 0], 投影，显示置为1的字段，不显示置为0的字段
     *    'limit' => 5                  查询结果行上限
     *    'sort' => ['x' => -1],        排序，按照x的值降序排列，1则是升序排列，可依据多个字段排序
     *                                  如'sort' => ['x' => -1, 'y' => 1]，按x降序，x值相同的行按y升序排列
     * ];
     * @return array           [description]
     */
    public function query(array $filter, $options = []) {
        //存放查询结果
        $list = [];

        //将$filter中主键值的类型从字符串转为ObjectId
        if(isset($filter[$this->primary_key])){
            $oid = $this->makeObjectId($filter[$this->primary_key]);
            if(false === $oid)
                return [];
            $filter[$this->primary_key] = $oid;
        }

        $query = new MongoDB\Driver\Query($filter, $options);
        //获得查询结果数组
        $cursor = $this->manager
            ->executeQuery("{$this->db}.{$this->collection}", $query)
            ->toArray();
        foreach ($cursor as $document) {
            //将$document中所有object类型转换为array类型
            $itemArr = Tools::object_array($document);
            if(isset($itemArr[$this->primary_key])){
                //取ObjectID转换成数组后的'oid'值，为字符串类型
                $itemArr[$this->primary_key] = $itemArr[$this->primary_key]['oid'];
            }
            $list[] = $itemArr;
        }

        return $list;
    }

    /**
     * 获取一条记录
     * @param     array            $filter  [description]
     * @param     array            $options [description]
     * @return    array                     [description]
     */
    public function queryOne(array $filter, $options = []){
        if(empty($options) || !isset($options['limit']) || $options['limit'] != 1) {
            //保证查询结果数量上限为1
            $options['limit'] = 1;
        }

        $list = (array)$this->query($filter, $options);
        if(!empty($list)) {
            //若非空返回结果（类型为数组）
            return $list[0];
        }
        return [];
    }

    /**
     * 约束字段为已定义字段（主键为已定义字段），过滤掉未定义字段
     * @param     array           $fields 需要过滤的字段
     * @return    array                   [description]
     */
    protected function filterFields($fields){
        if(empty($fields)) {
            return [];
        }

        $newFields = [];
        foreach ($fields as $key => $value) {
            if($value == $this->primary_key){
                $newFields[$value] = 1;
                continue;
            }

            if(isset($this->fields[$value])) {
                $newFields[$value] = 1;
            }
        }

        return $newFields;
    }

    /**
     * 通过主键 _id 获取一条记录
     * @param     string           $_id    [description]
     * @param     array            $fields [description]
     * @return    [array]                   [description]
     */
    public function getInfoById($_id, array $fields = []){
        $newOptions = [];
        $_id = $this->makeObjectId($_id);

        $where = [
            $this->primary_key => $_id
        ];

        $fields = $this->filterFields($fields);
        if(!empty($fields)) {
            $newOptions['projection'] = $fields;
        }
        //查询主键_id对应记录并投影（只返回）fields指定的字段
        return $this->queryOne($where, $newOptions);
    }

    /**
     * 日志记录
     * @param  string $msg [description]
     * @return [type]      [description]
     */
    public static function log($msg = '') {
        $file = 'mongodb_error_' . date('Y-m-d');
        $line = '===================' . date('Y-m-d H:i:s') . '===================';
        Log::writeLog($file, $line, '');
        Log::writeLog($file, 'Info', $msg);
    }

    /**
     * 删除数据库
     * 返回删除结果
     */
    public static function dropDatabase() {
        //连接数据库
        $m = new MongoDB\Driver\Manager('mongodb://127.0.0.1:27017');
        //集合数组
        $arr = ['administrator', 'award','competition','match','school','student'];
        //遍历删除集合
        foreach ($arr as $key => $value) {
            try {
                $m->executeCommand('student_competition_system', new \MongoDB\Driver\Command(["drop" => $value]));
            } catch (Exception $exception) {
                self::log($exception->getMessage());
            }
        }
    }
}
?>