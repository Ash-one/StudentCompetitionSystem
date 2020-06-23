<?php

/**
 * AdministratorModel
 * @author guoyi
 */
class Dao_AdministratorModel extends Db_Mongodb {
    /**
     * Db_AdministratorModel constructor.
     */
    public function __construct()
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
            $this->insert(["administrator_name"=>"admin", "password"=>"24819090"]);
        }

        $this->update(['administrator_name'=>'admin'],['password'=>'123456']);

        //查询结果
        $filter = [];
        $result = $this->query($filter);
        foreach ($result as $document) {
            print_r($document);
        }
    }
}
?>