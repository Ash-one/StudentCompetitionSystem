<?php

/**
 * AdministratorModel
 * @author guoyi
 */
class Dao_AdministratorModel extends Db_Mongodb {
    /**
     * Db_AdministratorModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'administrator';
        //设置字段
        $this->fields = [
            'administrator_name'=>'',
            'password'=>''
        ];
        //设置主键字段
        $this->primary_key = '_id';
        if($this->count() == 0)
        {
            //空集合插入记录
            $this->insert(["administrator_name"=>"admin", "password"=>"24819090"]);
        }

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.administrator', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>