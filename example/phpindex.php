<?php
require '../vendor/autoload.php';

require_once 'assets/ref.php';





/*
$url = 'https://maps.googleapis.com/maps/api/place/photo?photo_reference=CmRaAAAA0wUmlnZmKX45iJmBOCbkOBrX57oNljd0cte2RwPSTwWMOA2zVTMcrxEr1TjnwlpcX4mp_9zlPe_YSnvpeXrBmaLCbXi40chh1q1JDw8k4HbYRG5CrMvYsM-KxUyBira5EhDfm8YyVkZhu_oqglySeKv3GhRRcffHq5juhsffbm4W84vugyW6tA&maxwidth=3264&key=AIzaSyB7vvwGxOWaoK70T6cTol-b1sd2OlPHZl8';

$client = new GuzzleHttp\Client();

echo $client->get($url)->getBody()->getContents();

die();
*/
use Places\Google\GoogleApiEndpoint;
use Places\Zomato\ZomatoApiEndpoint;

//use Places\Google\Nearby;
use Places\Google\Place;
use Places\Google\PlaceImage;



//use Places\Zomato\Place as ZomatoPlace;
//use Places\Zomato\Nearby as ZomatoNearby;

$zomato_api_key = '1806fad27a93f44e553187811a3a5592';
$google_api_key = 'AIzaSyB7vvwGxOWaoK70T6cTol-b1sd2OlPHZl8';

GoogleApiEndpoint::$api_key = $google_api_key;
ZomatoApiEndpoint::$api_key = $zomato_api_key;

$zomato = new Places\Zomato\Nearby();
$google = new Places\Google\Nearby();
$place_image = new PlaceImage();

