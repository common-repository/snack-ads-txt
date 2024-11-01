<?php

namespace Snack\AdsTxt\Controllers;

/**
 * 
 */
class wpController
{

	/**
	 * [$model description]
	 * @var [type]
	 */
	protected $model;

	/**
	 * [__construct description]
	 * @param Snack\AdsTxt\Models\wpModel $model [description]
	 */
	public function __construct( \Snack\AdsTxt\Models\wpModel $model )
	{
		$this->model 	= $model;
	}

	/**
	 * [scheduleCronEvent description]
	 * @return [type] [description]
	 */
	public function scheduleCronEvent()
	{		
		$timestamp = wp_next_scheduled( $this->model::RECCURING_EVENT_NAME );

		if ( $timestamp )
		{
	        $schedule = wp_get_schedule( $this->model::RECCURING_EVENT_NAME );
	        if ( $schedule === 'twicedaily' ) 
	            wp_unschedule_event( $timestamp, $this->model::RECCURING_EVENT_NAME );
	    }

		if ( ! $timestamp ) 
		{
    		$offset = rand( 0, HOUR_IN_SECONDS );
    		wp_schedule_event( time() + $offset, 'hourly', $this->model::RECCURING_EVENT_NAME );
		}
	}

	/**
	 * Triggered by cron event
	 * @return [type] [description]
	 */
	public function generateAdsTxt()
	{
		/**
		 * Site ID is defined in wp-config.php. No need to execute extra request
		 * to get site ID
		 */
		if ( defined( 'HEADER_BIDDING_SITE_ID' ) )
		{
			$data = $this->model->getAdsTxtContent( HEADER_BIDDING_SITE_ID );
			$this->model->saveDataToFile( $data, 'ads.txt' );
		}

		/**
		 * Site ID not defined in config. We can try to obtain automatically
		 */
		else 
		{
			$siteId = $this->model->getSiteIdByUrl();
			$data 	= $this->model->getAdsTxtContent( $siteId );
			$this->model->saveDataToFile( $data, 'ads.txt' );
		}

	}

	/**
	 * Action executed on plugin deactivation
	 * @return [type] [description]
	 */
	public function deactivate()
	{
		do_action( 'sat_plugin_deactivate' );
	}

	/**
	 * [removeCronEvents description]
	 * @return [type] [description]
	 */
	public function removeCronEvents()
	{
		$timestamp = wp_next_scheduled( $this->model::RECCURING_EVENT_NAME );
		wp_unschedule_event( $timestamp, $this->model::RECCURING_EVENT_NAME );
	}

}