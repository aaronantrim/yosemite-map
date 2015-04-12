<!DOCTYPE html>
<html>
<head>
	<title>Yosemite Area Regional Transportation System</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="map-quadrants.js"></script>
	<link rel="stylesheet" href="map.css" />

	<base target="_parent" />

	<style type="text/css">
		html { height: 100% }
		body { height: 100%; margin: 0; padding: 0; font-family: helvetica, sans-serif;}
		#key {
			width:370px;
			height:100%;
			position: fixed;
			left: 0;
			float:left;
			padding:10px;
			overflow-y:scroll;
			overflow-x:none;
			margin-top: 165px;
			// background-color:rgba(156,186,239,0.8);
         }
        #map {
	      position:fixed;
	      right: 0;
	      bottom: 0;
	      width:72%;
	      height:100%;
         }
        td {padding:4px;}
		/* = MAP KEY ----------------------------------------------- */
        .keybox {
			position: absolute;
			bottom: 23px;
			right: 10px;
			padding: 10px 15px;
			background: #ffffff;
			background: rgba(255, 255, 255, 0.93);
			border-radius: 4px;
			z-index: 3;
		}

		.keybox h1 {
			font-size:1.1em;
		    padding:0;
		}

		.keybox ul {
		list-style:none;
		list-style-type:none;
		padding:0;
		}
		.keybox ul li {
			margin: 0 0 5px 0;
			list-style: none;
			font-size: .88em;
			color: #444444;
		}

		.keybox ul li img {
			width: 30px;
			margin: 0 10px 0 0;
		}

    </style>

</head>

<body>

	<div id="map"></div>

	<?php
		require_once ('transit_map_parameters.php');
		require_once ('transit_map_core_setup.php');

		// if there are custom features & layers, insert those configuration files here
		require_once ('custom_layers/transit_map_custom_setup.inc.php');
	?>

	<div id='top-key'>
		<h1>Yosemite Region</h1>
		<h2 class='services'>Transit Routes</h2>
		<div id='select_all_routes' class='select-all-button' >Show All Routes</div>
		<div id='deselect_all_routes' class='select-all-button'>Hide All Routes</div>
		<br/><div class='instructions instructions-first'>Scroll to see all routes<br/>Click a numbered circle to zoom in on that route.</div><br/>
<!-- 		<div class='instructions'>Click a magnifying glass to zoom in on that route. <span class="search-icon"></span></div> -->
	</div>


<script>

var landmarks_status_array = new Array(0,0,0,0,0);

function toggle_landmark_layer(layer_id) {

    if (landmarks_status_array[layer_id] == 0) {
    	console.log('landmarks_status_array[layer_id] == 0');
        load_landmarks(layer_id);
        landmarks_status_array[layer_id] = 1;

        for (var i = 0; i < landmarks_status_array.length; i++) {
			if (i !== layer_id) {landmarks_status_array[i] = 0;}
		}


    } else {
        landmarks_status_array[layer_id] = 0;
        remove_landmarks(layer_id);
        console.log('remove_landmarks('+layer_id+')');
		add_base_tile_layer();
    }
}


</script>


<!-- 
<div id='bottom-key'>
		<div class="filter-icon" id="toggle-trails" onclick="toggle_landmark_layer(4);">
			<img src="icons/SCT_TransitTrails.png" width="36" height="36">
			<span>Trails</span>
		</div>
	</div>
 -->




<div id="key">
		<?php
/* BEGIN making the route rows on the left of the page. */
/* Note: I need to add back in route_ids for some of the connected routes */
		$routeInfo =
"114;582;YARTS;;;Mammoth Lakes HWY 120E/395;0c5e2f;http://yarts.com/schedules.html
114;580;YARTS;;;Merced HWY 140 ;43581;http://www.yarts.com/schedules.html
114;1094;YARTS;;;Sonora HWY 120;7e172c;http://yarts.com/schedules.html
216;1322;Park Shuttle;;;El Capitan Shuttle;621B4B;http://www.nps.gov/yose/planyourvisit/upload/valleyshuttle.pdf
216;1323;Park Shuttle;;;Express Shuttle;CE6F18;http://www.nps.gov/yose/planyourvisit/upload/valleyshuttle.pdf
216;1321;Park Shuttle;;;Valley Shuttle;026F51;http://www.nps.gov/yose/planyourvisit/upload/valleyshuttle.pdf";
		
