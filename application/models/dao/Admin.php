<?php

/**
 * AdminModel
 * @author guoyi
 */
class Dao_AdminModel extends Db_Mongodb {
    /**
     * Db_AdminModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //清空集合administrator
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        //插入数据
        $bulk->insert(["administrator_name"=>"admin", "password"=>"24819090"]);
        $this->manager->executeBulkWrite('student_competition_system.administrator', $bulk);

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