
var AUT_GMAP = {

    GMap : {

        gMapRefs : [],

        markers : [],

        icon : {
            image: "images/marker_red.png",
            iconsize: [32, 39],
            iconanchor: [13, 39]
        },

        // -------------------------
        // Map Style definition
        // -------------------------

        // Custom core styles
        // Get more styles from http://snazzymaps.com/style/29/light-monochrome
        // - Just replace and assign to 'MapStyles' the new style array
        MapStyles  : [{featureType:'water',stylers:[{visibility:'on'},{color:'#bdd1f9'}]},{featureType:'all',elementType:'labels.text.fill',stylers:[{color:'#334165'}]},{featureType:'landscape',stylers:[{color:'#e9ebf1'}]},{featureType:'road.highway',elementType:'geometry',stylers:[{color:'#c5c6c6'}]},{featureType:'road.arterial',elementType:'geometry',stylers:[{color:'#fff'}]},{featureType:'road.local',elementType:'geometry',stylers:[{color:'#fff'}]},{featureType:'transit',elementType:'geometry',stylers:[{color:'#d8dbe0'}]},{featureType:'poi',elementType:'geometry',stylers:[{color:'#cfd5e0'}]},{featureType:'administrative',stylers:[{visibility:'on'},{lightness:33}]},{featureType:'poi.park',elementType:'labels',stylers:[{visibility:'on'},{lightness:20}]},{featureType:'road',stylers:[{color:'#d8dbe0',lightness:20}]}],

        // -------------------------
        //      Map Function
        // -------------------------

        reverseGeoCoding: function (map ,lat ,lng) {

            var geocoder = new google.maps.Geocoder(),
                latlng = new google.maps.LatLng(lat, lng);

            // geocoder.geocode( { 'address': address}, function(results, status) { });
            geocoder.geocode({ 'latLng': latlng }, function(results, status) {

                if (status == google.maps.GeocoderStatus.OK) {

                    if(map.reverseGeoCoding)
                    {
                        var reverseGeoCoding = $(map._this).siblings(map.reverseGeoCoding);

                        if((results[0].formatted_address).match('Unnamed Road'))
                            $(map._this).siblings(map.reverseGeoCoding).val(results[1].formatted_address);
                        else
                            $(map._this).siblings(map.reverseGeoCoding).val(results[0].formatted_address);
                    }

                } else {

                    console.log("Geocoder failed due to: " + status);
                }
            });
        },

        autocompleteMap : function (map) {

            // This example adds a search box to a map, using the Google Place Autocomplete
            // feature. People can enter geographical searches. The search box will return a
            // pick list containing a mix of places and predicted search terms.

            // This example requires the Places library. Include the libraries=places
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

            // var map = new google.maps.Map(document.getElementById('map'), {
            //     center: {lat: -33.8688, lng: 151.2195},
            //     zoom: 13,
            //     mapTypeId: 'roadmap'
            // });

            var _map = map.obj;

            // Create the search box and link it to the UI element.
            var input = $(map._this).siblings('.maps-search').find('#component-maps-search').clone()[0];
            var searchBox = new google.maps.places.SearchBox(input);
            _map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            _map.addListener('bounds_changed', function() {
                searchBox.setBounds(_map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    AUT_GMAP.GMap.clearMapMarkers(map._this ,_map);
                    markers.push(new google.maps.Marker({
                        map: _map,
                        title: place.name,
                        position: place.geometry.location,
                        animation: google.maps.Animation.DROP,
                    }));

                    AUT_GMAP.GMap.fillInputLocation(map , {
                        location : place.geometry.location.toUrlValue(),
                        lat : place.geometry.location.lat(),
                        lng : place.geometry.location.lng(),
                    });

                    AUT_GMAP.GMap.reverseGeoCoding(map ,place.geometry.location.lat(),place.geometry.location.lng());

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                _map.fitBounds(bounds);
            });
        },

        onMapClick : function (map) {

            var _map = map.obj;

            google.maps.event.addListener(_map, 'click', function (event) {

                // Create a marker for each place.
                AUT_GMAP.GMap.clearMapMarkers(map._this ,_map);
                new google.maps.Marker({
                    map: _map,
                    animation: google.maps.Animation.DROP,
                    position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
                });

                AUT_GMAP.GMap.fillInputLocation(map , {
                    location : event.latLng.toUrlValue(),
                    lat : event.latLng.lat(),
                    lng :  event.latLng.lng()
                });

                AUT_GMAP.GMap.reverseGeoCoding(map ,event.latLng.lat() ,event.latLng.lng());
            });
        },

        yourLocationNavigatorGeoLocationButton :  function (map) {

            var _map = map.obj;

            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '28px';
            firstChild.style.height = '28px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '5px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-2x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0 0';
            secondChild.style.backgroundRepeat = 'no-repeat';
            firstChild.appendChild(secondChild);

            google.maps.event.addListener(_map, 'center_changed', function () {
                secondChild.style['background-position'] = '0 0';
            });

            firstChild.addEventListener('click', function (event) {

                event.preventDefault();

                var imgX = '0',
                    animationInterval = setInterval(function () {
                        imgX = imgX === '-18' ? '0' : '-18';
                        secondChild.style['background-position'] = imgX+'px 0';
                    }, 500);

                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {

                        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        _map.setCenter(latlng);

                        AUT_GMAP.GMap.clearMapMarkers(map._this ,_map);
                        new google.maps.Marker({
                            map: _map,
                            animation: google.maps.Animation.DROP,
                            position: latlng
                        });

                        AUT_GMAP.GMap.fillInputLocation(map , {
                            location : latlng.toUrlValue(),
                            lat : position.coords.latitude,
                            lng : position.coords.longitude
                        });

                        AUT_GMAP.GMap.reverseGeoCoding(map ,position.coords.latitude,position.coords.longitude);

                        clearInterval(animationInterval);
                        secondChild.style['background-position'] = '-144px 0';
                    });
                } else {
                    clearInterval(animationInterval);
                    secondChild.style['background-position'] = '0 0';
                }
            });

            controlDiv.index = 1;
            _map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
        },

        googleMapExtraFunction : function ($mapLoaded) {

            if(typeof(google) != 'undefined' && typeof($.fn.gMap) != 'undefined' && !$mapLoaded)
            {
                google.maps.Map.prototype.markers = new Array();

                google.maps.Map.prototype.getMarkers = function () {
                    return this.markers
                };

                google.maps.Map.prototype.clearMapMarkers = function () {
                    for (var i = 0; i < this.markers.length; i++) {
                        this.markers[i].setMap(null);
                    }
                    this.markers = new Array();
                };

                google.maps.Marker.prototype._setMap = google.maps.Marker.prototype.setMap;

                google.maps.Marker.prototype.setMap = function (map) {
                    if (map) {
                        map.markers[map.markers.length] = this;
                    }
                    this._setMap(map);
                }
            }
        },

        fillInputLocation : function (param ,LatLng) {

            if(param.location)
                $(param._this).siblings(param.location).val(LatLng.location);

            if(param.lat)
                $(param._this).siblings(param.lat).val(LatLng.lat);

            if(param.lng)
                $(param._this).siblings(param.lng).val(LatLng.lng);
        },

        clearMapMarkers : function(_this ,_map) {

            $(_this).gMap('clearMarkers');
            _map.clearMapMarkers();
        },

        setMapWithMarker : function (param , options, geoLocation) {

            for(var current in geoLocation)  {
                if(typeof geoLocation[current] == 'string') {
                    AUT_GMAP.GMap.markers.push({
                        address:  geoLocation[current],
                        html:     (param.titles && param.titles[current]) || '',
                        popup:    true,   /* Always popup */
                        animation: google.maps.Animation.DROP,
                        icon: AUT_GMAP.GMap.icon
                    });
                }
            }

            var gMap = param.$this.gMap(options);

            var map = gMap.data('gMap.reference').data.map;

            var _e = {
                obj : map,
                _this : param.this,
                location : param.geoLocationInputSelector.location,
                lat : param.geoLocationInputSelector.lat,
                lng : param.geoLocationInputSelector.lng,
                reverseGeoCoding: param.geoLocationInputSelector.reverseGeoCoding
            };

            if(param.onclick)
                AUT_GMAP.GMap.onMapClick(_e);

            if(param.hasAutocomplete)
                AUT_GMAP.GMap.autocompleteMap(_e);

            if(param.hasNavigator)
                AUT_GMAP.GMap.yourLocationNavigatorGeoLocationButton(_e);

            google.maps.event.addListenerOnce(map, 'idle', function() {
                // do something only the first time the map is loaded
                var $map = $(_e._this); // $(this.__gm.S);

                var latlng = new google.maps.LatLng(map.center.lat(), map.center.lng());

                AUT_GMAP.GMap.fillInputLocation(_e ,{
                    location : latlng.toUrlValue(),
                    lat : map.center.lat(),
                    lng : map.center.lng()
                });

                AUT_GMAP.GMap.reverseGeoCoding(_e ,map.center.lat() ,map.center.lng());

                //if you need no stop load map en each time open modal put an attribute data-map-reload = false
                if(!JSON.parse($map.attr('data-map-reload')))
                    $map.attr('data-initialize' ,false);

                //laod event extra when first map is loaded
                var mapEventLoaded = $('body').attr('data-map-event-loaded');
                mapEventLoaded = typeof mapEventLoaded != typeof undefined
                    ? JSON.parse(mapEventLoaded)
                    : false;

                AUT_GMAP.GMap.googleMapExtraFunction(mapEventLoaded);

                //this to make sure event will not load again
                $('body').attr('data-map-event-loaded' ,true);
            });

            //google.maps.event.addDomListener(map, 'load', function () { });
            //google.maps.event.addListenerOnce(map, 'tilesloaded', function () { });

            var ref = gMap.data('gMap.reference');
            // save in the map references list
            AUT_GMAP.GMap.gMapRefs.push(ref);

            // set the styles
            if(param.$this.data('styled') !== undefined) {

                ref.setOptions({
                    styles: AUT_GMAP.GMap.MapStyles
                });
            }
        },

        init : function (mapSelector ,location) {

            var mapSelector = typeof mapSelector != typeof undefined ? mapSelector : $('[data-gmap]');

            if(typeof(google) != 'undefined' && typeof($.fn.gMap) != 'undefined') {

                mapSelector.each(function() {

                    var initialize = JSON.parse($(this).attr('data-initialize'));
                    if(typeof initialize != typeof undefined && initialize)
                    {
                        AUT_GMAP.GMap.markers = [];

                        var $this   = $(this),
                            zoom    = $this.data('zoom') || 14,
                            maptype = $this.data('maptype') || 'ROADMAP' // or 'TERRAIN'

                        var param = {
                            $this                    : $this,
                            this                     : this,
                            titles                   : $this.data('title') && $this.data('title').split(';'),
                            onclick                  : $this.data('click') || false,
                            hasAutocomplete          : $this.data('autocomplete') || false,
                            hasNavigator             : $this.data('navigator') || false,
                            geoLocationInputSelector : $this.data('location') || { location: "#map-full-location" , lat: "#location" ,lng: "#map-lng-location" ,reverseGeoCoding: "#map-reverse-geo-coding" },
                        };

                        var options = {
                            controls: {
                                panControl:         true,
                                zoomControl:        true,
                                mapTypeControl:     true,
                                mapTypeControlOptions: {
                                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                                },
                                scaleControl:       true,
                                streetViewControl:  true,
                                fullscreenControl:  true,
                                fullscreenControlOptions: {
                                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                                    position : google.maps.ControlPosition.BOTTOM_LEFT
                                },
                                rotateControl:      true,
                                overviewMapControl: true
                            },
                            doubleclickzoom: false,
                            scrollwheel: true,
                            maptype: maptype,
                            markers: AUT_GMAP.GMap.markers,
                            zoom: zoom,
                            // More options https://github.com/marioestrada/jQuery-gMap
                        };

                        if(typeof location != typeof undefined && location)
                            AUT_GMAP.GMap.setMapWithMarker(param ,options ,location.split(';'));
                        else if(typeof $this.data('address') != typeof undefined)
                            AUT_GMAP.GMap.setMapWithMarker(param ,options ,$this.data('address').split(';'));
                        else if(navigator.geolocation)
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var geoLocationNavigator = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                AUT_GMAP.GMap.setMapWithMarker(param ,options ,latlng.toUrlValue().split(';'));
                            });
                        else
                            console.log('you must define at least one location ?!!!');
                    }
                });
            }
        }
    },

    map: {

        initGMapInputLocation: function () {

            $(document).on('click', '.input-location span:nth-child(2)', function () {

                var $this = $(this),
                    $input = $this.prev('input'),
                    $modal = $input.data('modal');

                $($modal).off('shown.bs.modal').on('shown.bs.modal', function (event) {

                    var location = $input.val();
                    AUT_GMAP.GMap.init($(this).find('[data-gmap]'), location);
                });

                $($modal).modal('show');
            });

            $(document).on('click', '.set-map-location', function () {

                var $this         = $(this),
                    $modal        = $this.closest('.modal'),
                    $locationData = $modal.find('[data-gmap]').data('location');

                var InputFullLocation      = $this.data('input-full-location');
                var InputLatLocation       = $this.data('input-lat-location');
                var InputLngLocation       = $this.data('input-lng-location');
                var InputReverseGeoCoding  = $this.data('input-reverse-geo-coding');

                if (InputFullLocation)
                    $(InputFullLocation).val($($locationData.location).val());
                if (InputLatLocation)
                    $(InputLatLocation).val($($locationData.lat).val());
                if (InputLngLocation)
                    $(InputLngLocation).val($($locationData.lng).val());
                if (InputReverseGeoCoding)
                    $(InputReverseGeoCoding).val($($locationData.reverseGeoCoding).val());

                $($modal).modal('hide');
            });
        },

        init: function () {

            AUT_GMAP.map.initGMapInputLocation();
        }
    }

};

/**=========================================================
 * Module: gmap.js
 * Init Google Map plugin
 =========================================================*/

(function($, window, document) {
    'use strict';

    AUT_GMAP.GMap.init();

    AUT_GMAP.map.init();

}(jQuery, window, document));