<?php
/**
 * MatchModel
 * @author guoyi
 */
class Dao_MatchModel extends Db_Mongodb {
    /**
     * Db_MatchModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //清空集合administrator
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete([]);
        //插入数据
        $bulk->insert(["match_name"=>"仰卧起坐（大学组）", "match_time"=>"1580886000", "match_student_details"=>[],
            "match_belong_competition"=>""]);
        $this->manager->executeBulkWrite('student_competition_system.match', $bulk);

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.match', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>
