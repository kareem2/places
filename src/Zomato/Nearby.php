<?php
namespace Places\Zomato;

use Places\Interfaces\Paginateable;
/**
* 
*/
class Nearby extends ZomatoApiEndpoint implements Paginateable
{

	protected $api_service_end_point = 'search';
	
    public function nextPage(){

        if(isset($this->response['next_page_token'])){
            $this->api_parameters['pagetoken'] = $this->response['next_page_token'];
            sleep(2);
            return $this->get();
        }
        
        return false; 
    }	
}
