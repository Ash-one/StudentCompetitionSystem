<?php
/**
 * @name SchoolsController
 * @author kuroki
 * @desc schools 控制器
 */
class SchoolsController extends JsonControllerAbstract {
    public function init() {
		parent::init();
    }

    /**
     * @desc Action search，返回（搜索过的）学校一级界面数据
     *
     * @return FLASE
     */
	public function searchAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数    
        $year = $this->getRequest()->getParam('year');
        $keyword = urldecode($this->getRequest()->getParam('keyword'));
        $result['year'] = $year;
        $result['keyword'] = $keyword;

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
        $year = $this->getRequest()->getParam('year');
        $keyword = urldecode($this->getRequest()->getParam('keyword'));
        $result['name'] = $name;
        $result['yaer'] = $year;
        $result['keyword'] = $keyword;
     
        if ($name != null) {


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
