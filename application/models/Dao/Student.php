<?php
/**
 * StudentModel
 * @author guoyi
 */
class Dao_StudentModel extends Db_Mongodb {
    /**
     * Db_StudentModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //清空集合administrator
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        //插入数据
        $bulk->insert(["student_name"=>"姜小兰", "student_id"=>"4010101", "student_grade"=>"41",
            "student_sex"=>0, "school_object_id"=>"", "student_competition_details"=>[], "student_award_details"=>[]]);
        $this->manager->executeBulkWrite('student_competition_system.student', $bulk);

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.student', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>