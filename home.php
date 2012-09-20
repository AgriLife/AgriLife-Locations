<!DOCTYPE html>
<html> 
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>AgriLife Locations</title> 
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
<link href="http://agrilife.org/wp-content/themes/AgriLife-Locations/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> 

<script type="text/javascript"> 
var map,
  tableid = 2891754,
  myOptions = {
    center: new google.maps.LatLng(31.7093197, -99.9911611),
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };
var layer_ext;

$(document).ready( function() {

  var height = $(window).height();
  var width = $(window).width();

  myOptions.zoom = getZoom(height, width);
  initialize();
  layerUrl();




});

function initialize() {
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

    layer_ext = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: 'Type = 1'
        }
    });

    layer_res = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: 'Type = 2'
        }
    });

    layer_tvmdl = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: 'Type = 3'
        }
    });

    layer_tfs = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: 'Type = 4'
        }
    });
    geocoder = new google.maps.Geocoder();
    aghq = new google.maps.LatLng(30.5997762, -96.3522229);
    var marker = [];
    marker = new google.maps.Marker({
        map: map,
        position: aghq,
        icon: new google.maps.MarkerImage("http://agrilife.org/template-agriflex/wp-content/themes/AgriLife-Locations/images/agrilife-marker.png")
    });
}

function getZoom(height, width) {
  if( width <= 300 ) {
    return 4;
  } else if( width > 300 && width <= 600) {
    return 5;
  } else if( width > 600 ){
    return 6;
  }
}

function layerUrl() {
  httparg = getUrlVars()["layer"];

  if(httparg == null) {
    showAll();
  } else {
    $(function() {
    layer = window['layer_' + httparg];
    toggleLayer(layer);
    });
  }
}

var infoWindow = new google.maps.InfoWindow();

function toggleLayer(layer) {
    if (layer.getMap()) {
        layer.setMap(null);
    } else {
        layer.setMap(map);
        console.log(layer);
    }
}

function showAll() {
  initialize();
  layer_ext.setMap(map);
  layer_res.setMap(map);
  layer_tfs.setMap(map);
  layer_tvmdl.setMap(map);
}

function getUrlVars() {
  var vars = [], hash;
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++ ) {
    hash = hashes[i].split('=');
    vars.push(hash[0]);
    vars[hash[0]] = hash[1];
  }
  return vars;
}

// Toggle layer visibility when user clicks on branch
$(function() {
  $('#extension-legend').click(function() {
      toggleLayer(layer_ext);
  });

  $('#research-legend').click(function() {
      toggleLayer(layer_res);
  });

  $('#tfs-legend').click(function() {
      toggleLayer(layer_tfs);
  });

  $('#tvmdl-legend').click(function() {
      toggleLayer(layer_tvmdl);
  });
});

function changeMapExt() {
	var searchString = document.getElementById('search-string-ext').value.replace(/'/g, "\\'");
	if(!searchString) {
	  layer.setQuery("SELECT 'Location' FROM " + tableid + "'Type' = 1");
	  return;
	}
	var extOffice = "SELECT 'Location' FROM " + tableid + " WHERE 'Unit Name' = '" + searchString + "'";
	layer_ext.setQuery(extOffice);
	codeAddress(extOffice);
}	

function changeMapResearch() {
	var searchString = document.getElementById('search-string-research').value.replace(/'/g, "\\'");
	if(!searchString) {
	  layer.setQuery("SELECT 'Location' FROM " + tableid + "'Type' = 2");
	  return;
	}
	var researchOffice = "SELECT 'Location' FROM " + tableid + " WHERE 'Unit Name' = '" + searchString + "'";
	layer.setQuery(researchOffice);
	codeAddress(researchOffice);
}
function codeAddress(place) {
	geocoder.geocode( { 'address': place}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		map.setCenter(results[0].geometry.location);
		}
		
		});
}


