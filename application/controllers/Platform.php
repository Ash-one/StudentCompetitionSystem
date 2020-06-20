<?php
/**
 * @name PlatformController
 * @author kuroki
 * @desc platform 控制器
 */
class PlatformController extends JsonControllerAbstract {
    public function init() {
		parent::init();
    }

    /**
     * @desc Action search，返回（搜索过的）平台界面数据
     *
     * @return FLASE
     */
	public function searchAction() {
        $result = APIStatusCode::getOkMsgArray();
        
        // 获取参数   
        $year = $this->getRequest()->getParam('year');
        $result['year'] = $year;

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
}
