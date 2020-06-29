<?php
/**
 * AwardModel
 * @author guoyi
 */
class Dao_AwardModel extends Db_Mongodb {
    protected static $instance = null;
    
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
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_AwardModel();
        }

        return self::$instance;
    }
}
?>