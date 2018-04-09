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
     * Base api url
     *
     * @var string
     */
	protected $api_base_url = 'https://developers.zomato.com/api/v2.1';


    public function buildOptions($options = []){
        if(isset($options['query'])){
            $this->buildApiQuery($options['query']);
        }
        parent::buildOptions($options);

        $this->client_options['headers'] = [
            'accept' => 'application/json',
            'user-key' => $this->api_key
        ];

        //var_dump($this->client_options);
    }


    public function nextPage(){

        if(isset($this->response['next_page_token'])){
            $this->api_parameters['pagetoken'] = $this->response['next_page_token'];
            sleep(2);
            return $this->get();
        }
        
        return false;
        
    }

}