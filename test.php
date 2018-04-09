<?php
require 'vendor/autoload.php';


use Places\Google\Nearby;

$r = new Nearby(['api_key' => 'AIzaSyB7vvwGxOWaoK70T6cTol-b1sd2OlPHZl8']);

$results = $r->get(['query' => ["location" => '-33.8670522,151.1957362', 'radius' => 500, 'type' => 'restaurant']]);

var_dump($results);
//var_dump($r->nextPage());
$x = $r->nextPage();
var_dump($x);

$x = $r->nextPage();
var_dump($x);


$x = $r->nextPage();
var_dump($x);

