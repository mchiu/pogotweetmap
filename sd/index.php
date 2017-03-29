<?php #nothing ?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Pokemon from Twitter</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 

<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: arial, helvetica;
      }
      #map {
        height: 100%;
      }
      
      .pogo_name { font-weight: bold; font-size: 1.1em; }
      .tth_red { color: red; font-weight: bold; }
      .tth_orange { color: orange; font-weight: bold; }
      .tth_yellow { color: #CCCC00; font-weight: bold; }
      .tth_green { color: green; font-weight: bold; }
</style>
</head>

<body>
    <div id="map"></div>
    <script>
        var comics = (function () {
            var json = null;
            $.ajax({
                'async': false,
                'global': false,
                'url': "https://api.myjson.com/bins/au1uf",
                'dataType': "json",
                'success': function (data) {
                    json = data;
                }
            });
            return json;
        })(); 
      
        function initMap() {
            // Create the map.
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 32.85698, lng: -117.20473},
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
/*
            map.addListener("zoom_changed", function() {
                var newzoom = map.getZoom();
                alert(newzoom);
            });
*/
            infowindow = new google.maps.InfoWindow({
                content: "loading..."
            });

            for (var pokemon in comics) {

                var image = {
                    url: "http://155.94.189.29/pg_images/vertical_sprites.png",
                    size: new google.maps.Size(40, 50), // scaled size
                    origin: new google.maps.Point(0, 50*(parseInt(comics[pokemon].dex) - 1)), // origin
                    anchor: new google.maps.Point(20,25) // anchor
                };

                var tth = new Date(comics[pokemon].tth);
                var diff = Math.abs(new Date() - tth)/60000;
            
                if (diff < 0) {
           //         alert(comics[pokemon].tth);
                    continue;
                }

                if (diff > 15) {
                    color = 'green';
                } else if (diff > 10)
                    color = 'yellow';
                else if (diff > 5)
                    color = 'orange';
                else
                    color = 'red';

                var myLatLng = new google.maps.LatLng(comics[pokemon].lat, comics[pokemon].lng);

                var gmaplink = 'https://maps.google.com?q=' + comics[pokemon].lat + "," + comics[pokemon].lng;
                var amaplink = 'http://maps.apple.com/?q=' + comics[pokemon].lat + "," + comics[pokemon].lng + '&z=10&t=h';

                var marker = new google.maps.Marker({
                    map: map,
                    position: myLatLng,
                    label: {
                        color: '#666',
                        size: '.7em',
                        fontWeight: 'bold',
                        text: comics[pokemon].name,
                    },
                    icon: {
                        labelOrigin: new google.maps.Point(5, 25),
                        url: 'http://maps.google.com/mapfiles/ms/icons/' + color + '-dot.png',
                        size: new google.maps.Size(32, 32),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(8, 16)
                    },  
                      html: "<span class='pogo_name'><a href='" + gmaplink + "' target='_blank'>" + comics[pokemon].name + "</a></span> Expires: <strong>" + pad(tth.getHours(), 2) + ":" + pad(tth.getMinutes(), 2) + ":" + pad(tth.getSeconds(), 2) + "; " + Math.floor(diff) + "min " + Math.floor(60*(diff - Math.floor(diff))) + "sec left</strong><br />" + comics[pokemon].att + "<br /><a href='" + amaplink + "' target='_blank'>Apple Map link</a>&nbsp;&nbsp;" + comics[pokemon].lat + "," + comics[pokemon].lng
                });

                google.maps.event.addListener(marker, "click", function () {
                    infowindow.setContent(this.html);
                    infowindow.open(map, this);
                });

            }
        }

        function pad(number, length) {
            var str = '' + number;
            while (str.length < length) {
                str = '0' + str;
            }
            return str;
        }
    </script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXMKBcstoboBgrHBcho5saILTBq3PHtPQ&callback=initMap"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96337167-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
