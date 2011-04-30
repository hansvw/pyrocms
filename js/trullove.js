/*
 * trullove.js
 * Trullove Google Map.
 */
/** Google Map v3 */
    var map = null;
    var initiallocation = new google.maps.LatLng(40.624580,17.40206);


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

    function InfoBubbleMarker(markerdata)
    {
        this.markerdata = markerdata;
    }

    InfoBubbleMarker.method('add', function(map)
    {
        var marker = new google.maps.Marker(
        {
            position: new google.maps.LatLng(this.markerdata.lat, this.markerdata.lng),
            //animation: google.maps.Animation.DROP,
            map: map,
            icon: this.markerdata.imageFile
        });

        var infoBubble = new InfoBubble({
          maxWidth: 300
        });

        for(var i = 0; i < this.markerdata['tabs'].length; i++)
        {
            var div = document.createElement('div');
            div.innerHTML = this.markerdata['tabs'][i].divText;
            infoBubble.addTab(this.markerdata['tabs'][i].tabText, div);
        }
        
        google.maps.event.addListener(marker, 'click', function()
        {
            if (!infoBubble.isOpen())
            {
                infoBubble.open(map, marker);
            }
        });
    });

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
                    /// google.maps.MapTypeId.SATELLITE,
                    google.maps.MapTypeId.ROADMAP,
                    google.maps.MapTypeId.HYBRID,
                    google.maps.MapTypeId.TERRAIN,
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

        for(var i = 0; i < markerjson['markers'].length; i++)
        {
            var marker = new InfoBubbleMarker(markerjson['markers'][i]);
            marker.add(map);
        }

        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
        
    }