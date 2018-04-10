<?php
namespace Places\Google;

use Places\Paginateable;

/**
* 
*/
class Nearby extends GoogleApiEndpoint implements Paginateable
{

	protected $api_service_end_point = 'nearbysearch/json';

    public function nextPage(){

        if(isset($this->response['next_page_token'])){
            $this->api_parameters['pagetoken'] = $this->response['next_page_token'];
            sleep(2);
            return $this->get();
        }
        
        return false;
        
    } 	
	
}
