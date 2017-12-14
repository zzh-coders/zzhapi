<?php
/**
 * 文件说明
 *
 * @filename    test_searcch.php
 * @author      zouzehua<zzh787272581@163.com>
 * @version     0.1.0
 * @since       0.1.0 11/22/15 oomusou: 新增getLatest3Posts()
 * @time        2017/3/16 16:43
 */
define('APP_PATH', dirname(__DIR__));
define('APP_DEBUG', true);
$application = new Yaf\Application(APP_PATH . "/conf/application.ini");
define('YAF_ENVIRON', $application->environ());
$application->bootstrap()->getDispatcher()->dispatch(new Yaf\Request\Simple());