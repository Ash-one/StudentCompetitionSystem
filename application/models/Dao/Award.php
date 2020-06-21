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

        //设置集合
        $this->collection = 'award';
        //设置字段
        $this->fields = [
            'competition_object_id'=>'',
            'match_object_id'=>'',
            'award_type'=>'',
            'student_object_id'=>'',
            'school_object_id'=>'',
            'award_rank'=>''
        ];
        //设置主键字段
        $this->primary_key = '_id';
        if($this->count() == 0) {
            //空集合插入记录
            $this->insert(["competition_object_id"=>"", "match_object_id"=>"", "award_type"=>1,
                "student_object_id"=>"", "school_object_id"=>"", "award_rank"=>1]);
        }

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