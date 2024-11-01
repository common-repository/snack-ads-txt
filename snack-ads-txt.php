<?php
/*
Plugin Name: Snack Ads Txt
Description: Handles automatic creation and updates of ads.txt file
Version: 3.2.0
Author: Petr Paboucek -aka- BoUk
Author URI: https://wpadvisor.co.uk
Text Domain: snack-ads-txt
*/

if ( ! defined( 'ABSPATH' ) ) 
    exit;

define( 'SAT_PLUGIN_PATH', 	plugin_dir_path( __FILE__ ) );
define( 'SAT_PLUGIN_URL', 	plugin_dir_url( __FILE__ ) );

/**
 * Load required files
 */
require SAT_PLUGIN_PATH . "vendor/autoload.php";

$model 		= new \Snack\AdsTxt\Models\wpModel();
$controller = new \Snack\AdsTxt\Controllers\wpController( $model );

/**
 * Making sure re-occuring cron event is set
 */
add_action( 'init',	[ 
				$controller, 
				'scheduleCronEvent' 
			]);

/**
 * Generate ads.txt file by cron event
 */
add_action( $model::RECCURING_EVENT_NAME, [ 
				$controller, 
				'generateAdsTxt' 
			]);

/**
 * Anothe cron event for generating ads.txt. This is single_event though which is scheduled 
 * via REST API call allowing adops to immediatelly trigger update.
 */
add_action( $model::SINGLE_EVENT_NAME, [ 
				$controller, 
				'generateAdsTxt' 
			]);

/**
 * Clean up after deactivation
 */
register_deactivation_hook( __FILE__, [ 
				$controller, 
				'deactivate' 
			]);

/**
 * Remove re-occuring cron event
 */
add_action( 'sat_plugin_deactivate', [
				$controller, 
				'removeCronEvents' 
			]);


$restController = new \Snack\AdsTxt\Controllers\restController();

/**
 * Create custom REST endpoint to allow trigger update
 */
add_action( 'rest_api_init', [ 
				$restController, 
				'registerRoutes'
			]);