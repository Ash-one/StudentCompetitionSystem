<?php
/**
 * @name IndexController
 * @author kuroki
 * @desc 默认控制器
 */
include (dirname(__DIR__).'\library\ExcelParserTool.php');
class IndexController extends JsonControllerAbstract {
    public function init() {
		parent::init();

		$this->getView()->assign("header", "Yaf Example");
		$administrator_model = new Dao_AdministratorModel();
		$student_model = new Dao_StudentModel();
		$school_model = new Dao_SchoolModel();
		$competition_model = new Dao_CompetitionModel();
		$match_model = new Dao_MatchModel();
		$award_model = new Dao_AwardModel();

        ExcelParser::read();

    }

	public function indexAction($name = "World!") {
		$result = array("name" => $name);
		$this->jsonResponse->setBody($name);

        return FALSE;
	}
}
