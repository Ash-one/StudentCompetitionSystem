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

        //设置集合
        $this->collection = 'match';
        //设置字段
        $this->fields = [
            'match_name'=>'',
            'match_time'=>'',
            'match_student_details'=>[],
            'match_belong_competition'=>''
        ];
        //设置主键字段
        $this->primary_key = '_id';
        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["match_name"=>"仰卧起坐（大学组）", "match_time"=>"1580886000", "match_student_details"=>[],
                "match_belong_competition"=>""]);
        }

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
