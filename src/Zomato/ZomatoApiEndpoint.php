<?php
namespace Places\Zomato;

use Places\ApiEndpoint;

/**
 * Class ZomatoApiEndpoint
 *
 * Main request class that will be used to make Zomato API requests.
 *
 * @package Places\Zomato
 */
class ZomatoApiEndpoint extends ApiEndpoint
{

    /**
     * Handler api key
     *
     * @var string
     */
    public static $api_key; 

    /**
     * Base api url
     *
     * @var string
     */
	protected $api_base_url = 'https://developers.zomato.com/api/v2.1';

    function __construct($parames = [])
    {
        if(isset($parames['api_key'])){
            static::$api_key = $parames['api_key'];
        }

        parent::__construct();
    }

    public function buildOptions($options = []){
        if(isset($options['query'])){
            $this->buildApiQuery($options['query']);
        }
        parent::buildOptions($options);

        $this->client_options['headers'] = [
            'accept' => 'application/json',
            'user-key' => static::$api_key
        ];

        //var_dump($this->client_options);
    }

    
}