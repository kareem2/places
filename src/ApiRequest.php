<?php
namespace Places;

use GuzzleHttp\Client;

/**
 * Class ApiRequest
 *
 * Main request class that will be used by the API handlers.
 *
 * @package Places
 */
class ApiRequest
{

    /**
     * Handler api key
     *
     * @var string
     */
	protected $api_key;

    /**
     * Base api url
     *
     * @var string
     */
	protected $api_base_url;

    /**
     * API servicee end point path
     *
     * @var string
     */
	protected $api_service_end_point;

    /**
     * Parameters of the API request
     *
     * @var array
     */
	protected $api_parameters;

    /**
     * Http client that will used to make API requests, default client is \GuzzleHttp\Client
     *
     * @var \GuzzleHttp\Client
     */
	protected $httpClient;

	
	function __construct($key = null, $parames = [])
	{
		if(isset($parames['http_client'])){
			$this->httpClient = $parames['http_client'];
		}else{
			$this->httpClient = new Client();
		}

		if(isset($parames['api_parameters']) && !empty($parames['api_parameters'])){
			$this->api_parameters = $parames['api_parameters'];
		}


	}


    

	
}