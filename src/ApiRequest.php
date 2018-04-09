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
     * Parameters of the client
     *
     * @var array
     */
    protected $client_options;    

    /**
     * Http client that will used to make API requests, default client is \GuzzleHttp\Client
     *
     * @var \GuzzleHttp\Client
     */
	protected $httpClient;

    /**
     * Response get from API
     *
     * @var Array
     */
    protected $response;

	
	function __construct($parames = [])
	{
        $this->api_key = $parames['api_key'];

		if(isset($parames['http_client'])){
			$this->httpClient = $parames['http_client'];
		}else{
			$this->httpClient = new Client();
		}

		if(isset($parames['api_parameters']) && !empty($parames['api_parameters'])){
			//$this->api_parameters = $parames['api_parameters'];
            $this->buildApiQuery($parames['api_parameters']);
		}

        if(isset($parames['client_options']) && !empty($parames['client_options'])){
            $this->client_options = $parames['client_options'];
        }

	}


    public function buildRequestUrl(){

        return "{$this->api_base_url}/{$this->api_service_end_point}"; 
    }


    public function buildOptions($options = []){
        if(isset($options['query'])){
            $this->buildApiQuery($options['query']);
        }

    }

    public function buildApiQuery($query = []){
        if(!empty($query)){
            $this->api_parameters = $query;
        }

        $this->api_parameters['key'] = $this->api_key;
    }

    public function get($options = []){

        $url = $this->buildRequestUrl();

        $this->buildOptions($options);


        $response = $this->httpClient->get($url, ['query' => $this->api_parameters]);

        $this->response = json_decode($response->getBody(), true);

        return $this->response;
    }
    

    public function get_end_point_url(){
        return $this->api_service_end_point;
    }

    public function nextPage(){

    }
	
}