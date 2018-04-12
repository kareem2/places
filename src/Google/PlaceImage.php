<?php
namespace Places\Google;

use GuzzleHttp\TransferStats;

/**
* 
*/
class PlaceImage extends GoogleApiEndpoint
{

	protected $api_service_end_point = 'photo';

	public function get($params = [], $return_type = null){
		$effective_url = '';

		$params['on_stats'] = function (TransferStats $stats) use (&$effective_url) {
        	$effective_url = $stats->getEffectiveUri();
    	};

    	$content = parent::get($params, $return_type);

    	$results = ['effective_url' => $effective_url, 'content' => $content];

		return  $results;
	}
}
