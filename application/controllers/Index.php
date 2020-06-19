<?php
/**
 * @name IndexController
 * @author kuroki
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends JsonControllerAbstract {
    /**
     * 默认初始化方法，如果不需要，可以删除掉这个方法
     * 如果这个方法被定义，那么在Controller被构造以后，Yaf会调用这个方法
     */
    public function init() {
		parent::init();

		$this->getView()->assign("header", "Yaf Example");
		$administrator_model = new Dao_AdministratorModel();
		$student_model = new Dao_StudentModel();
		$school_model = new Dao_SchoolModel();
		$competition_model = new Dao_CompetitionModel();
		$match_model = new Dao_MatchModel();
		$award_model = new Dao_AwardModel();
    }

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/testApp/index/index/index/name/kuroki 的时候, 你就会发现不同
     */
	public function indexAction($name = "World!") {
		$result = array("name" => $name);
		$this->jsonResponse->setBody($name);

        return FALSE;
	}
}
