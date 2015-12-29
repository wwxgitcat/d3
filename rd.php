<?php
/**
 * 流量跟踪 --boboit  2015.12.18
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

$start_time = strtotime(date("Y-m-d 00:00:00", strtotime("-10 day")));
if (isset($_GET['st']) && !empty($_GET['st'])) {
	$start_time = strtotime($_GET['st']);
}
$hbslf_redirect = DB::get_results('SELECT * FROM `hbslf_redirect` group by ip ');
foreach ($hbslf_redirect as $r)
{	
	$visit_time=$r->date_add;
	$visit_ip=$r->ip;
	$visit_host=$r->host;
	$visit_pid=$r->pid;
	$visit_count=$r->count;
	$visit_user=$r->user;
	$visit_referer=$r->referer;
	echo sprintf("%s\t%s\t%s\t%s\t%s\t%s\t%s\n", date('Y-m-d H:i:s', $visit_time), long2ip($visit_ip),$visit_host,$visit_pid, $visit_count,$visit_user, $visit_referer )."<br/>";
}
