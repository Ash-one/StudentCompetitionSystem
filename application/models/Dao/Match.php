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

//        if($this->count() == 0){
//            //空集合插入记录
//            $this->insert(["match_name"=>"仰卧起坐（大学组）", "match_time"=>"1580886000", "match_student_details"=>[],
//                "match_belong_competition"=>""]);
//        }

        //查询结果
        $filter = [];
        $result = $this->query($filter);
        foreach ($result as $document) {
            print_r($document);
        }

    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_MatchModel();
        }

        return self::$instance;
    }
}
?>
