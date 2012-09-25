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

  // Set map zoom based on viewport width
  myOptions.zoom = getZoom(height, width);
  // Setup the map
  initialize();
  // Check for deep-link to single agency
  layerUrl();

});

function initialize() {
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

    // Set up layers for separate agencies
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

    // Insert AgriLife Headquarters into the map
    aghq = new google.maps.LatLng(30.5997762, -96.3522229);
    var marker = [];
    marker = new google.maps.Marker({
        map: map,
        position: aghq,
        icon: new google.maps.MarkerImage("http://agrilife.org/template-agriflex/wp-content/themes/AgriLife-Locations/images/agrilife-marker.png")
    });
}

// Determine the map zoom level based on viewport width
// @TODO - Use height as well
function getZoom(height, width) {
  if( width <= 300 ) {
    return 4;
  } else if( width > 300 && width <= 600) {
    return 5;
  } else if( width > 600 ){
    return 6;
  }
}

var infoWindow = new google.maps.InfoWindow();

// Resets the map to show all entities
function showAll() {
  initialize();
  layer_ext.setMap(map);
  layer_res.setMap(map);
  layer_tfs.setMap(map);
  layer_tvmdl.setMap(map);
}

// Check the url for arguments. Show only requested entity.
// Format: ?layer=[ext,res,tfs,tvmdl]
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

// Parse the URL arguments
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

// Toggles the selected layer
function toggleLayer(layer) {
    if (layer.getMap()) {
        layer.setMap(null);
    } else {
        layer.setMap(map);
        console.log(layer);
    }
}

// Listen for click events and pass to toggleLayer
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

// Fusion Tables query setup
var apikey = "AIzaSyAwvTAlWZ9tj8b4-1QWHwFl3ILodM7u0jA";
var tableid = 2891754;
var encryptedid = "19aSULi0NxobDXvjbc6ygoNoYhYLrFLhACu7Dyuw";
var targeturl = "https://www.googleapis.com/fusiontables/v1/query?sql=";
query = "SELECT 'Unit Name', Type FROM " + encryptedid + " ORDER BY 'Unit Name'";
var keystring = "&key=" + apikey;

// Retrieve list of locations from the Fusion Table
$(document).ready( function() {
  $.getJSON(targeturl + query + keystring,
    function(data) {
      getLocations(data);
  });
});

// Parse the results into the dropdowns
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

// Show the selected Extension office
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

// Show the selected Research Office
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

// Listen for location selection and show-all
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

// Options panel behavior
$(document).ready(function(){	
  // Hide on load
  $('.legend-inner').hide();

  // Toggle for legend and search menu
  $('.legend-button').click(function() {
    $('.legend-inner').slideToggle('medium', function() {});			
  });

  // Hide when single location selected
  $('.search').change( function() {
    $('.legend-inner').slideToggle('medium', function() {});
  });

  // Hide when 'Show All' is clicked
  $('.show-all').click( function() {
    $('.legend-inner').slideToggle('medium', function() {});
  });

  // Hide when user clicks outside of options panel
  $('#map_canvas').click( function() {
    $('.legend-inner').slideUp('medium', function() {});
  });
});	
