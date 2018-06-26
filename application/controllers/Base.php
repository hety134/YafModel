<?php


class BaseController extends Yaf_Controller_Abstract
{
    public function init(){
        
    }

    public function isPost()
    {
        return $this->getRequest()->isPost();
    }
    
    public function getParam( $name,$default = '' )
    {
        $value =  $this->getRequest()->getParam($name);

        if ($value === null) {
            $value = $default;
        }

        return $value;
    }
    
    public function getQuery($name, $default = '')
    {
        $value = $this->getRequest()->getQuery($name);
        if ($value === null) {
            $value = $default;
        }

        return $value;
    }

    public function getPost($name, $default = '')
    {
        $bug = $this->getQuery( 'debug',0 );
        
        if ( $bug == 1 )
        {
            return $this->getQuery( $name, $default );
        }
        
        $value = $this->getRequest()->getPost($name);
        if ($value === null) {
            $value = $default;
        }

        return $value;
    }


    public function respon( $success = 0 , $res  )
    {
        $result['success'] = $success; 
        
        if( $success )
        {
            $result['data'] = $res;
        }
        else
        {
            $result['error'] = $res;
        }

//         if ( Yaf\Application::app()->getConfig()->get('dev')->get('debug') == 1 )
//         {
//             //Util::dump( $result );
//         }
        header("Content-Type: application/json; charset=utf-8");
        exit( json_encode( $result ) );
    }

    public function error($error = '', $errno = 0)
    {

    }

    public function flash($url = '/', $message = '', $second = 2)
    {

    }

    /**
     * 返回中文信息调用
     * @param $key 对应的错误信息编码
     */
    public function returnInfo ( $key )
    {
        $msg = Msg::msginfo( $key );
        return $msg;
    }

}