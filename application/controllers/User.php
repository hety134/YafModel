<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-06-26
 * Time: 11:05
 */
class UserController extends BaseController
{
    private $_layout;
    public $_debug;

    public function init()
    {
        parent::init();
        $this->_config = Yaf_Registry::get('config');
        $this->_layout = Yaf_Registry::get('layout');
        $this->_debug = Yaf_Registry::get('debug');
        $this->_layout->meta_title = '用户';
        $this->_layout->moduleName = '用户';
    }

    public function indexAction(){
        $this->_view->name = "hello yaf";
    }

    public function showAction(){
        Yaf_Dispatcher::getInstance()->disableView();//关闭框架子自带视图模板输出
        DB::connection()->enableQueryLog();
        $msg = DB::table('users')->get();
        $msg = UsersModel::all();
        //dd($msg);
        $log = DB::getQueryLog();
        $loger = new Logs();
        $loger->info("query log",['log'=>$log]);   //打印sql语句
    }

    public function dataAction(){
        Yaf_Dispatcher::getInstance()->disableView();//关闭框架子自带视图模板输出
        //header("Content-type:text/html;charset=utf-8");
        //yaf判断当前是否为get请求
        if($this->getRequest()->isGet()){
            echo "当前是get请求";
        }
        var_dump( $this->getRequest()->getQuery('code',0));//获取get 参数
        //yaf判断当前是否为post请求
        if($this->getRequest()->isPost()){
            echo "当前是post请求";
        }
        var_dump( $this->getRequest()->getPost('code',0));//获取post 参数
        //yaf文件上传操作,$this->getRequest()->getFiles()等同于原生php文件上传中的$_FILES函数
        if($file = $this->getRequest()->getFiles()){
            //var_dump($file);
            //move_uploaded_file()
            //...
        }
        echo $this->getRequest()->getMethod();
        echo $this->getRequest()->getServer('REMOTE_ADDR');
    }
}