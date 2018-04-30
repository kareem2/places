var weekday = new Array(7);
weekday[0] = "Sunday";
weekday[1] = "Monday";
weekday[2] = "Tuesday";
weekday[3] = "Wednesday";
weekday[4] = "Thursday";
weekday[5] = "Friday";
weekday[6] = "Saturday";
var current_date;
var searchQuery = getQuery();

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
//var place_type = ['restaurant', 'night_club', 'bar'];

var place_type = {
  'restaurant': {
    'title': 'Restaurants',
    'id_selector': 'restaurant_div',
    'name': 'restaurant'
  },
  'night_club': {
    'title': 'Clubs',
    'id_selector': 'night_club_div',
    'name': 'night_club'
  },
  'bar': {
    'title': 'Bars',
    'id_selector': 'bar_div',
    'name': 'bar'
  }  
};

var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(-39.72465582215755, 113.08936737466638), new google.maps.LatLng(-10.8556105884471, 154.39796112466638));
var options = {
    bounds: defaultBounds,
    strictBounds: true,
    //componentRestrictions: {'country': ['il']},
    types: ["address"]
}
if (input !== undefined && input !== null) {
    options = {
        bounds: defaultBounds,
        strictBounds: true,
        types: ["establishment"]
    };
    add_input_autocomplete(input, options);
}
if (address_input !== undefined && address_input !== null) {
    add_address_input_autocomplete(address_input, options);
}
if (searchQuery['place_id'] !== undefined) {
    get_palce_details(searchQuery['place_id'], populate_place);
}

function get_palce_details(place_id, callback) {
    input = document.createElement('input');
    service = new google.maps.places.PlacesService(input);
    service.getDetails({
        placeId: place_id
    }, function(place_details, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
            callback(place_details);
        } else {
            //alert('err');
        }
    });
}

function add_input_autocomplete(input, options) {
    service = new google.maps.places.PlacesService(input);
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        $(".close-time").html('');
        //console.log(place['place_id']);
        place_details = place;
        populate_place(place_details);
    });
}

function populate_place(place_details) {
    console.log(1);
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

    $("#zomato-rating").html('');

    // Address
    $("#address").html(place_details['formatted_address']);
    // Directions
    $("#directions-link").attr('href', getDirectionsLink(place_details['geometry']['location'].lat() + ',' + place_details['geometry']['location'].lng()));
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
        if (today.toLowerCase() == open_time[0].toLowerCase()) {
            style = 'style="font-weight: 600; opacity: 1;"';
        }
        $("#week-days").append('<div class="time day" ' + style + '>' + open_time[0] + '</div>');
        $("#open-time").append('<div class="time"' + style + '>' + open_time[1] + '</div>');
    });
    // Close time
    $(".close-time").html(closeTime(place_details));
    // Image
    if (place_details['photos'] !== undefined) {
        $("#cover-image").css("background-image", "url(" + place_details['photos'][0].getUrl({
            maxHeight: 900
        }) + ")");
    } else {
        $("#cover-image").css("background-image", "url(default-image.jpg)");
    }
    // Zomato Rating
    matchGoogleWithZomato(place_details, function(results) {
        var zomato;

        if (results.restaurants !== undefined) {
            console.log(results.restaurants);
            min_distance = 999999999999;
            //results.restaurants.forEach(function(restaurant) {
            for(i in results.restaurants){
                
                restaurant = results.restaurants[i];

                
                google_location = new google.maps.LatLng(
                  Number(place_details['geometry']['location'].lat().toFixed(3)), 
                  Number(place_details['geometry']['location'].lng().toFixed(3)));

                zomato_location = new google.maps.LatLng(
                  Number(restaurant.restaurant.location.latitude).toFixed(3), 
                  Number(restaurant.restaurant.location.longitude).toFixed(3));

                distance = google.maps.geometry.spherical.computeDistanceBetween(google_location, zomato_location);

                console.log(distance);
                if(distance <= 100 && distance < min_distance){
                  min_distance = distance;
                  zomato = restaurant.restaurant;

                  console.log('min founded');
                  
                  //break;
                }

            }
        }
        if(zomato !== undefined)
          $("#zomato-rating").html(zomato.user_rating.aggregate_rating);
    });
}

function add_address_input_autocomplete(input, options) {
    service = new google.maps.places.PlacesService(input);
    address_autocomplete = new google.maps.places.Autocomplete(address_input, options);
    address_autocomplete.addListener('place_changed', function() {
        var place = address_autocomplete.getPlace();

        $('.user-address').html(place['formatted_address']);

        $("#search-results").html('');
        
        for(var type in place_type){
          $("#search-results").append('<div class="column is-12 columns is-variable is-multiline place-grid" id="'+place_type[type]['id_selector']+'">\
              <h1 class="title is-size-5-desktop is-size-4-mobile column is-12">'+place_type[type]['title']+'</h1>\
            </div>');
        }

        for(var type in place_type){
        //place_type.forEach(function(type){
          var request = {
              location: place['geometry'].location,
              radius: '1000',
              type: [type],
              openNow: true
          };
          
          nearbySearch(service, request, address_search_callback, place_type[type]);
        }
        //);


    });
}

function nearbySearch(service, request, callback, type) {
    service.nearbySearch(request, function(results, status){
      callback(results, status, type);
    });
}

