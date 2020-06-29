<?php
/**
 * @name StudentsController
 * @author kuroki
 * @desc students 控制器
 */
class StudentsController extends JsonControllerAbstract {
    private $studentService;

    public function init() {
        parent::init();
        
        $this->studentService = Dao_StudentModel::getInstance();
    }

    /**
     * @desc Action getOverview，返回学生一级界面数据
     *
     * @return FLASE
     */
	public function getOverviewAction() {
        if (!$_SESSION["admin"]) {
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NOT_LOGIN_ERROR);
            // 设置 response
		    $this->jsonResponse->setBody($json);
            return FALSE;
        }

        $result = APIStatusCode::getOkMsgArray();
        
        $result['result'] = $this->studentService->getStudentOverview();

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
     * @desc Action getInfo，返回指定 id 学生的相关信息
     *
     * @return FLASE
     */
    public function getInfoAction() {
        if (!$_SESSION["admin"]) {
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NOT_LOGIN_ERROR);
            // 设置 response
		    $this->jsonResponse->setBody($json);
            return FALSE;
        }

        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $id = $this->getRequest()->getParam('id');
     
        if ($id != null) {
            $result['result'] = $this->studentService->getStudentInfo($id);

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
     * @desc Action getDetail，返回指定 id 学生的全部奖项详情
     *
     * @return FLASE
     */
    public function getDetailAction() {
        if (!$_SESSION["admin"]) {
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NOT_LOGIN_ERROR);
            // 设置 response
		    $this->jsonResponse->setBody($json);
            return FALSE;
        }

        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数
        $id = $this->getRequest()->getParam('id');
     
        if ($id != null) {
            $result['result'] = $this->studentService->getStudentAwardsDetail($id);

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
     * @desc Action getChartData，返回指定 id 学生的按年度统计信息
     *
     * @return FLASE
     */
    public function getChartDataAction() {
        if (!$_SESSION["admin"]) {
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NOT_LOGIN_ERROR);
            // 设置 response
		    $this->jsonResponse->setBody($json);
            return FALSE;
        }
        
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数
        $id = $this->getRequest()->getParam('id');
     
        if ($id != null) {
            $result['result'] = $this->studentService->getStudentChartDataDetail($id);

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
}