var apikey = "AIzaSyAwvTAlWZ9tj8b4-1QWHwFl3ILodM7u0jA";
var tableid = 2891754;
var encryptedid = "19aSULi0NxobDXvjbc6ygoNoYhYLrFLhACu7Dyuw";
var targeturl = "https://www.googleapis.com/fusiontables/v1/query?sql=";
query = "SELECT 'Unit Name', Type FROM " + encryptedid + " ORDER BY 'Unit Name'";
var keystring = "&key=" + apikey;

function getLocations(data) {
    extlocations = $.grep( data.rows, function(n, i) {
        return n[1] == 1;
    });
    reslocations = $.grep( data.rows, function(n, i) {
        return n[1] == 2;
    });
    
    $.each( extlocations, function( n, i) {
        $("#ext-locations").append( "<option>" + i[0] + "</option>");
    });
    
    $.each( reslocations, function( n, i) {
        $("#res-locations").append( "<option>" + i[0] + "</option>");
    });
}


$(document).ready( function() {
    $.getJSON(targeturl + query + keystring,
              function(data) {
                  getLocations(data);
              });
});

function changeMapExt() {
    
    var searchstring = $('#ext-locations').val().trim();
    layer_ext.setMap(null);
    layer_res.setMap(null);
    layer_tfs.setMap(null);
    layer_tvmdl.setMap(null);
    
    layer_ext = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: "'Unit Name' = '" + searchstring + "'"
        }
    });

    layer_ext.setMap(map);
    
    
}

function changeMapRes() {
    
    var searchstring = $('#res-locations').val().trim();
    layer_ext.setMap(null);
    layer_res.setMap(null);
    layer_tfs.setMap(null);
    layer_tvmdl.setMap(null);
    
    layer_res = new google.maps.FusionTablesLayer({
        query: {
            select: 'Location',
            from: tableid,
            where: "'Unit Name' = '" + searchstring + "'"
        }
    });

    layer_res.setMap(map);
    
    
}

$(function() {
  $('#ext-locations').change( function() {
      changeMapExt();
  });

  $('#res-locations').change( function() {
      changeMapRes();
  });

  $('#reset').click( function() {
      showAll();
  });
});
					
</script> 
</head> 
<body> 
	<div id="map_canvas"></div> 
	<section class="legend">
	<div class="legend-button">Legend &amp; Search</div>
	<div class="legend-inner">
		<div class="wrap">
		<ul id="legend-list">			
			<li class="extension-legend">
				<label class="office legend-list" id="extension-legend" value="Texas AgriLife Extension Service County Offices"><span>Texas AgriLife Extension Service County Offices</span></label>
			  <select class="search" id="ext-locations">
			    <option value="">County Offices Listing</option>
			  </select>				
			</li>
			
			<li class="research-legend">
				<label class="office legend-list" id="research-legend" value="Research &amp; Extension Centers"><span>Texas AgriLife Research &amp; Extension Centers</span></label>
				<select  class="search" id="res-locations">
          <option value="Centers Listing">Centers Listing</option>
        </select>
			</li>
			
			<li class="tvmdl-legend"><label class="office" id="tvmdl-legend" value="Texas Veterinary Medical Diagnostic Laboratory"><span>TVMDL Locations</span></label>
				
				
			</li>	
			
			<li class="tfs-legend"><label class="office" id="tfs-legend" value="Texas Forest Service Offices"><span>Texas Forest Service Offices</span></label>
				
			</li>	
			
			<li class="hq-legend">Texas A&amp;M AgriLife Headquarters</li>											
      <li class="show-all"><label class="office" id="reset" value="Show All"><span>Show All</span></label></li>
		</ul>

		</div>
	</div>	
	</section>
	
<script>
 $(document).ready(function(){	
	$('.legend-inner').hide();
		// Toggle for legend and search menu
	$('.legend-button').click(function() {
		$('.legend-inner').slideToggle('medium', function() {});			
	});
 });	
</script>	
</body> 
</html>
