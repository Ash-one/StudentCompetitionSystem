<?php
/**
 * @name JsonController
 * @author kuroki
 * @desc 默认返回 json 的控制器
 */
abstract class JsonControllerAbstract extends Yaf_Controller_Abstract {
    protected $jsonResponse;

    public function init() {
        $this->jsonResponse = $this->getResponse();
        $this->jsonResponse->setHeader('Content-Type', 'application/json; charset=utf-8');
	}
}