// "175;[1038,1046];Monday - Saturday;South;10;Cotati, Rohnert Park, Sonoma State University;ee652e;0;http://www.sctransit.com/maps-schedules/route-10/;1038
// 175;[1039,1047];Monday - Saturday;South;12;Northern Rohnert Park;898989;ffffff;http://www.sctransit.com/maps-schedules/route-12-route-14/;1039
// 175;[1040,1048];Monday - Friday;South;14;Northern Rohnert Park;ca4f98;0;http://www.sctransit.com/maps-schedules/route-12-route-14/;1040
// 175;[1026,1049];Monday - Sunday;West;20;Russian River Area, Forestville, Sebastopol, Santa Rosa;282828;ffffff;http://www.sctransit.com/maps-schedules/route-20/;1049
// 175;1027;Monday - Friday;West;22;Sebastopol, Santa Rosa;4b8dc8;0;http://www.sctransit.com/maps-schedules/route-22/
// 175;1041;Weekday, Saturday;West;24;Sebastopol;441261;ffffff;http://www.sctransit.com/maps-schedules/route-24/
// 175;1028;Monday - Friday;West;26;Sebastopol, Rohnert Park, Cotati;9e1f63;0;http://www.sctransit.com/maps-schedules/route-26/
// 175;1042;Monday - Friday;West;28;Guerneville, Monte Rio;dda600;0;http://www.sctransit.com/maps-schedules/route-28/
// 175;[1029,1051];Monday - Sunday;East;30;Santa Rosa, Sonoma Valley;7238;ffffff;http://www.sctransit.com/maps-schedules/route-30/;1051
// 175;1043;Monday - Saturday;East;32;Sonoma Valley;5f3817;ffffff;http://www.sctransit.com/maps-schedules/route-32/
// 175;1050;Monday - Friday;East;34X;Santa Rosa, Sonoma;0156a4;ffffff;http://www.sctransit.com/maps-schedules/route-34/
// 175;1030;Monday - Friday;East;38;Sonoma Valley, San Rafael;e9098c;0;http://www.sctransit.com/maps-schedules/route-38/
// 175;1031;Monday - Friday;South;40;Sonoma, Petaluma;806517;ffffff;http://www.sctransit.com/maps-schedules/route-40/
// 175;1032;Monday - Friday;South;42;Santa Rosa, Industry West Business Park;fcdd13;0;http://www.sctransit.com/maps-schedules/route-42/
// 175;1033;Monday - Sunday;South;44;Petaluma JC, SSU, Santa Rosa;66308f;ffffff;http://www.sctransit.com/maps-schedules/route-44-route-48/
// 175;1034;Monday - Friday;South;46;Santa Rosa, Sonoma State University;99ff11;0;http://www.sctransit.com/maps-schedules/route-46/
// 175;[1035,1052];Daily Service;South;48;Petaluma, Rohnert Park, Cotati, Santa Rosa;0f004b;ffffff;http://www.sctransit.com/maps-schedules/route-44-route-48/;1052
// 175;[1036,1053];Daily Service;North;60;Cloverdale, Healdsburg, Windsor, Santa Rosa;00bff0;0;http://www.sctransit.com/maps-schedules/route-60/
// 175;1037;Monday - Friday;North;62;Santa Rosa, County Airport, Windsor;ea1d2c;ffffff;http://www.sctransit.com/maps-schedules/route-62/
// 175;1044;Monday - Saturday;North;66;Windsor Shuttle;3fb44f;0;http://www.sctransit.com/maps-schedules/route-66/
// 181;1079;Monday - Saturday;North;67;Healdsburg Shuttle;85009b;ffffff;http://sctransit.com/maps-schedules/route-67/
// 183;1045;Monday - Friday;North;68;Cloverdale Shuttle;a16118;ffffff;http://www.sctransit.com/maps-schedules/route-68/";

// this text can be generated from the routes xls file, exporting as tab separated list then find replace tabs with semicolons.
// https://docs.google.com/spreadsheet/ccc?key=0ArkC-1z7T8ujdFl0dFU2YTJ6aTR2azNERVROWWU4Y2c&usp=drive_web#gid=0
		$routeLines = explode("\n",$routeInfo);

		$routes = array();

		foreach($routeLines as &$routeLine) {
			$explodedLine = explode(";", $routeLine);

				array_push($routes, $explodedLine);
		}



		function makeRoutes($routes) {
			foreach($routes as &$routeLine) {

//				var_dump($routes_initial);

				$selected = "";
				if (in_array($routeLine[9],$routes_initial)) {$selected = " selected";}

				?>
				<div class="fancy-route-row <?php echo $selected ?> " style="display:block;" rel="<?php echo $routeLine[1]; ?>" onmouseover="highlight_route_alignment(<?php echo $routeLine[1]; ?>)" onmouseout="unhighlight_route_alignment(<?php echo $routeLine[1]; ?>)" onclick="focus_routes(<?php echo $routeLine[1]; ?>);load_stop_markers();">
				<div class="route-icon route-<?php echo $routeLine[4]; ?>-small"></div>
				<div class="title">
					<span class="text"><?php echo $routeLine[5]; ?></span>
					<br />
					<span class="route-row-days"><?php echo $routeLine[2]; ?></span>
				</div><!-- end .title -->
				<a href="<?php echo $routeLine[8]; ?>">View Schedule</a>
				<!-- <div class="search-icon"></div> -->
				<input type="checkbox"  name="route_checkboxes" id="<?php echo $routeLine[1]; ?>" value="<?php echo $routeLine[1]; ?>" checked="checked" style="display: none;"></div>

			<?php
			}

		}

		makeRoutes($routes);


	/* END making the route rows on the left of the page. */
