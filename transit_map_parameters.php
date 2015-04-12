<script>
var min_zoom = 3,
max_zoom = 19;

// Set map bounds -- are in which map can be panned
var bounds_point_A = new Array( 37.111,-120.74 ),
bounds_point_B = new Array( 38.268,-118.462 );

<?php

$agency_id = Array(114,216);

$routes_array = array(580,582,1094,1322,1323,1321);

$default_routes_bounds = array(580,582,1094,1322,1323,1321);

?>

var map_id_base = 'trilliumtransit.11e2641a',
map_id_labels = 'trilliumtransit.d575ec4e',
attribution = 'Street data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> (and) contributors, CC-BY-SA <a href="https://www.mapbox.com/map-feedback/" >Improve this map</a></div>',
default_icon_color = '575757';

// Provide your access token
accessToken = 'pk.eyJ1IjoidHJpbGxpdW10cmFuc2l0IiwiYSI6ImVUQ2x0blUifQ.2-Z9TGHmyjRzy5GC1J9BTw';

// development
// var map_app_base = 'http://localhost:80/sctransit.com/wp-content/themes/sctransit/map/';
// var map_app_base = 'http://dev.sctransit.com/wp-content/themes/sctransit/map/';
var map_app_base = 'http://applications.trilliumtransit.com/clients/GTFSMap/';

// remote scripts
var remote_base = 'http://applications.trilliumtransit.com/GTFSMap/';
var gtfs_api_feed_name = 'yosemite-ca-us';

</script>