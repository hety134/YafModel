<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-06-26
 * Time: 10:35
 */
class ErrorController extends Yaf_Controller_Abstract
{
    //从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception) {
        //1. assign to view engine
        $this->getView()->assign("exception", $exception);
        //5. render by Yaf
        $exception = $this->getRequest()->getException();
        try {
            throw $exception;
        } catch (Yaf_Exception_LoadFailed $e) {
            //加载失败
            throw $e;
        } catch (Yaf_Exception $e) {
            //其他错误
            throw $e;
        }
    }
}