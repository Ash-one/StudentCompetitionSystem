<?php
/**
 * @name PlatformController
 * @author kuroki
 * @desc platform 控制器
 */
class PlatformController extends JsonControllerAbstract {
    private $platformService = null;

    public function init() {
        parent::init();
        
        $this->platformService = new Service_PlatformModel();
    }

    /**
     * @desc Action getOverview，返回平台界面数据
     *
     * @return FLASE
     */
	public function getOverviewAction() {
        $result = APIStatusCode::getOkMsgArray();

        $result['result'] = $this->platformService->getPlatformOverview();
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
