php_base
========
A lightweight and useful PHP base libraries.

##Quick start
php_base 起初是用于将文本文件导入数据库的一套基础函数库，现将其中与业务无关的公共代码提取出来，以方便以后复用。目前基础代码还比较少，lib目录下存放的主要是开源代码，以后会陆续增加一些自己编写的代码。

##How to
php_base 的使用很简单，只要在本地安装git，然后执行#git clone git://github.com/elixtang/php_base.git，然后编辑app.php，保存退出后执行#php app.php即可。

##Function list
+ 将文件转成数组
+ 对数据库的增删改查
+ 汉字转拼音

##Todo list
+ add download function
+ add memcache handle function
+ add consistent hash function
