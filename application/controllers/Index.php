<?php
/**
 * @name IndexController
 * @author kuroki
 * @desc 默认控制器
 */
include (dirname(__DIR__).'/library/ExcelParser.php');
include (dirname(__DIR__).'/library/JsonControllerAbstract.php');
class IndexController extends JsonControllerAbstract {
    public function init() {
		parent::init();

		// Db_Mongodb::dropDatabase();
		// $admin = Dao_AdministratorModel::getInstance()->query([]);
		// print_r($admin);
		// ExcelParser::read(APPLICATION_PATH . "/SCS基础数据表.xlsx");

		// $competitions = Dao_CompetitionModel::getInstance()->query([]);
		// print_r($competitions);
    }

	public function indexAction($name = "World!") {
		if (!$_SESSION["admin"]) {
            $json = APIStatusCode::getErrorMsgJson(APIStatusCode::NOT_LOGIN_ERROR);
            // 设置 response
		    $this->jsonResponse->setBody($json);
            return FALSE;
		}
		
		echo "success";

        return FLASE;
	}
}
