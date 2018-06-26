# YafModel
Yaf 地址:https://github.com/laruence/php-yaf 请针对自己的php 版本进行安装,注意服务器url路由规则

## Why I Do
自己在项目中用了yaf，用了很多外部类，感觉需要优化地方很多，逐渐改进。这里只是一个简单的例子，可以用于yaf快速上手，我的修改有些借鉴别人的思路，想要用好希望多看鸟哥的官方文档及源码.(http://www.laruence.com/manual/)

## What I Do
- layout布局实现
- laravel Eloquent ORM
- monolog错误捕捉显示及日志记录

## Requirement
- Nginx
- PHP 5.2 +
- PHP Yet another Framework
- Mysql

## How To Use

### Rewrite rules

#### Apache

```conf
#.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule .* index.php
```

#### Nginx (nginx.conf已有示例)

```
server {
  listen ****;
  server_name  domain.com;
  root   document_root;
  index  index.php index.html index.htm;
 
  location / {
		try_files $uri $uri/ /index.php?$args;
  }

}
```

### app.ini
详细见具体文件

### ErrorAction
报错开启关闭在ini中有配置，可以记录为日志文件，需要有写权限。在Error.php实现。

###安装使用

## 配置
首先，你得安装yaf,文档里有，[http://php.net/manual/zh/yaf.installation.php](http://php.net/manual/zh/yaf.installation.php) 。
安装完之后，编辑php.ini文件，配置yaf:
```sh
extension=yaf.so
yaf.use_namespace=1 ;开启命名空间
yaf.use_spl_autoload=1 ;开启自动加载
```
##引入composer第三方扩展包
```sh
composer install  
```
### 使用依赖
- [illuminate/database](https://packagist.org/packages/illuminate/database) 
- [monolog/monolog](https://packagist.org/packages/monolog/monolog) 
- [symfony/debug](https://packagist.org/packages/symfony/debug) 
- [symfony/var-dumper](https://packagist.org/packages/symfony/var-dumper) 
- [symfony/console](https://packagist.org/packages/symfony/console) 


