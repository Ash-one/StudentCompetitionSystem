<?php
/**
 * CompetitionModel
 * @author guoyi
 */
class Dao_CompetitionModel extends Db_Mongodb {
    /**
     * Db_CompetitionModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'competition';
        //设置字段
        $this->fields = [
            'competition_name'=>'',
            'competition_start_time'=>'',
            'competition_end_time'=>'',
            'competition_participating_schools'=>[],
            'competition_participating_students'=>[],
            'competition_award_details'=>[],
            'competition_match_items'=>''
        ];
        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["competition_name"=>"北京市大学生运动会", "competition_start_time"=>"1580864400", "competition_end_time"=>"1581238800",
                "competition_participating_schools"=>[], "competition_participating_students"=>[], "competition_award_details"=>[], "competition_match_items"=>[]]);
        }

        //查询结果
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery('student_competition_system.competition', $query);

        foreach ($cursor as $document) {
            print_r($document);
        }

    }
}
?>