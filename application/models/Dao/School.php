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

        //设置集合
        $this->collection = 'school';
        //设置字段
        $this->fields = [
            'school_name'=>'',
            'school_competition_details'=>[],
            'school_award_details'=>[],
            'school_students'=>[]
        ];
        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["school_name"=>"中国传媒大学", "school_competition_details"=>[], "school_award_details"=>[],
                "school_students"=>[]]);
        }

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