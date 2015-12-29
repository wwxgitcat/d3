<?php
/**
 * 修改三要素网站名称 -- kevin 2015.10.17
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

$rows = safe_rows('name','txp_category', ' 1=1 ORDER BY RAND() LIMIT 3');
$siteName = '';
foreach ($rows as $val) {
	$siteName .= $val['name'];
}
$str = 'set sitename ';
if (strlen($siteName)>0) {
	safe_update('txp_prefs', 'val="'.$siteName.'"','name="sitename"');
	 $str .= 'OK';
}
else  $str .= 'ERR';


echo $str;