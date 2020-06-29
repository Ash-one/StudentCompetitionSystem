<?php
/**
 * MatchModel
 * @author guoyi
 */
class Dao_MatchModel extends Db_Mongodb {
    protected static $instance = null;
    
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

    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_MatchModel();
        }

        return self::$instance;
    }
}
?>
