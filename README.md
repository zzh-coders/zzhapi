环境：
PHP5.5+

安装：
首先安装yaf

下载地址：https://pecl.php.net/package/yaf

配置信息
[YAF]
extension=yaf.so ;加载so文件
yaf.environ=dev ;环境
yaf.use_namespace=On ;开启命名空间

配置数据库文件：
{rootPath}/conf/application.ini
找到
[dev : common]

;数据库配置
db.type = mysql
db.dbname = zzhapi
db.pconnect = 1
db.host = 192.168.75.128
db.port = 3306
db.user = root
db.pswd = 123456

配置就好


敬请期待新功能

邮箱：532207815@qq.com
QQ:532207815
