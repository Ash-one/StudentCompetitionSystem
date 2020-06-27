<?php
/**
 * @name CompetitionsController
 * @author kuroki
 * @desc competitons 控制器
 */
class CompetitionsController extends JsonControllerAbstract {
    private $competitionService = null;

    public function init() {
        parent::init();

        $this->competitionService = Dao_CompetitionModel::getInstance();
    }

    /**
     * @desc Action getOverview，返回竞赛一级界面数据
     *
     * @return FLASE
     */
	public function getOverviewAction() {
        $result = APIStatusCode::getOkMsgArray(); 

        $result['result'] = $this->competitionService->getCompetitonOverview();

        // 编码为 json
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
        // 处理 json_encode 错误
        if ($json == false) {
            $error = json_last_error_msg();
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::JSON_ENCODE_ERROR, $error);
        }
        
        // 设置 response
		$this->jsonResponse->setBody($json);

        return FALSE;
    }
    
    /**
     * @desc Action getInfo，返回指定 name, year 竞赛的相关信息
     *
     * @return FLASE
     */
    public function getInfoAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $name = urldecode($this->getRequest()->getParam('name'));
        $year = $this->getRequest()->getParam('year');
     
        if ($name != null && $year != null) {
            // 获取数据
            $result['result'] = $this->competitionService->getCompetionInfo($name, $year);

            // 处理搜索结果不存在错误
            if ($result['result'] === null) {
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::RESULT_NOT_EXIST);

                // 设置 response 并返回
                $this->jsonResponse->setBody($json);
                return FALSE;
            }

            // 编码为 json
            $json = json_encode($result, JSON_UNESCAPED_UNICODE);
            // 处理 json_encode 错误
            if ($json == false) {
                $error = json_last_error_msg();
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::JSON_ENCODE_ERROR, $error);
            }
        } else {
            // 处理必要参数为空
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NULL_PARAMS);
        }    
    
        // 设置 response
		$this->jsonResponse->setBody($json);

        return FALSE;
    }

    /**
     * @desc Action getDetail，返回指定 name, year 竞赛的全部项目详情
     *
     * @return FLASE
     */
    public function getDetailAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $name = urldecode($this->getRequest()->getParam('name'));
        $year = $this->getRequest()->getParam('year');
     
        if ($name != null && $year != null) {
            $result['result'] = $this->competitionService->getCompetitionMatchesDetail($name, $year);

            // 处理搜索结果不存在错误
            if ($result['result'] === null) {
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::RESULT_NOT_EXIST);

                // 设置 response 并返回
                $this->jsonResponse->setBody($json);
                return FALSE;
            }

            // 编码为 json
            $json = json_encode($result, JSON_UNESCAPED_UNICODE);
            // 处理 json_encode 错误
            if ($json == false) {
                $error = json_last_error_msg();
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::JSON_ENCODE_ERROR, $error);
            }
        } else {
            // 处理必要参数为空
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NULL_PARAMS);
        }    
    
        // 设置 response
		$this->jsonResponse->setBody($json);

        return FALSE;
    }

    /**
     * @desc Action getContestantOverview，返回指定竞赛的全部学生详情
     *
     * @return FLASE
     */
    public function getContestantOverviewAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $name = urldecode($this->getRequest()->getParam('name'));
        $year = $this->getRequest()->getParam('year');
     
        if ($name != null) {
            $result['result'] = $this->competitionService->getCompetitionContestantsInfo($name, $year);

            // 处理搜索结果不存在错误
            if ($result['result'] === null) {
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::RESULT_NOT_EXIST);

                // 设置 response 并返回
                $this->jsonResponse->setBody($json);
                return FALSE;
            }
            
            // 编码为 json
            $json = json_encode($result, JSON_UNESCAPED_UNICODE);
            // 处理 json_encode 错误
            if ($json == false) {
                $error = json_last_error_msg();
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::JSON_ENCODE_ERROR, $error);
            }
        } else {
            // 处理必要参数为空
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NULL_PARAMS);
        }    
    
        // 设置 response
		$this->jsonResponse->setBody($json);

        return FALSE;
    }

    public function uploadExcelDataAction() {
        $result = APIStatusCode::getOkMsgArray();

        // 初始化日志信息
        $logFile = 'upload_' . date('Y-m-d');
        $line = '===================' . date('Y-m-d H:i:s') . '===================';
        Log::writeLog($logFile, $line, '');

        print_r($this->getRequest()->getMethod());
        print_r($this->getRequest()->getFiles());
        print_r($this->getRequest()->getPost());
        // 获取参数
        $file = $this->getRequest()->getFiles()['excel'];

        if ($file != null) {
            // TODO: 验证文件格式


            if ($file["error"] > 0) {
                // 处理上传文件 error
                $json = APIStatusCode::getErrorMsgJson(APIStatusCode::EXCEL_UPLOAD_ERROR, $file['error']);
                Log::writeLog($logFile, 'Error: ', $file['error']);
            }
            else {
                // 上传成功
                Log::writeLog($logFile, 'Upload: ', $file['name']);
                Log::writeLog($logFile, 'Type: ', $file['type']);
                Log::writeLog($logFile, 'Size: ', $file['size'] / 1024 . 'kb');

                //处理 excel
                $this->competitionService->saveData($file['tmp_name']);
            }
        } else {
            // 处理必要参数为空
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NULL_PARAMS, " 未能获取到表单 excel 提交的内容");
            Log::writeLog($logFile, 'Error: ', "未能获取到表单 excel 提交的内容");
        } 

        // 设置 response
		$this->jsonResponse->setBody($json);

        return FALSE;
    }
}
