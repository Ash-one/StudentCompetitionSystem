<?php

/**
 * AdministratorModel
 * @author guoyi
 */
class Dao_AdministratorModel extends Db_Mongodb {
    protected static $instance = null;
    
    /**
     * Db_AdministratorModel constructor.
     */
    protected function __construct()
    {
        parent::__construct();

        //设置集合
        $this->collection = 'administrator';
        //设置字段
        $this->fields = [
            'administrator_name'=>'',
            'password'=>''
        ];

        if($this->count() == 0)
        {
            //空集合插入记录
            $this->insert(["administrator_name"=>"baobao", "password"=>md5("516527")]);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_AdministratorModel();
        }

        return self::$instance;
    }
}
?>