function address_search_callback(results, status, type) {
    console.log(type + ' results:');
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        
        $.each(results, function(i, place_details) {
            place_details = results[i];

            get_palce_details(place_details['place_id'], function(details) {

                var photo = 'default-image.jpg';
                if (place_details['photos'] !== undefined) {
                    photo = place_details['photos'][0].getUrl({
                        maxHeight: 900
                    });
                }
                // Open status
                var open = false;
                if (place_details['opening_hours'] !== undefined) {
                    if (place_details['opening_hours']['open_now'] == true) {
                        open = true;
                    }
                }
                open_span = '';
                if (open) {
                    open_span = '<span class="open-status open">OPEN NOW</span> <span style="opacity:0.7" class="close-time"></span>';
                } else {
                    open_span = '<span class="open-status closed">CLOSED NOW</span>';
                }
                place_block = '<div class="column is-3">\
                  <div class="place-card">\
                    <a target="_blank" href="place_details.html?place_id=' + place_details['place_id'] + '">\
                      <div class="featured-image" style="background-image:url(' + photo + ');">\
                        <div class="closing-time is-size-6-mobile">\
                          ' + open_span + '\
                        </div>\
                      </div>\
                    </a>\
                    <div style="padding-left: 20px; padding-right: 20px;">\
                      <div class="name is-size-5-mobile">\
                        ' + place_details['name'] + '\
                      </div>\
                      <div class="close-time">' + closeTime(details) + '</div>\
                      <div class="is-size-6-mobile" style="font-size: 13px; padding-top: 0; padding-bottom: 20px;">\
                        <a target="_blank" href="' + getDirectionsLink(place_details['geometry']['location'].lat() + ',' + place_details['geometry']['location'].lng()) + '" style="color: #FD696E;">\
                          Get directions <span style="position: relative; top: 2px; left: 3px;">→</span>\
                        </a>\
                      </div>\
                    </div>\
                  </div>\
                </div>';

                $("#"+type['id_selector']).append(place_block);
            });
        });
        //}
        if (results.length == 0) {
            //$("#search-results").html('There is no opened places on this location right now!');
        }
    } else {
        //$("#search-results").html('There is no opened places on this location right now!');
    }
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    console.log(position);
}

function timeLeft(diff) {
    var hours = Math.floor(diff / 3.6e6);
    var minutes = Math.floor((diff % 3.6e6) / 6e4);
    var seconds = Math.floor((diff % 6e4) / 1000);
    var out = '';
    if (hours > 0) {
        out = out + hours + ' hours';
        if (minutes > 0) {
            out = out + ' and ' + minutes + ' minutes.';
        }
    } else if (minutes > 0) {
        out = out + minutes + ' minutes.';
    }
    return out;
}

function closeTime(place_details) {
    var will_close = false;
    var close_time;
    try {
        console.log(place_details);
        for (var x = 0; x < place_details['opening_hours']['periods'].length; x++) {

            today = new Date();
            today.setMinutes(today.getMinutes() + today.getTimezoneOffset())
            today.setMinutes(today.getMinutes() + place_details['utc_offset']);
            current_date = today;

            period = place_details['opening_hours']['periods'][x];
            open_day = period.open.day;
            close_day = period.close.day;

            if (current_date.getDay() >= open_day && current_date.getDay() <= close_day){
                open_date = new Date(current_date.getFullYear(), current_date.getMonth(), current_date.getDate() - (current_date.getDay() - open_day), period.open.hours, period.open.minutes);

                close_date = new Date(current_date.getFullYear(), current_date.getMonth(), current_date.getDate() + (close_day - current_date.getDay()), period.close.hours, period.close.minutes);

                if (current_date.getTime() >= open_date.getTime() && current_date.getTime() <= close_date.getTime()) {

                    diff = close_date - current_date;

                    console.log({
                        'current_date': current_date,
                        'open_date': open_date,
                        'close_date': close_date,
                        'period': period
                    });
                    
                    close_time = diff;
                    will_close = true;

                    break;
                }
            }
        }
    } catch (err) {
        console.log(err);
    }

    if(will_close == true){
      return 'Close in ' + timeLeft(close_time);
    }else{
      return 'Open 24 hours.';
    }
}

function getQuery() {
    output = [];
    try {
        window.location.search.split('?')[1].split('&').forEach(function(q) {
            p = q.split('=');
            output[p[0]] = p[1];
        })
    } catch (err) {}
    return output;
}

function getDirectionsLink(address) {
    return 'https://www.google.com/maps/dir/?api=1&destination=' + address;
}

function getZomatoDetails(q, lat, lng, callback) {
    var results;
    var jqxhr = $.ajax({
        url: "https://developers.zomato.com/api/v2.1/search",
        method: "GET",
        //async: false,
        data: {
            q: q,
            lat: lat,
            lon: lng
        },
        headers: {
            "Accept": "application/json",
            "user-key": "1806fad27a93f44e553187811a3a5592"
        }
    }).done(function(data) {
        callback(data);
        //return 'adsfadasd';//data;
    }).fail(function(err) {
        //console.log(err);
    });
    return results;
}

function matchGoogleWithZomato(place_details, callback) {
    getZomatoDetails(place_details['name'], place_details['geometry']['location'].lat(), place_details['geometry']['location'].lng(), callback);
}


/*

                    console.log({
                        'current_date': current_date,
                        'open_date': open_date,
                        'close_date': close_date,
                        'period': period
                    });

*/