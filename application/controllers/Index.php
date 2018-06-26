<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-06-26
 * Time: 10:39
 */
class IndexController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        $this->getView()->assign("content","hello Yaf");
    }
}