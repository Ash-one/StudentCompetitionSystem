<?php
/**
 * SchoolModel
 * @author guoyi
 */
class Dao_SchoolModel extends Db_Mongodb implements Service_ISchoolModel {
    /**
     * Db_SchoolModel constructor.
     */
    protected function __construct()
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
        // $filter = [];
        // $result = $this->query($filter);
        // foreach ($result as $document) {
        //     print_r($document);
        // }
    }

    /**
     * 实现单例模式（线程不安全）
     *
     * @return Dao_SchoolModel
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_SchoolModel();
        }

        return self::$instance;
    }
}
?>