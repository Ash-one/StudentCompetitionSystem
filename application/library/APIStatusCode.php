<?php
/**
 * @name APIStatusCode
 * @author kuroki
 * @desc 用于创建一个 API json 返回中的有关状态码的数据
 */
class APIStatusCode {
    static private $status_ok = array('status' => 0, 'msg' => 'ok');
    static private $status_error = array('status' => 1);

    // 系统错误码
    const UNABLE_API = 101;
    // API 错误码
    const NULL_PARAMS = 201;
    const RESULT_NOT_EXIST = 202;
    const JSON_ENCODE_ERROR = 203;

    static private $errorCodeDictionary = array(
        // 系统错误码
        self::UNABLE_API => '接口目前不可用',

        // API 错误码
        self::NULL_PARAMS => '必需参数为空',
        self::RESULT_NOT_EXIST => '搜索结果不存在',
        self::JSON_ENCODE_ERROR => 'json_encode 错误：'
    );

    static public function getOkMsgArray() {
        return self::$status_ok;
    }

    static public function getErrorMsgJson($errorCode, $appendMsg = "") {
        $result = self::$status_error;
        $result['code'] = $errorCode;
        $result['msg'] = self::$errorCodeDictionary[$errorCode] . $appendMsg;

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}