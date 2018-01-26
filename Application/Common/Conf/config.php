<?php
return array(
    /* 数据库设置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'arc20180126', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root', // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'ldhkj_',    // 数据库表前缀
    #'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    #'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    //'SHOW_PAGE_TRACE'=>true,
    //'SHOW_PAGE_TRACE'=>true,
     // 'APP_DEBUG'   => false ,
    'ERROR_PAGE'            =>  '404.html',  // 错误定向页面
	'DB_FIELD_CACHE'		=>false,
	'HTML_CACHE_ON'		=>false,
	'SUPER_NAME'=>array('admin','danghong'),
	 'URL_MODEL' => 2, //REWRITE模式
    'MODULE_ALLOW_LIST' => array('Home','YeeAdmin'), //控制器名字
    'DEFAULT_MODULE'       =>    'Home',
    'URL_MODULE_MAP'   =>  array('yeeadmin'=>'admin'),//模块映射
    // 'SHOW_ERROR_MSG'  =>  true,  //显示错误信息
	
	'THINK_EMAIL' => array(
		// 'SMTP_HOST'   => 'smtp.qq.com', //SMTP服务器
		// 'SMTP_PORT'   => '465', //SMTP服务器端口
		// 'SMTP_USER'   => '724933430@qq.com', //SMTP服务器用户名
		// 'SMTP_PASS'   => 'tznztfkeupkcbegf', //SMTP服务器密码
		// 'FROM_EMAIL'  => '724933430@qq.com', //发件人EMAIL
		// 'FROM_NAME'   => '当虹科技', //发件人名称
		// 'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
		// 'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
        'SMTP_HOST'   => 'smtp.exmail.qq.com', //SMTP服务器
        'SMTP_PORT'   => '465', //SMTP服务器端口
        'SMTP_USER'   => 'zhaopin@arcvideo.com', //SMTP服务器用户名
        'SMTP_PASS'   => 'Arcvideo01', //SMTP服务器密码
        'FROM_EMAIL'  => 'zhaopin@arcvideo.com', //发件人EMAIL
        'FROM_NAME'   => '当虹科技官网', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
	),
);

