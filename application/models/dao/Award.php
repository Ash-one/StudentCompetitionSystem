<?php
/**
 * AwardModel
 * @author guoyi
 */
class Dao_AwardModel extends Db_Mongodb {
    /**
     * Db_AwardModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //清空集合administrator
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        //插入数据
        $bulk->insert(["competition_object_id"=>"", "match_object_id"=>"", "award_type"=>1,
            "student_object_id"=>"", "school_object_id"=>"", "award_rank"=>1]);
        $this->manager->executeBulkWrite('student_competition_system.award', $bulk);

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.award', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>