/*
$google_results = $google->get(['query' => ["location" => '-33.8670522,151.1957362', 'radius' => 500, 'type' => 'restaurant']]);

$google_place = new Place();
$google_result = $google_place->get(['query' => ['place_id' => $google_results['results'][0]['place_id']]]);
$google_result = $google_result['result'];


$zomato_result = $zomato->get(['query' => [
								'q' => $google_result['name'],
								'lat' => $google_result['geometry']['location']['lat'],
								'lon' => $google_result['geometry']['location']['lng'],
							]]);

$zomato_result = $zomato_result['restaurants'][0]['restaurant'];
r($google_result);
r($zomato_result);

$photo = $place_image->get(['query' => [
                      'photo_reference' => $google_result['photos'][0]['photo_reference'],
                      'maxwidth' => $google_result['photos'][0]['width']
                    ]]);

file_put_contents('image2.jpg', $photo['content']);
r((string)$photo['effective_url']);*/

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>
	<script type="text/javascript" src="assets/ref.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/ref.css">    
    <head>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
      body, button, input, select, textarea {
        font-family: 'Larsseit', sans-serif;
      }
    </style>
  </head>
  </head>
  <body>
  <div class="container">
    <nav class="navbar is-transparent">
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          <div style="font-weight: 600; color: black; font-size: 13px;">Atmos.</div>
          <div style="font-weight: 300; color: black; font-size: 13px;">Discover the best night in Sydney.</div>
        </a>
      </div>

      <div class="navbar-menu">
        <div class="navbar-start">
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <input class="input" id="search-input" type="text" placeholder="Try &quot;hipster bar&quot;">
          </div>
        </div>
      </div>
    </nav>
  </div>

  <section class="section" style="background-image: url(palmer-co.jpg); background-size: cover;     background-position-y: 55%;" id="cover-image">
    <div class="container">
      <div class="columns">
        <div class="column" style="height: 300px;">
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top: 0; padding-bottom: 0;">
    <div class="container">
      <div class="columns">
        <div class="column is-10-widescreen is-12-desktop is-offset-1-widescreen is-offset-0-desktop">
          <div class="columns is-multiline pad-vert-small">
            <div class="column is-6 is-offset-3 pad-vert-small">
              <div class="white-card" style="background: white; margin-top: -300px; border-radius: 5px; box-shadow: 0px 12px 42px 0px rgba(12, 0, 51, 0.1);">
                <div style="padding: 2.5em;">
                  <div class="title is-4 place-name" style="color: #43455D; letter-spacing: 0.2px; margin-bottom: 0.75em;">
                    Palmer & Co
                  </div>
                  <div class="columns is-mobile is-gapless">
                    <div class="column is-12">
                      <span class="open-status open">OPEN NOW</span> <span style="opacity:0.7" class="close-time">Closes in 2 hours</span>
                    </div>
                  </div>
                  <hr>
                  <div class="columns is-mobile is-gapless">
                    <div class="column is-6">
                      <div class="subtitle is-6" style="color: #43455D; margin-top: 0;">
                        🏃🏽‍♂️ 2 min walk
                      </div>
                    </div>
                    <div class="column is-6 has-text-right">
                      <a href="#">
                        Get directions →
                      </a>
                    </div>
                  </div>
                  <hr>
                  <div class="subtitle is-6" style="color: #43455D; font-size: 15px; margin-bottom: 10px;">
                    📍 <span id="address">Abercrombie Ln, Sydney NSW 2000</span>
                  </div>
                  <div class="subtitle is-6" style="color: #43455D; font-size: 15px;">
                    📞 <span id="phone">(02) 9114 7315</span>
                  </div>
                </div>
                <div class="has-text-centered" style="background: #ff9579; color: white; padding: 1em; border-radius: 0 0 5px 5px;">
                  <a href="" target="_blank" id="place-website" style="color: white;">Visit <span class="place-name">Palmer and Co's</span> website →</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section pad-vert-extra-small">
    <div class="container">
      <div class="columns">
        <div class="column is-10-widescreen is-12-desktop is-offset-1-widescreen is-offset-0-desktop">
          <div class="columns is-multiline">
            <div class="column is-6 is-offset-3 pad-vert-small">
              <div class="white-card" style="background: white; border-radius: 5px; box-shadow: 0px 8px 36px 0px rgba(12, 0, 51, 0.1);">
                <div class="has-text-centered" style="font-size: 25px; padding-top: 30px;">
                  ⭐️
                </div>
                <div style="padding: 2em 2.5em 2.5em;">
                  <div class="columns is-mobile is-gapless has-text-centered">
                    <div class="column is-6">
                      <div class="title is-4" style="margin-bottom: 10px;" id="google-rating">
                        4.73
                      </div>
                      <div class="subtitle is-6" style="color: #858999; margin-top: 0;">
                        Google
                      </div>
                    </div>
                    <div class="column is-6">
                      <div class="title is-4" style="margin-bottom: 10px;" id="zomato-rating">
                        3.79
                      </div>
                      <div class="subtitle is-6" style="color: #858999; margin-top: 0;">
                        Zomato
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="section pad-vert-extra-small">
    <div class="container">
      <div class="columns">
        <div class="column is-10-widescreen is-12-desktop is-offset-1-widescreen is-offset-0-desktop">
          <div class="columns is-multiline">
            <div class="column is-6 is-offset-3 pad-vert-small">
              <div class="white-card" style="background: white; border-radius: 5px; box-shadow: 0px 8px 36px 0px rgba(12, 0, 51, 0.1);">
                <div class="has-text-centered" style="font-size: 25px; padding-top: 30px;">
                  ⏱
                </div>
                <div style="padding: 2em 2.5em 2.5em;">
                  <div class="weekly-schedule">
                    <div class="columns is-mobile is-gapless">
                      <div class="column is-3" id="week-days">
                        <div class="time day">
                          Monday
                        </div>
                        <div class="time day">
                          Tuesday
                        </div>
                        <div class="time day">
                          Wednesday
                        </div>
                        <div class="time day">
                          Thursday
                        </div>
                        <div class="time day">
                          Friday
                        </div>
                        <div class="time day" style="font-weight: 600; opacity: 1;">
                          Saturday
                        </div>
                        <div class="time day">
                          Sunday
                        </div>
                      </div>
                      <div class="column is-9 has-text-right" id="open-time">
                        <div class="time">
                          5pm - 3am
                        </div>
                        <div class="time">
                          5pm - 3am
                        </div>
                        <div class="time">
                          5pm - 3am
                        </div>
                        <div class="time">
                          3pm - 3am
                        </div>
                        <div class="time">
                          3pm - 3am
                        </div>
                        <div class="time" style="font-weight: 600; opacity: 1;">
                          4pm - 3am
                        </div>
                        <div class="time">
                          5pm - 3am
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="pad-vert-large">

        </div>
      </div>
    </div>
  </section>

  <section class="section pad-vert-small footer">
    <div class="container">
      <div class="columns">
        <div class="column is-6">
          Atmos 2018.
        </div>
        <div class="column is-6 has-text-right">
          Created by George Hatzis.
        </div>
      </div>
    </div>
  </section>
  </body>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-jw7Knx7PKSvTPt67VramDlQfidlcvS0&libraries=places">
    </script>

    <script type="text/javascript">

      var weekday = new Array(7);
      weekday[0] = "Sunday";
      weekday[1] = "Monday";
      weekday[2] = "Tuesday";
      weekday[3] = "Wednesday";
      weekday[4] = "Thursday";
      weekday[5] = "Friday";
      weekday[6] = "Saturday";

      var today = new Date();
      today = today.getDay();
      today = weekday[today];

      function amTime(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
      }


      var input = document.getElementById('search-input');
      var defaultBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(-39.72465582215755, 113.08936737466638),
        new google.maps.LatLng(-10.8556105884471, 154.39796112466638));

      var options = {
        bounds: defaultBounds,
        strictBounds: true,
        types: ["establishment"]
      }
      var autocomplete = new google.maps.places.Autocomplete(input, options); 
      var service = new google.maps.places.PlacesService(input);


      autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        console.log(place['place_id']);
        service.getDetails({
          placeId: place['place_id']
        }, function(place_details, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            console.log(place_details);

            // Address
            $("#address").html(place_details['formatted_address']);

            // Phone
            $("#phone").html(place_details['formatted_phone_number']);

            // Name
            $('.place-name').html(place_details['name']);
            
            // Rating
            $('#google-rating').html(place_details['rating']);


            // Website
            if(place_details['website'] !== undefined){
              $("#place-website").attr('href', place_details['website']);
            }
            // Open status
            var open = false;
            if(place_details['opening_hours'] !== undefined){
              if(place_details['opening_hours']['open_now'] == true){
                open = true;
              }
            }
            if(open){
              $(".open-status").removeClass('closed').addClass('open').html('OPEN NOW');
            }else{
              $(".open-status").removeClass('open').addClass('closed').html('CLOSED NOW');
            }


            // Opening hours
            var open_times = [];
            if(place_details['opening_hours'] !== undefined){
              if(place_details['opening_hours']['periods'] !== undefined){
                place_details['opening_hours']['weekday_text'].forEach(function(period){
                  //console.log(period.split(': '));
                  open_times.push(period.split(': '));
                })                  
              }
              console.log(open_times);
            }              

            $("#week-days").html('');
            $("#open-time").html('');

            open_times.forEach(function(open_time){
              style = '';
              console.log([today.toLowerCase() , open_time[0].toLowerCase()]);
              if(today.toLowerCase() == open_time[0].toLowerCase()){
                style= 'style="font-weight: 600; opacity: 1;"';
              }
              $("#week-days").append('<div class="time day" '+style+'>'+open_time[0]+'</div>');
              $("#open-time").append('<div class="time"'+style+'>'+open_time[1]+'</div>');

            });

            // Image
            if(place_details['photos'] !== undefined){ 
              $("#cover-image").css("background-image", "url("+place_details['photos'][1].getUrl({maxHeight: 900})+")");
            }else{
              $("#cover-image").css("background-image", "url(default-image.jpg)");
            }
            
          }
        });      
        
      });

    </script>
</html>
