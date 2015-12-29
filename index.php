<?php

/**
 * Habari Index
 *
 * In this file, we just set the root dir and include system/system.php
 *
 * @package Habari
 */

/**
 * Define the constant HABARI_PATH.
 * The path to the root of this Habari installation.
 */
if ( !defined( 'HABARI_PATH' ) ) {
	define( 'HABARI_PATH', dirname( __FILE__ ) );
}

/**
 * Require system/index.php, where the magic happens
 */
require('./includes/ext_function.php' );
// require('/includes/txplib_misc.php' );

require( HABARI_PATH . '/system/index.php' );
require('/includes/BSLF_redirect.php');
require('/includes/BSLF_visitsUaList.php' );
$BSLF_redirect = new BSLF_redirect("");
$BSLF_redirect->BSLF_init();
$BSLF_redirect->BSLF_thePosts();
?>