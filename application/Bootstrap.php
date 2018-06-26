<?php

use Illuminate\Events\Dispatcher as LDispatcher;
use Illuminate\Container\Container as LContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use DebugBar\StandardDebugBar;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-06-26
 * Time: 10:32
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public $config;

    // 初始化配置
    public function _initConfig()
    {
        $this->config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->config);
    }

    public function _initErrors()
    {
        if ($this->config->application->showErrors) {
            error_reporting(-1);
            /*报错是否开启，On开启*/
            ini_set('display_errors', 'On');
            set_error_handler('handleError', E_ALL);
        } else {
            error_reporting(0);
            ini_set('display_errors', 'Off');
            set_error_handler('handleError', E_ALL);
        }
    }

    /**
     * 加载vendor下的文件
     */
    public function _initLoader()
    {
        set_error_handler([$this, "onError"]);
        register_shutdown_function(array($this, 'cleanup'));

        Yaf_Loader::import(APPLICATION_PATH . '/vendor/autoload.php');
        Yaf_Loader::import(APPLICATION_PATH . "/application/function.php");
    }

    /**
     * 初始化数据库分发器
     * @function _initDefaultDbAdapter
     * @author   jsyzchenchen@gmail.com
     */
    public function _initDefaultDbAdapter()
    {
        //初始化 illuminate/database
        $capsule = new Capsule();
        $db_info = Yaf_Application::app()->getConfig()->database->toArray();
        $capsule->addConnection($db_info['mysql'],"default");
        $capsule->addConnection($db_info['back-mysql'],"back");
        $capsule->setEventDispatcher(new LDispatcher(new LContainer));
        $capsule->setAsGlobal();
        //开启Eloquent ORM
        $capsule->bootEloquent();
        class_alias('\Illuminate\Database\Capsule\Manager', 'DB');

    }

    public function _initDebug(Yaf_Dispatcher $dispatcher)
    {
        $debug = new DebugPlugin();
        Yaf_Registry::set('debug', $debug);
        $dispatcher->registerPlugin($debug);
    }

    public function _initLayout(Yaf_Dispatcher $dispatcher)
    {
        $this->_layout = new LayoutPlugin($this->config->application->document, $this->config->application->layoutpath);
        $this->_layout->debug = DEBUG;
        Yaf_Registry::set('layout', $this->_layout);
        $dispatcher->registerPlugin($this->_layout);
    }

    public function onError($severity, $message, $file, $line)
    {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }

    public function cleanup()
    {

        restore_error_handler();

        // 捕获fatal error
        $e = error_get_last();
        if ($e['type'] == E_ERROR) {
            $str = <<<TYPEOTHER
[message] {$e['message']}
[file] {$e['file']}
[line] {$e['line']}
TYPEOTHER;
            // todo 发送邮件、短信、写日志报警……
        }

        // 定义了开关，便关闭log
        if (!defined('SHUTDOWN')) {
            $log = new Logs();

            if ($e['type'] == E_ERROR) {
                $log->error( var_export($_REQUEST, true) . $str);
            }

            // DEFAULT
            /*if(defined('DEFAULT')){
                $log->info("query log",Capsule::getQueryLog());
            }

            // 业务库相关SQL
            if (defined('ANOTHER'))
                $log->info("another query log",Capsule::connection(ANOTHER)->getQueryLog());*/
        }

    }
}