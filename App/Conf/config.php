<?php
return array(
	//'配置项'=>'配置值'	
	'APP_DEBUG'             => false,        // 开启调试模式
	//'APP_STATUS'			=> 'debug',
	'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'localhost', // 服务器地址
	'DB_NAME'               => 'gwdh',  //"daohang"        // 数据库名
	'DB_USER'               => 'root',      // 用户名
	'DB_PWD'                => '',          // 密码
	'DB_PORT'               => '3306',        // 端口
	'DB_PREFIX'             => 'dh_',
	'SESSION_AUTO_START' =>true,
    'APP_AUTOLOAD_PATH'=>'@.TagLib,@.ORG',
    'TOKEN_ON'  => false,
    'URL_ROUTER_ON' => true,
    'SHOW_PAGE_TRACE'=>false,
	
    'APP_GROUP_LIST'        => 'Home,Admin',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
	'DEFAULT_GROUP'         => 'Home',  // 默认分组
	
 	/* 资源路径 */
    'TMPL_PARSE_STRING'     => array(   
        '__CSS__' => __ROOT__.'/App/Public/Home/css',         // home模块css路径
        '__IMG__' => __ROOT__.'/App/Public/Home/images',      // home模块图片路径
        '__JS__' => __ROOT__.'/App/Public/Home/js',           // home模块js路径
        '__UPLOAD__' => __ROOT__.'/App/Public/uploads',  // home模块上传文件路径
		'__CSS2__' => __ROOT__.'/App/Public/Admin/Css',       // admin模块css路径
		'__IMG2__' => __ROOT__.'/App/Public/Admin/Images',     // admin模块图片路径
        '__JS2__' => __ROOT__.'/App/Public/Admin/Js',          // admin模块js路径
    	'__PLUGIN__'=> __ROOT__.'/App/Public/plugin'	// admin模块kindeditor路径
    ),
		
	/*文件上传的地址*/
	'UPLOADS_ADDR' => str_replace('\\', '/', dirname(dirname(__FILE__))) . '/Public/uploads/',
	// 上传文件目录网站绝对路径
	'UPLOADS' => __ROOT__.'/Public/uploads/',

	/*缓存*/
    'TMPL_CACHE_ON'    => false,
    'HTML_CACHE_ON'   => false,
    'ACTION_CACHE_ON'  => false,
	'OUTPUT_ENCODE' => false,
    /*
     * 模板的输出格式
     */
    'TMPL_CONTENT_TYPE'     => 'text/html',
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
);
?>