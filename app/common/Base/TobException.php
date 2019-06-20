<?php
namespace App\common\Base;
use Throwable;

class TobException extends \Exception
{
    const ERR_UNKNOWN = 159999;
    const ERR_NO_PRIVILEGE = 159998;
    const ERR_NO_OBJECT = 159997;
    const ERR_TOKEN_EXPIRED = 159996;
    const ERR_PARAMS = 159995;
    const ERR_RPC = 159994;
    const ERR_NO_MOBILE_PRIVILEGE = 159993;
    const ERR_INTERVIEW_ONE = 150431;
    const ERR_INTERVIEW_TWO = 150432;
    const CENTER_MESSAGE_INTERVIEW_NO_WORK = 150403;
    const CENTER_MESSAGE_INTERVIEW_IN_WORK = 150011;
    const ERR_CHANGED = 159980;
    const ERR_CANCELED = 159981;
    const ERR_NOT_START = 159982;
    const ERR_MUST_BE_INHERIT = 159982;
    const ERR_NOT_INVIT = 150012;
    const ERR_NOT_COMMON_DATABASE = 159970;
    const ERR_CODE_MAP = [
        159999 => '未知错误',
        159998 => '无此权限',
        159997 => '对象找不到',
        159996 => '访问已过期',
        159995 => '参数错误',
        159994 => 'rpc请求失败',
        159993 => '无此权限',
        159990 => '系统错误',
        159983 => '请实现我',
        159970 => '寻库错误，非法通用库的使用！',

        159980 => '面试已变更，请前往新的面试邮件中填写',
        159981 => '面试已取消',
        159982 => '面试时间未开始，不可填写面试评价',

        150431 => '视频面试/语音面试不支持多位候选人或多位面试官选择！',
        150432 => '面试变更不支持批量',
        150403 => '您未发起相关面试，或者相关面试已结束',
        150011 => '候选人正处于面试中，不能发起新的面试！',
        150012 => '候选人未发起面试！',
        150013 => '您的面试已过期！',

        160001 => '该候选人有正在进行中的bot约面',
        160002 => '该候选人在不在面试阶段',
        160003 => '小程序登录失败',
        160004 => '您扫描的二维码已被绑定到其他微信用户。如果您之前有分享过该二维码，请让对应的微信用户帮您查看进展哦',
        160005 => '公众号消息模板不存在',
        160006 => '候选人有正在进行中的面试',
        160007 => '候选人没有手机号或邮箱',


    ];

    public function __construct($message, $code, Throwable $previous = null)
    {
        if(!$code){
            $code = self::ERR_UNKNOWN;
        }
        parent::__construct($message, $code, $previous);
    }

    protected $trace;

    public function getLastTrace(){
        return $this->trace;
    }

    public function setLastTrace($trace){
        $this->trace = $trace;
    }

    static function error($code, $exMessage = ''){
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        dd(get_class_vars(static::class));

        $message = self::getErrMsg($code);

        $exception = new self($message. " ". $exMessage, $code);
        $exception->setLastTrace($traces[0]);
        //var_dump($exception->getFile());
        return $exception;
    }

    static function errorMsg($code, $exMessage = ''){
        $traces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $exception = new self($exMessage, $code);
        $exception->setLastTrace($traces[0]);
        return $exception;
    }

    private static function getErrMsg($code){
        $codeMap = static::getCodeMap();
        if(!isset($codeMap[$code])){
            return "未定义的错误码[{$code}]";
        }
        return $codeMap[$code];
    }

    protected static function getCodeMap(){
        return self::ERR_CODE_MAP;
    }

    public static function assert($value, $code, $message=''){
        if(value($value)){
            return null;
        }

        throw static::error($code, $message);
    }

    public static function assertParam($value, $message=''){
        return static::assert($value, self::ERR_PARAMS, $message);
    }
}
