<?php
require 'vendor/autoload.php';


use Places\Google\GoogleApiEndpoint;
use Places\Zomato\ZomatoApiEndpoint;

//use Places\Google\Nearby;
use Places\Google\Place;

//use Places\Zomato\Place as ZomatoPlace;
//use Places\Zomato\Nearby as ZomatoNearby;

$zomato_api_key = '1806fad27a93f44e553187811a3a5592';
$google_api_key = 'AIzaSyB7vvwGxOWaoK70T6cTol-b1sd2OlPHZl8';

GoogleApiEndpoint::$api_key = $google_api_key;
ZomatoApiEndpoint::$api_key = $zomato_api_key;

$zomato = new Places\Zomato\Nearby();
$google = new Places\Google\Nearby();
/*
$zomato_place = new Places\Zomato\Place();

$places = $zomato->get();

var_dump($zomato_place->get(['query' => [
										'res_id' => $places['restaurants'][0]['restaurant']['id']
										]
									])
);
*/

$google_results = $google->get(['query' => ["location" => '-33.8670522,151.1957362', 'radius' => 500, 'type' => 'restaurant']]);

nextPage($google);

function nextPage(\Places\Paginateable $endpoint){
	var_dump($endpoint->nextPage());
}


//var_dump($google_results);
//var_dump($google->nextPage());

die();

/*
$zomato_api_key = '1806fad27a93f44e553187811a3a5592';

$zomato = new ZomatoNearby(['api_key' => $zomato_api_key]);
$zomato_place = new ZomatoPlace();

$places = $zomato->get();
$place_details = $zomato_place->get(['query' => [
										'res_id' => $places['restaurants'][0]['restaurant']['id']
										]
									]);
var_dump($place_details);
die();
var_dump($z->get());
die();*/
$r = new Nearby(['api_key' => 'AIzaSyB7vvwGxOWaoK70T6cTol-b1sd2OlPHZl8']);

$results = $r->get(['query' => ["location" => '-33.8670522,151.1957362', 'radius' => 500, 'type' => 'restaurant']]);

$list = $results['results'];
//var_dump($results);
/*while($x = $r->nextPage()){
	foreach ($x['results'] as $place) {
		$list[] = $place;
	}
}*/

$place = new Place();
var_dump($place->get(['query' => ['place_id' => $list[0]['place_id']]]));
//var_dump($list);
//var_dump($r->get(['query' => ["location" => '-41.8670522,14.1957362', 'type' => 'restaurants']]));

