<?php
class LayoutPlugin extends Yaf_Plugin_Abstract {

    private $_layoutDir;
    private $_layoutFile;
    private $_layoutTmp;
    private $_layoutVars =array();
    private $request;
    private $response;

    public function __construct($layoutFile, $layoutDir=null){
        $this->_layoutFile = $layoutFile;
        $this->_layoutDir = ($layoutDir) ? $layoutDir : APPLICATION_PATH.'views/';
    }

    public function  __set($name, $value) {
        $this->_layoutVars[$name] = $value;
    }

    public function dispatchLoopShutdown ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }

    public function dispatchLoopStartup ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * [setLayoutFile ÉèÖÃlayoutÎÄ¼þ]
     * @param [type] $layoutfile [description]
     */
    public function setLayout($flag = "layout.phtml"){

        if($flag){
            $this->_layoutTmp = $flag;
        }else{
            $this->_layoutTmp = "";
        }

    }

    public function postDispatch ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

        $body = $this->response->getBody();

        $layout = new Yaf_View_Simple($this->_layoutDir);
        $layout->content = $body;
        $layout->assign('layout', $this->_layoutVars);

        /* set the response to use the wrapped version of the content */
        //如果设置了默认模版，则打印执行LAYOUT
        if($this->_layoutTmp){
            $this->response->clearBody();
            $this->response->setBody($layout->render($this->_layoutTmp));
        }


    }
    public function preDispatch ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
        //首先设置默认的LAYOUT模版
        $this->_layoutTmp = "layout.phtml";

    }

    public function preResponse ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){


    }

    public function routerShutdown ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }

    public function routerStartup ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }
}