?>
</div>


<div class="fancy-route-row selected" onmouseover="highlight_route_alignment(1045)" onmouseout="unhighlight_route_alignment(1045)" onclick="focus_routes(1045);activate_checkbox(1045);add_route_alignment(1045);">
			<div class="route-icon route-68-small"></div>
			<div class="title"><span class="text">Cloverdale Local</span><a href="http://sctransit.com/maps-schedules/route-68">View Schedule</a></div>
			<div class="search-icon">
			<input type="checkbox" onclick="toggle_route(this);" name="route_checkboxes" id="1045" value="1045" checked="checked" style="display: none;"></div>
</div>






			<div class="fancy-route-row selected" onmouseover="highlight_route_alignment(1045)" onmouseout="unhighlight_route_alignment(1045)" onclick="focus_routes(1045);activate_checkbox(1045);add_route_alignment(1045);">
			<div class="route-icon route-68-small"></div>
			<div class="title"><span class="text">Cloverdale Local</span><a href="http://www.ci.healdsburg.ca.us/?page=195">View Schedule</a></div>
			<div class="search-icon"></div>
</div>





<!--	<div id="landmarks_key" style='display: none;'>
		<form name="landmarks_layers">


		<table border="0">
			<tr>
				<td><input type="checkbox" id="bikeRack" value="0" onclick="toggle_landmark_layer(this.value,this.checked);" /></td>
				<td><img src="icons/SCT_BikeRack.png" width="36" height="36"/>Bike Rack Locations</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="parknRide" value="1" onclick="toggle_landmark_layer(this.value,this.checked);" /></td>
				<td><img src="icons/SCT_Parking.png" width="36" height="36"/>Park and Ride</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="retail" value="2" onclick="toggle_landmark_layer(this.value,this.checked);"/ ></td>
				<td><img src="icons/SCT_PassSales.png" width="36" height="36"/>Pass Sales Outlets</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="transitCenter" value="3" onclick="toggle_landmark_layer(this.value,this.checked);"/ ></td>
				<td><img src="icons/SCT_TransitCenter.png" width="36" height="36"/>Transit Centers</td>
			</tr>
			<tr>
				<td><input type="checkbox" id="transitAndTrails" value="4" onclick="toggle_trails_layer(this.checked);"/ ></td>
				<td><img src="icons/SCT_TransitTrails.png" width="36" height="36"/>Transit to Trails</td>
			</tr>

		</table>

	</form>
	</div>

	-->

	</div>

	<?php

	// require any customized plug-ins
	// require_once ('custom_layers/transit_map_custom_parameters.js');
	require_once ('custom_layers/transit_map_custom.inc.php');
	require_once ('custom_layers/transit_map_custom_config.js');
	// require_once ('outdoor/outdoor-setup.js');

	require_once ('transit_map_core_initialize.js');
	?>
	
	<script type="text/javascript" src="outdoor/outdoor-setup.js"></script>

