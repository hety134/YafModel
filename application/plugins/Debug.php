<?php
/**
 * Created by PhpStorm.
 * User: huangtuo
 * Date: 16/6/13
 * Time: 下午7:19
 */

use Illuminate\Database\Capsule\Manager as Capsule;
use DebugBar\StandardDebugBar;

/**
 * Created by PhpStorm.
 */
class DebugPlugin extends Yaf_Plugin_Abstract
{
    private $debugbar;
    private $debugbarRenderer;

    //在路由之前触发，这个是7个事件中, 最早的一个. 但是一些全局自定的工作, 还是应该放在Bootstrap中去完成
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    //路由结束之后触发，此时路由一定正确完成, 否则这个事件不会触发
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    //分发循环开始之前被触发
    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    //分发之前触发    如果在一个请求处理过程中, 发生了forward, 则这个事件会被触发多次
    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        //echo "4Plugin PreDispatch called <br/>\n";
        $this->_layout = Yaf_Registry::get('layout');
        $this->debugbar = new StandardDebugBar();
        $this->debugbarRenderer = $this->debugbar->getJavascriptRenderer()->setBaseUrl('../src/DebugBar/Resources')
            ->setEnableJqueryNoConflict(false);

    }

    public function setMessage($jsonstr, $type = '')
    {
        $this->debugbar["messages"]->addMessage($jsonstr, $type);
        //$this->debugbar->stackData();
    }


    //设置开始时间
    public function startTime($key, $value)
    {
        $this->debugbar["time"]->startMeasure($key, $value);
    }

    public function endTime($key)
    {
        $this->debugbar["time"]->stopMeasure($key);
    }

    //分发结束之后触发，此时动作已经执行结束, 视图也已经渲染完成. 和preDispatch类似, 此事件也可能触发多次
    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $sql = Capsule::getQueryLog();
        $this->debugbar["messages"]->addMessage($sql);
        $this->_layout->debugbarRenderer = $this->debugbarRenderer;
        //$debugbar["messages"]->addMessage($sql);
    }

    //分发循环结束之后触发，此时表示所有的业务逻辑都已经运行完成, 但是响应还没有发送
    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    public function preResponse(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }
}