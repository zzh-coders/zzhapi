<?php
define('IS_CGI', substr(PHP_SAPI, 0, 3) == 'cgi' ? 1 : 0);
define('IS_WIN', strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI', PHP_SAPI == 'cli' ? 1 : 0);
!IS_CLI && define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
!IS_CLI && define('IS_GET', REQUEST_METHOD == 'GET' ? true : false);
!IS_CLI && define('IS_POST', REQUEST_METHOD == 'POST' ? true : false);
!IS_CLI && define('IS_PUT', REQUEST_METHOD == 'PUT' ? true : false);
!IS_CLI && define('IS_DELETE', REQUEST_METHOD == 'DELETE' ? true : false);
!IS_CLI && define('IS_AJAX', ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || !empty($_POST['ajax']) || !empty($_GET['ajax'])) ? true : false);

define('DATA_BACKUP_PATH', './data');//数据库备份根路径
define('DATA_BACKUP_PART_SIZE', 20971520);//数据库备份卷大小
define('DATA_BACKUP_COMPRESS', 1);//数据库备份文件是否启用压缩
define('DATA_BACKUP_COMPRESS_LEVEL', 9);//数据库备份文件压缩级别

define('LDAP_HOST', 'xxx');
define('LDAP_EMAIL', 'xxx');

define('ADMIN_USERNAME', '');