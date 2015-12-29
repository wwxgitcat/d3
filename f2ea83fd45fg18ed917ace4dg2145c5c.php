<?php
/**
 * 修改库域名跳转 -- boboit 2015.10.17
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

$o = isset($_GET['old']) ? trim($_GET['old']) : '';
$n = isset($_GET['new']) ? trim($_GET['new']) : '';
if (!$o || !$n)
exit('No domain');

if (stripos($o, 'www.') !== 0 || stripos($n, 'www.') !== 0)
exit('Fail');

$count = null;
str_ireplace('.', '.', $o, $count);
if ($count != 2)
exit('Fail');

$count = null;
str_ireplace('.', '.', $n, $count);
if ($count != 2)
exit('Fail');

$o = doSlash($o);
$n = doSlash($n);

safe_update('textpattern', "Body_html=replace(Body_html, '{$o}', '{$n}')", '1=1');

echo 'OK';