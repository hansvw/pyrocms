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

    $(document).ready(function()
    {
        initialize();
    });

/**
  * Syntactic sugar for methods.
  */
    Function.prototype.method = function (name, func)
    {
        this.prototype[name] = func;
        return this;
    };

    function Slide(slidedata)
    {
        this.data = slidedata;
    }

    Slide.method('toHtml', function()
    {
        var html = '';

        if(this.data['url'])
        {
            html += '<a href=\"' + this.data['url'] + '\">';
        }

        html += '<img src="' + this.data['src'] +
            '" height="' + this.data['height'] +
            '" width="' + this.data['width'] +
            '" alt="' + this.data['name'] + '"/>'

        if(this.data['url'])
        {
            html += '</a>';
        }

        return html;
    });

    function SlideShow(id, slideshowdata)
    {
        this.id = id;
        this.data = slideshowdata;
    }

    SlideShow.method('toHtml', function()
    {
        var html = '<div id=' + this.id + ' class="slideshow">';

        for(var i = 0; i < this.data.length; i++)
        {
            var slide = new Slide(this.data[i]);
            html += slide.toHtml();
        }

        html += '</div>';
        return html;
    });

    function InfoBubbleMarker(markerdata)
    {
        this.markerdata = markerdata;
    }

    InfoBubbleMarker.method('add', function(map)
    {
        var marker = new google.maps.Marker(
        {
            position: new google.maps.LatLng(this.markerdata.lat, this.markerdata.lng),
            animation: google.maps.Animation.DROP,
            map: map,
            icon: this.markerdata.imageFile
        });

        var infoBubble = new InfoBubble(
        {
            minWidth: 600,
            minHeight: 200
        });

//        google.maps.event.addListener(infoBubble, 'domready', function()
//        {
//            if($('.slideshow'))
//            {
//                $('.slideshow').show();
//                $('.slideshow').cycle(
//                {
//                    fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
//                    speed: 400,
//                    timeout: 3000
//                });
//            }
//        });

        for(var i = 0; i < this.markerdata['tabs'].length; i++)
        {
            var div = document.createElement('div');
            div.className="infotab";
            div.id = 'tab_'+this.markerdata['id'] + i;

            var html = '<div class="left">';
            if(this.markerdata['tabs'][i]['slideshow'] &&
               this.markerdata['tabs'][i]['slideshow'].length > 0)
            {
                var slideShow = new SlideShow(this.markerdata['id'] + i,
                    this.markerdata['tabs'][i]['slideshow']);
                html += slideShow.toHtml();
            }
            html += '</div>';

            html += '<div class="right">';
            html += this.markerdata['tabs'][i].divText;
            html += "</div>";

            div.innerHTML = html;

            infoBubble.addTab("<span class=\"markerTrulloveStyle\">" + this.markerdata['tabs'][i].tabText + "</span>", div);
            // infoBubble.addTab(this.markerdata['tabs'][i].tabText, div);
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

        var mapOptions =
            {
                zoom: zoom,
                center: initiallocation,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };

        map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
        
        for(var i = 0; i < markerjson['markers'].length; i++)
        {
            var marker = new InfoBubbleMarker(markerjson['markers'][i]);
            marker.add(map);
        }

//        var panoramioLayer1 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer1.setUserId("5590243");
//        panoramioLayer1.setMap(map);
        
//        var panoramioLayer2 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer2.setTag('trulli');
//        panoramioLayer2.setMap(map);
//
//        var panoramioLayer3 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer3.setTag('locorotondo');
//        panoramioLayer3.setMap(map);
//
//        var panoramioLayer4 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer4.setTag('grottaglie');
//        panoramioLayer4.setMap(map);
//
//        var panoramioLayer5 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer5.setTag('lecce');
//        panoramioLayer5.setMap(map);
//
//        var panoramioLayer6 = new google.maps.panoramio.PanoramioLayer();
//        panoramioLayer5.setTag('monte trazzonara');
//        panoramioLayer5.setMap(map);

        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
    }