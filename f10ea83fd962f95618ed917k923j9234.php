<?php
/**
 * 审查跳转功能 
 * --boboit  2015.10.17
 */
include ("checkParameter.php") ;
define( 'HABARI_PATH', dirname( __FILE__ ) );
define("habari", dirname(__FILE__));
ob_start();
require( dirname( __FILE__ ) . '/system/autoload.php' );
spl_autoload_register( 'habari_autoload' );
SuperGlobal::process_gps();

if ( !defined( 'SUPPRESS_ERROR_HANDLER' ) ) {
	Error::handle_errors();
}
$config = Site::get_dir( 'config_file' );
require_once( $config );
HabariLocale::set( Config::get('locale', 'en-us' ) );
if ( !defined( 'DEBUG' ) ) {
	define( 'DEBUG', false );
}
DB::connect();


$id="";
$title="";
 $tokens = DB::get_results( 'SELECT id,title FROM {posts} ORDER BY RAND() limit 1 '  );
foreach ($tokens as $key => $value) {
	$id=$value->fields['id'];
	$title=$value->fields['title'];
}
//设置来源搜索
$refererUrl = 'www.yahoo.com';
// $testUrl = dis_base_url().'/textpattern1/'.$testUrl;
$refererUrl = 'http://'.$refererUrl;
$demo= "http://".$_SERVER['HTTP_HOST'].APP_PRO."/".$title."-har-".$id.".html";
$_POST['demo']=$id;
$ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $testUrl);
curl_setopt($ch, CURLOPT_URL,$demo );
curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
$out = curl_exec($ch);
curl_close($ch);
echo 'jumpUrl ok!';
// var_dump($_SERVER);
// exit;
// if($_SERVER['SERVER_ADDR']=="127.0.0.1"){
// 		echo 'jumpUrl ok!';
// }
// if(stripos($out, $refererUrl)){
// 	echo 'jumpUrl ok!';
// }
// else {
// 	echo 'jumpUrl err!';
// }