<script>
	function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function activateRouteByNameString(route_name) {
		$('.route-icon').each( function(i,val) {
			if($(val).attr('class').replace(/[A-Za-z]|-|\s/g, '') == route_name.replace(/[A-Za-z]|-|\s/g, '')) {
				$(val).trigger('click');
				//return false;
			}
		});
	}

	var site_url = getParameterByName('site_url');

	function sizeKey() {
		var mapHeight = $("#map").height();
		var key = $('#key');
		var new_key_height = mapHeight - 270;
		key.height(new_key_height);
	}

	function sizeMap() {
		$('#map').width( $(window).width() - $('#key').width() );
	}

	var setupPrettyStuff = function() {
		$('document').ready( function(){


			$('#select_all_routes').click( function() {
				$('.fancy-route-row:not(.selected)').addClass('selected');
				activate_all_routes();
			});
			$('#deselect_all_routes').click( function() {
				$('.fancy-route-row.selected').removeClass('selected');
				deactivate_all_routes();
			});

			//setup landmark filters
			$('.filter-icon').click( function(e) {
				var el = $(e.target);
				if( !$(e.target).hasClass('filter-icon') ) {
					el = $(e.target).closest('.filter-icon');
				}
				el.toggleClass('selected');

				var bottom_key_elements = $( "#bottom-key" ).children();
				bottom_key_elements.not(el).removeClass('selected');

			})

			/*$('#routes_list table td a').each( function(i,val) {
			var row_placeholder = $('#fancy-row-template').clone().removeAttr('id');
				var route_val = $(val).html().replace(/\s/g, '');
				row_placeholder.attr('onmouseover', $(val).closest('td').attr('onmouseover'));
				row_placeholder.attr('onmouseout', $(val).closest('td').attr('onmouseout'));
				row_placeholder.attr('onclick', $(val).attr('onclick'));
				row_placeholder.find('.route-icon').addClass('route-' + route_val + '-small');
				row_placeholder.find('.text').html($(val).closest('td').next().html());
				row_placeholder.addClass('selected');
				var route_id = $(val).attr('href').replace('#','');


				if(row_placeholder.find('.text').html().length > 50)
					row_placeholder.find('.title').addClass('double');


				site_url = site_url.substr(0,site_url.indexOf('?') != -1 ? site_url.indexOf('?') : site_url.length);
				// set link
				if(route_val.replace(/[A-Za-z]/g, '') != '12' && route_val.replace(/[A-Za-z]/g, '') != '14' && route_val.replace(/[A-Za-z]/g, '') != '44' && route_val.replace(/[A-Za-z]/g, '') != '48')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-' + route_val)

				if(route_val.replace(/[A-Za-z]/g, '') == '12' || route_val.replace(/[A-Za-z]/g, '') == '14')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-12-route-14')

				if(route_val.replace(/[A-Za-z]/g, '') == '44' || route_val.replace(/[A-Za-z]/g, '') == '48')
					row_placeholder.find('a').attr('href', site_url + '/maps-schedules/route-44-route-48')


				$('#routes_list').before(row_placeholder);



			});*/

/*
			$('.fancy-route-row').each( function( i, val ) {
				$(val).addClass('selected');
				var val_a = $(val).find('a');
				$(val_a).parent().parent().find('input').each( function(i,val_input) {
					$(val_input).attr('style','display: block; position:fixed; top: -1000px');
				});
				// replace href attrs
				// $(val_a).attr('href', $(val_a).attr('href').replace('sctransit.com', '74.85.244.50/~sct'));
				val = $(val);
				if(val.find('.text').html().length > 50)
					val.find('.title').addClass('double');

				$(val).attr('onclick','');

			});
*/

/*

			$('.fancy-route-row').click(function(e) {

					var routeID = $(this).attr('rel');
					//alert(routeID);

					focus_routes(routeID);
					load_stop_markers();



				if( e.target.nodeName != "A" && e.target.nodeName != 'INPUT') {
				 if( $(e.target).hasClass('search-icon') ) {
					el = $(e.target);
					if( !$(e.target).hasClass() )
						el = $(e.target).closest('.fancy-route-row');
					if(routes_active.length > 0) {
						var route_id = parseInt(el.find('input').attr('id'));
					 	change_map_bounds(route_id);
					}
				 } else {
					var el = $(e.target);
					if( !$(e.target).hasClass() )
						el = $(e.target).closest('.fancy-route-row');

					var route_id = parseInt(el.find('input').attr('id'));
					if( el.hasClass('selected') ) {
						// we are unselectiung
						el.find('input')[0].checked = false;
					} else {
						change_map_bounds(route_id);
						el.find('input')[0].checked = true;
					}
				 	el.toggleClass('selected');
					toggle_route( el.find('input')[0] );
				 }

				 } else if (e.target.nodeName != 'INPUT') {
				 	if(window.parent != null)
				 		window.parent.location = $(e.target).attr('href');
				 	e.stopPropagation();
				 }

			});
			*/

			$('#fancy-row-template').remove();

			//let's load the map with preselected routes
			//this needs to be changed to automatically affect which routes are highlighted
			var routes_preload_raw = getParameterByName('preselected');
			if(routes_preload_raw != '') {
			  if( routes_preload_raw.split(',').length > 1  ) {
			  	for(var i=0; i<routes_preload_raw.split(',').length; ++i) {
			  		focus_routes(routes_preload_raw.split(',')[i]);
			  	}
			  } else {
					focus_routes(routes_preload_raw);
			  }
			}



		});
	};


	setupPrettyStuff();

$(document).ready(function () {
	sizeMap();
	sizeKey();
    $(window).resize(function() {
		sizeMap();
		sizeKey();
    });
});

toggle_landmark_layer(4);

</script>

</body>
</html>
