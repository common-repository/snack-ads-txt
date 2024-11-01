<?php

namespace Snack\AdsTxt\Models;

/**
 * 
 */
class wpModel
{		
	/**
	 * Define name of cron recurring event
	 */
	const RECCURING_EVENT_NAME 	= 'snack_adstxt_generate';

	/**
	 * Define name of single cron event
	 */
	const SINGLE_EVENT_NAME 	= 'snack_adstxt_force_generate';

	/**
	 * Transient variable name used for keeping site ID in cache
	 */
	const SITE_ID_TRANSIENT 	= 'snack_ads_txt';

	/**
	 * Transient cache ttl
	 */
	const CACHE_TTL = WEEK_IN_SECONDS;

	/**
	 * Returns site ID as defined in Snack Header Bidding system
	 * @param  string $siteUrl [description]
	 * @return [type] [description]
	 */	
	public function getSiteIdByUrl( $siteUrl = '' )
	{
		/**
		 * 1. Check if Header Bidding site ID exists in cache
		 */
		$siteId = get_transient( self::SITE_ID_TRANSIENT );

		// Transient is expired or doesn't exist
		if ( false === $siteId )
		{			
			if ( $siteUrl == '' )
				$siteUrl = get_bloginfo( 'url' );						
			
			$replace 		= [ 'http://www.', 'https://www.', 'http://', 'https://' ];
			$replacement	= [ '', '', '', '' ];

			$siteDomain		= str_replace( $replace, $replacement, $siteUrl );

			// Do HTTP GET request to find site ID
			$args = [
				'method'		=> 'GET',
				'timeout'		=> 7,				
			];

			$response = wp_remote_get( 
						'https://header-bidding.snack-media.com/wp-json/hb/v1/site/' . $siteDomain,
						$args
					);

			$status = wp_remote_retrieve_response_code( $response );

			if ( $status != 200 )
				return false;		

			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body );

			if ( ! isset( $data->ID ) )
				return false;
			
			$siteId = $data->ID;

			/**
			 * Store site ID into cache
			 */
			set_transient( self::SITE_ID_TRANSIENT, $siteId, self::CACHE_TTL );
		}
		
		return $siteId;		
	}	

	/**
	 * [getAdsTxtContent description]
	 * @param  [type] $siteId [description]
	 * @return [type]         [description]
	 */
	public function getAdsTxtContent( $siteId )
	{
		if ( ! $siteId || intval( $siteId ) <= 0 )
			return false;		

		// Do HTTP GET request to find site ID
		$args = [
			'method'		=> 'GET',
			'timeout'		=> 7			
		];

		$apiEndpoint = 'https://header-bidding.snack-media.com/adstxt/';		

		if ( defined( 'HEADER_BIDDING_ADSTXT_VERSION' ) && HEADER_BIDDING_ADSTXT_VERSION == 2 )
		{
			$apiEndpoint = 'https://header-bidding.snack-media.com/adstxt/v2/';
		}

		$response = wp_remote_get( 
			$apiEndpoint . $siteId,
			$args 
		);

		$status = wp_remote_retrieve_response_code( $response );

		if ( $status != 200 )
			return false;			

		return wp_remote_retrieve_body( $response );				
	}

	/**
	 * [saveDataToFile description]
	 * @param  [type] $data     [description]
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	public function saveDataToFile( $data, $filename )
	{
		if ( ! $filename  )
			return false;

		if ( empty( $data ) )
			return false;

		$fp = fopen( ABSPATH .  $filename, "w" );
		fwrite( $fp, $data );
		fclose($fp);
	}
}