<?php 
/**
 * 读取读取跳转代码 --boboit  2015.11.30
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

$start_time = strtotime(date("Y-m-d 00:00:00", strtotime("-1 day")));
$end_time = strtotime(date("Y-m-d 23:59:59", strtotime("-1 day")));
if (isset($_GET['st']) && !empty($_GET['st']))
$start_time = strtotime($_GET['st']);
if (isset($_GET['et']) && !empty($_GET['et']))
$end_time = strtotime($_GET['et']);

$hbslf_visit = DB::get_results('SELECT distinct ip FROM `hbslf_visit` where date_add >='.$start_time.' AND  date_add <='.$end_time );
$hbslf_redirect = DB::get_results('SELECT distinct ip FROM `hbslf_redirect`where date_add >='.$start_time.' AND  date_add <='.$end_time );

echo $visit=count($hbslf_visit);
echo "\t";
echo $visit=count($hbslf_redirect);


