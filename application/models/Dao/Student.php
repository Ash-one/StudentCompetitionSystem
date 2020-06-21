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

        //设置集合
        $this->collection = 'student';
        //设置字段
        $this->fields = [
            'student_name'=>'',
            'student_id'=>'',
            'student_grade'=>'',
            'student_sex'=>'',
            'school_object_id'=>'',
            'student_competition_details'=>[],
            'student_award_details'=>[]
        ];
        //设置主键字段
        $this->primary_key = '_id';
        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["student_name"=>"姜小兰", "student_id"=>"4010101", "student_grade"=>"41",
                "student_sex"=>0, "school_object_id"=>"", "student_competition_details"=>[], "student_award_details"=>[]]);
        }

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