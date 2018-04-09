<?php
namespace Places\Google;

use Places\ApiEndpoint;

/**
 * Class GoogleApiEndpoint
 *
 * Main request class that will be used to make Google API requests.
 *
 * @package Places\Google
 */
class GoogleApiEndpoint extends ApiEndpoint
{

    /**
     * Base api url
     *
     * @var string
     */
	protected $api_base_url = 'https://maps.googleapis.com/maps/api/place';


    public function buildApiQuery($query = []){
        parent::buildApiQuery($query);
        $this->api_parameters['key'] = $this->api_key;
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