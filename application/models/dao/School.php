<?php
/**
 * SchoolModel
 * @author guoyi
 */
class Dao_SchoolModel extends Db_Mongodb {
    /**
     * Db_SchoolModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //清空集合administrator
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        //插入数据
        $bulk->insert(["school_name"=>"中国传媒大学", "school_competition_details"=>[], "school_award_details"=>[],
            "school_students"=>[]]);
        $this->manager->executeBulkWrite('student_competition_system.school', $bulk);

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.school', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>