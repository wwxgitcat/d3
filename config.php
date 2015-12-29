<?php if ( !defined( 'HABARI_PATH' ) ) { die( 'No direct access' ); }
define('APP_ROOT', "localhost");
define('APP_NAME', "/tempEP/");
define('APP_PRO', "/habari");  //填写当前行项目路径，服务器默认为空
Config::set( 'db_connection', array(
	'connection_string'=>'mysql:host=localhost;dbname=habari',
	'username'=>'root',
	'password'=>'root',
	'prefix'=>'h'
));

// Config::set('locale', 'en-us');
?>
