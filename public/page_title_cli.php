<?php
/**
 * 简述
 *
 * 详细说明(可略)
 *
 * @copyright Copyright&copy; 2016, Meizu.com
 * @author   zouzehua <zouzehua@meizu.com>
 * @version $Id: page_title_cli.php, v ${VERSION} 2016-11-18 10:59 Exp $
 */
define('APP_PATH', dirname(__DIR__));
define('APP_DEBUG', true);
$application = new Yaf\Application(APP_PATH . "/conf/application.ini");
define('YAF_ENVIRON', $application->environ());
$application->bootstrap()->getDispatcher()->dispatch(new Yaf\Request\Simple());