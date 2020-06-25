<?php
/**
 * CompetitionModel
 * @author guoyi
 */
class Dao_CompetitionModel extends Db_Mongodb implements Service_ICompetitionModel{
    /**
     * Db_CompetitionModel constructor.
     */
    protected function __construct()
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
            'competition_match_items'=>[]
        ];

        if($this->count() == 0){
            //空集合插入记录
            $this->insert(["competition_name"=>"北京市大学生运动会", "competition_start_time"=>"1580864400", "competition_end_time"=>"1581238800",
                "competition_participating_schools"=>[], "competition_participating_students"=>[], "competition_award_details"=>[], "competition_match_items"=>[]]);
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
     * @return Dao_CompetitionModel
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Dao_CompetitionModel();
        }

        return self::$instance;
    }

    public function uploadExcelData() {
        $result = APIStatusCode::getOkMsgArray();

        // 初始化日志信息
        $logFile = 'upload_' . date('Y-m-d');
        $line = '===================' . date('Y-m-d H:i:s') . '===================';
        Log::writeLog($file, $line, '');

        // 获取参数
        $file = $this->getRequest()->getFiles()['excel'];

        if ($file != null) {
            // TODO: 验证文件格式
            $file_extension = strtolower ( array_pop ( $file_array ) );
            if($file_extension!="xls"||$file_extension!="xlsx"){
                //不是表格文件

            }


            if ($file["error"] > 0) {
                // 处理上传文件 error
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::EXCEL_UPLOAD_ERROR, $file['error']);
                Log::writeLog($file, 'Error: ', $file['error']);
            }
            else {
                // 上传成功
                Log::writeLog($file, 'Upload: ', $file['name']);
                Log::writeLog($file, 'Type: ', $file['type']);
                Log::writeLog($file, 'Size: ', $file['size'] / 1024 . 'kb');

                //TODO: 处理 excel
            }
        } else {
            // 处理必要参数为空
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NULL_PARAMS, " 未能获取到表单 excel 提交的内容");
            Log::writeLog($file, 'Error: ', "未能获取到表单 excel 提交的内容");
        }   
    }
}
?>