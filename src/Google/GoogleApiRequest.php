<?php
namespace Places\Google;

use Places\ApiRequest;

/**
 * Class GoogleApiRequest
 *
 * Main request class that will be used to make Google API requests.
 *
 * @package Places\Google
 */
class GoogleApiRequest extends ApiRequest
{

    /**
     * Base api url
     *
     * @var string
     */
	protected $api_base_url = 'https://maps.googleapis.com/maps/api/place';


    public function __construct($params = [])
    {
        if(!empty($params['api_base_url'])){
            $this->api_base_url = $params['api_base_url'];
        }

        parent::__construct($params);

    }


    public function nextPage(){

        if(isset($this->response['next_page_token'])){
            $this->api_parameters['pagetoken'] = $this->response['next_page_token'];
            sleep(1);
            return $this->get();
        }
        
        return false;
        
    }

}