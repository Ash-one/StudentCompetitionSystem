<?php
/**
 * @name SchoolsController
 * @author kuroki
 * @desc schools 控制器
 */
class SchoolsController extends JsonControllerAbstract {
    private $schoolService;

    public function init() {
        parent::init();
        
        $this->schoolService = Dao_SchoolModel::getInstance();
    }

    /**
     * @desc Action getOverview，返回学校一级界面数据
     *
     * @return FLASE
     */
	public function getOverviewAction() {
        $result = APIStatusCode::getOkMsgArray();

        $result['result'] = $this->schoolService->getSchoolOverview();

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
     * @desc Action getInfo，返回指定 name 学校的相关信息
     *
     * @return FLASE
     */
    public function getInfoAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $name = urldecode($this->getRequest()->getParam('name'));
        $result['name'] = $name;
     
        if ($name != null) {
            $result['result'] = $this->schoolService->getSchoolInfo($name);

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
     * @desc Action getDetail，返回指定 name 学校的数据详情
     *
     * @return FLASE
     */
    public function getDetailAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数
        $name = urldecode($this->getRequest()->getParam('name'));
        $result['name'] = $name;
     
        if ($name != null) {
            $result['result'] = $this->schoolService->getSchoolAwardsDetail($name);

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
