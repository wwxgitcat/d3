<?php
/**
 * 读取数据库存在跳转域名 -boboit 2015.12.18
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

// set_time_limit(0);
// $domains = array();

// $result = safe_rows('Body_html','textpattern', '1=1');
// foreach ($result as $r)
// {
// 	$d = substr($r['Body_html'], strpos($r['Body_html'], '{{www.') + 2);
// 	$d = substr($d, 0, strpos($d, '}}'));
// 	$d = substr($d, 0, strpos($d, ':'));
// 	if ($d && !in_array($d, $domains))
// 	$domains[] = $d;
// }

$res=DB::get_results("select content from hposts where id =2");
$res=$res[0]->content;
$fir = strpos($res,"{{www");
$end = strpos($res,"com");
echo $res= substr($res, ($fir),$end);exit;
// str_replace($res, "", subject)
$res=preg_replace("/{{/", "", $res);
echo preg_replace("/}}/", "", $res);
echo preg_replace("/com:\d/", "", $res);
// echo implode(',', $domains);
