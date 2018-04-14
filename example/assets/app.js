var weekday = new Array(7);
weekday[0] = "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var current_date;

function amTime(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}


var input = document.getElementById('search-input');
var address_input = document.getElementById('address-search-input');
var service;
var address_autocomplete;
var place_type = 'restaurant';


var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(-39.72465582215755, 113.08936737466638), new google.maps.LatLng(-10.8556105884471, 154.39796112466638));
var options = {
    bounds: defaultBounds,
    strictBounds: true,
    //componentRestrictions: {'country': ['il']},
    types: ["address"]
}


if(input !== undefined && input !== null){
  add_input_autocomplete();
}

if(address_input !== undefined && address_input !== null){

  add_address_input_autocomplete(address_input, options);
}








function add_address_input_autocomplete(input, options){
  console.log(3);
  service = new google.maps.places.PlacesService(input);

  address_autocomplete = new google.maps.places.Autocomplete(address_input, options);


  address_autocomplete.addListener('place_changed', function() {
      var place = address_autocomplete.getPlace();

      $('.user-address').html(place['formatted_address']);

      var request = {
        location: place['geometry'].location,
        radius: '500',
        type: [place_type]
      };    

      console.log(request);

      service = new google.maps.places.PlacesService(input);
      nearbySearch(service, request, address_search_callback);
  });  
}

function nearbySearch(service, request, callback){
  service.nearbySearch(request, callback);
}

function address_search_callback(results, status) {
  console.log(results.length);
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    $("#search-results").html('');
    for (var i = 0; i < results.length; i++) {

      place_details = results[i];
      var photo = 'default-image.jpg';

      if (place_details['photos'] !== undefined) {
          photo = place_details['photos'][0].getUrl({
              maxHeight: 900
          });
      }


      // Open status
      var open = false;
      if(place_details['opening_hours'] !== undefined){
        if(place_details['opening_hours']['open_now'] == true){
          open = true;
        }
      }

      open_span = '';
      if(open){
        open_span = '<span class="open-status open">OPEN NOW</span> <span style="opacity:0.7" class="close-time">Closes in 2 hours</span>';
      }else{
         open_span = '<span class="open-status closed">CLOSED NOW</span>';
      }


      place_block = '<div class="column is-3">\
          <div class="place-card">\
            <a href="/palmer-co3.html">\
              <div class="featured-image" style="background-image:url('+photo+');">\
                <div class="closing-time is-size-6-mobile">\
                  '+open_span+'\
                </div>\
              </div>\
            </a>\
            <div style="padding-left: 20px; padding-right: 20px;">\
              <div class="name is-size-5-mobile">\
                '+place_details['name']+'\
              </div>\
              <div class="walking-distance is-size-6-mobile">\
                .....\
              </div>\
              <div class="is-size-6-mobile" style="font-size: 13px; padding-top: 0; padding-bottom: 20px;">\
                <a href="#" style="color: #FD696E;">\
                  Get directions <span style="position: relative; top: 2px; left: 3px;">→</span>\
                </a>\
              </div>\
            </div>\
          </div>\
        </div>';

      $("#search-results").append(place_block);

    }
  }
}









/*
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
            var today;
            try {
                today = new Date();
                today.setMinutes(today.getMinutes() + today.getTimezoneOffset())
                today.setMinutes(today.getMinutes() + place_details['utc_offset']);
                current_date = today;
            } catch (err) {
                console.log(err);
                today = new Date();
            }
            today = today.getDay();
            today = weekday[today];
            // Address
            $("#address").html(place_details['formatted_address']);
            // Phone
            $("#phone").html(place_details['formatted_phone_number']);
            // Name
            $('.place-name').html(place_details['name']);
            // Rating
            $('#google-rating').html(place_details['rating']);
            // Website
            if (place_details['website'] !== undefined) {
                $("#place-website").attr('href', place_details['website']);
            }
            // Open status
            var open = false;
            if (place_details['opening_hours'] !== undefined) {
                if (place_details['opening_hours']['open_now'] == true) {
                    open = true;
                }
            }
            if (open) {
                $(".open-status").removeClass('closed').addClass('open').html('OPEN NOW');
            } else {
                $(".open-status").removeClass('open').addClass('closed').html('CLOSED NOW');
            }
            // Opening hours
            var open_times = [];
            if (place_details['opening_hours'] !== undefined) {
                if (place_details['opening_hours']['periods'] !== undefined) {
                    place_details['opening_hours']['weekday_text'].forEach(function(period) {
                        //console.log(period.split(': '));
                        open_times.push(period.split(': '));
                    })
                }
                console.log(open_times);
            }
            $("#week-days").html('');
            $("#open-time").html('');
            open_times.forEach(function(open_time) {
                style = '';
                console.log([today.toLowerCase(), open_time[0].toLowerCase()]);
                if (today.toLowerCase() == open_time[0].toLowerCase()) {
                    style = 'style="font-weight: 600; opacity: 1;"';
                }
                $("#week-days").append('<div class="time day" ' + style + '>' + open_time[0] + '</div>');
                $("#open-time").append('<div class="time"' + style + '>' + open_time[1] + '</div>');
            });
            // Image
            if (place_details['photos'] !== undefined) {
                $("#cover-image").css("background-image", "url(" + place_details['photos'][1].getUrl({
                    maxHeight: 900
                }) + ")");
            } else {
                $("#cover-image").css("background-image", "url(default-image.jpg)");
            }
        }
    });
});


function place_callback(){

}*/