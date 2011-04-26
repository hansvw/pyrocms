/*
 * trullove.js
 * Trullove Google Map.
 */
/** Google Map v3 */
    var map = null;
    var initiallocation = new google.maps.LatLng(40.624580,17.40206);

    var trulloveImage = 'images/trullove-marker.png';
    var trulloveLatLng = new google.maps.LatLng(40.624580,17.40206);

    var airportImage = 'images/airport-icon.png';
    var airportBariLatLng = new google.maps.LatLng(41.13762, 16.76522);
    var airportBrindisiLatLng = new google.maps.LatLng(40.65824, 17.93921);


/**
  * Viewer initialization. Internet explorer versions 5.5 -> 7.0 have issues
  * with onload function in body tag. This approach works across browsers.
  */
    var alreadyRun = false;

    window.onload = function()
    {
      if (alreadyRun) {return;}
      alreadyRun = true;
      initialize();
    }

/**
  * Syntactic sugar for methods.
  */
    Function.prototype.method = function (name, func)
    {
        this.prototype[name] = func;
        return this;
    };

    function initialize()
    {
        var zoom = 9;

        var trulloveStyles= [
            {
                featureType: "road.local",
                elementType: "geometry",
                stylers: [
                    { hue: "#00ff00" },
                    { saturation:100 }
                ]
            },
            {
                featureType: "landscape",
                elementType: "geometry",
                stylers:
                [
                    { lightness: -10 }
                ]
            }
            ,
            {
                featureType: "transit.station.airport",
                elementType: "geometry"
            }

        ];

        var styledMapOptions =
        {
            name: "Trullove"
        }

        var trulloveMapType = new google.maps.StyledMapType(
            trulloveStyles, styledMapOptions);

        var myOptions =
        {
            zoom: zoom,
	    	center: initiallocation,
            mapTypeControlOptions: {
                mapTypeIds: [
                    google.maps.MapTypeId.ROADMAP,
                    google.maps.MapTypeId.TERRAIN,
                    google.maps.MapTypeId.SATELLITE,
                    'Trullove']
            }
        };

        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);

        google.maps.event.addListener(map, 'zoom_changed', function()
        {
        });

        map.mapTypes.set('Trullove', trulloveMapType);
        map.setMapTypeId('Trullove');

        var trulloveMarker = new google.maps.Marker({
            position: trulloveLatLng,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: trulloveImage
        });

        var airportBrindisiMarker = new google.maps.Marker({
            position: airportBrindisiLatLng,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: airportImage
        });

        var airportBariMarker = new google.maps.Marker({
            position: airportBariLatLng,
            animation: google.maps.Animation.DROP,
            map: map,
            icon: airportImage
        });

        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
    }