<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018-06-26
 * Time: 10:20
 */
// 程序启动时间
//define('APP_START_TIME', microtime(true));
define('DEBUG',1);
define('APPLICATION_PATH', dirname(__FILE__).'/../');

// 加载 Composer
//require APPLICATION_PATH.'/vendor/autoload.php';
function handleError($errorNo, $message, $filename, $lineNo) {
    if (error_reporting () != 0) {
        $type = 'error';
        switch ($errorNo) {
            case 2 :
                $type = 'warning';
                break;
            case 8 :
                $type = 'notice';
                break;
        }
        throw new Exception ( 'PHP ' . $type . ' in file ' . $filename . ' (' . $lineNo . '): ' . $message, 0 );
    }
}

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
