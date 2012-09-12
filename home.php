<!DOCTYPE html>
<html> 
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>AgriLife Locations</title> 
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
<link href="http://agrilife.org/wp-content/themes/AgriLife-Locations/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> 

<script type="text/javascript"> 
var map,
	layer,
	tableid = 2891754;

function initialize() {
	geocoder = new google.maps.Geocoder();
	map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: new google.maps.LatLng(31.7093197, -98.9911611),
    zoom: 6,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

	//create the AgriLife HQ marker
 	aghq = new google.maps.LatLng(30.5997762, -96.3522229);
	var marker = new google.maps.Marker({
	    map: map, 
	    position: aghq,
	    //this is where the magic happens!
	    icon: new google.maps.MarkerImage("http://agrilife.org/template-agriflex/wp-content/themes/AgriLife-Locations/images/agrilife-marker.png")
	});

  layer = new google.maps.FusionTablesLayer(tableid);
  layer.setQuery("SELECT 'Location' FROM " + tableid);
  layer.setMap(map);
}
	var infoWindow = new google.maps.InfoWindow();

function changeMapExt() {
	var searchString = document.getElementById('search-string-ext').value.replace(/'/g, "\\'");
	if(!searchString) {
	  layer.setQuery("SELECT 'Location' FROM " + tableid + "'Type' = 1");
	  return;
	}
	var extOffice = "SELECT 'Location' FROM " + tableid + " WHERE 'Unit Name' = '" + searchString + "'";
	layer.setQuery(extOffice);
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

					
</script> 
</head> 
<body onload="initialize()"> 
	<div id="map_canvas"></div> 
	<section class="legend">
	<div class="legend-button">Legend &amp; Search</div>
	<div class="legend-inner">
		<div class="wrap">
		<ul id="legend-list">			
			<li class="extension-legend">
				<label class="office legend-list" id="extension-legend" value="Texas AgriLife Extension Service County Offices"><span>Texas AgriLife Extension Service County Offices</span></label>
			  <select class="search" id="search-string-ext" onchange="changeMapExt(this.value);">
			    <option value="">County Offices Listing</option>
			    <option value="Anderson County Office">Anderson County Office</option>
			    <option value="Andrews County Office">Andrews County Office</option>
			    <option value="Angelina County Office">Angelina County Office</option>
			    <option value="Aransas County Office">Aransas County Office</option>
			    <option value="Archer County Office">Archer County Office</option>
			    <option value="Armstrong County Office">Armstrong County Office</option>
			    <option value="Atascosa County Office">Atascosa County Office</option>
			    <option value="Austin County Office">Austin County Office</option>
			    <option value="Bailey County Office">Bailey County Office</option>
			    <option value="Bandera County Office">Bandera County Office</option>
			    <option value="Bastrop County Office">Bastrop County Office</option>
			    <option value="Baylor County Office">Baylor County Office</option>
			    <option value="Bee County Office">Bee County Office</option>
			    <option value="Bell County Office">Bell County Office</option>
			    <option value="Bexar County Office">Bexar County Office</option>
			    <option value="Blanco County Office">Blanco County Office</option>
			    <option value="Borden County Office">Borden County Office</option>
			    <option value="Bosque County Office">Bosque County Office</option>
			    <option value="Bowie County Office">Bowie County Office</option>
			    <option value="Brazoria County Office">Brazoria County Office</option>
			    <option value="Brazos County Office">Brazos County Office</option>
			    <option value="Brewster-Jeff Davis County Office">Brewster-Jeff Davis County Office</option>
			    <option value="Briscoe County Office">Briscoe County Office</option>
			    <option value="Brooks County Office">Brooks County Office</option>
			    <option value="Brown County Office">Brown County Office</option>
			    <option value="Burleson County Office">Burleson County Office</option>
			    <option value="Burnet County Office">Burnet County Office</option>
			    <option value="Caldwell County Office">Caldwell County Office</option>
			    <option value="Calhoun County Office">Calhoun County Office</option>
			    <option value="Callahan County Office">Callahan County Office</option>
			    <option value="Cameron County Office">Cameron County Office</option>
			    <option value="Camp County Office">Camp County Office</option>
			    <option value="Carson County Office">Carson County Office</option>
			    <option value="Cass County Office">Cass County Office</option>
			    <option value="Castro County Office">Castro County Office</option>
			    <option value="Center TVMDL Poultry Diagnostic Laboratory">Center TVMDL Poultry Diagnostic Laboratory</option>
			    <option value="Chambers County Office">Chambers County Office</option>
			    <option value="Cherokee County Office">Cherokee County Office</option>
			    <option value="Childress County Office">Childress County Office</option>
			    <option value="Clay County Office">Clay County Office</option>
			    <option value="Cochran County Office">Cochran County Office</option>
			    <option value="Coke County Office">Coke County Office</option>
			    <option value="Coleman County Office">Coleman County Office</option>
			    <option value="Collin County Office">Collin County Office</option>
			    <option value="Collingsworth County Office">Collingsworth County Office</option>
			    <option value="Colorado County Office">Colorado County Office</option>
			    <option value="Comal County Office">Comal County Office</option>
			    <option value="Comanche County Office">Comanche County Office</option>
			    <option value="Concho County Office">Concho County Office</option>
			    <option value="Cooke County Office">Cooke County Office</option>
			    <option value="Coryell County Office">Coryell County Office</option>
			    <option value="Cottle County Office">Cottle County Office</option>
			    <option value="Crane County Office">Crane County Office</option>
			    <option value="Crockett County Office">Crockett County Office</option>
			    <option value="Crosby County Office">Crosby County Office</option>
			    <option value="Culberson County Office">Culberson County Office</option>
			    <option value="Dallam-Hartley County Office">Dallam-Hartley County Office</option>
			    <option value="Dallas County Office">Dallas County Office</option>
			    <option value="Dawson County Office">Dawson County Office</option>
			    <option value="DeWitt County Office">DeWitt County Office</option>
			    <option value="Deaf Smith County Office">Deaf Smith County Office</option>
			    <option value="Denton County Office">Denton County Office</option>
			    <option value="Dickens County Office">Dickens County Office</option>
			    <option value="Dimmit County Office">Dimmit County Office</option>
			    <option value="Donley County Office">Donley County Office</option>
			    <option value="Duval County Office">Duval County Office</option>
			    <option value="Eastland County Office">Eastland County Office</option>
			    <option value="Ector County Office">Ector County Office</option>
			    <option value="Edwards County Office">Edwards County Office</option>
			    <option value="El Paso County Office">El Paso County Office</option>
			    <option value="Ellis County Office">Ellis County Office</option>
			    <option value="Erath County Office">Erath County Office</option>
			    <option value="Falls County Office">Falls County Office</option>
			    <option value="Fannin County Office">Fannin County Office</option>
			    <option value="Fayette County Office">Fayette County Office</option>
			    <option value="Fisher County Office">Fisher County Office</option>
			    <option value="Floyd County Office">Floyd County Office</option>
			    <option value="Foard County Office">Foard County Office</option>
			    <option value="Fort Bend County Office">Fort Bend County Office</option>
			    <option value="Franklin-Delta County Office">Franklin-Delta County Office</option>
			    <option value="Freestone County Office">Freestone County Office</option>
			    <option value="Frio County Office">Frio County Office</option>
			    <option value="Gaines County Office">Gaines County Office</option>
			    <option value="Galveston County Office">Galveston County Office</option>
			    <option value="Garza County Office">Garza County Office</option>
			    <option value="Gillespie County Office">Gillespie County Office</option>
			    <option value="Glasscock County Office">Glasscock County Office</option>
			    <option value="Goliad County Office">Goliad County Office</option>
			    <option value="Gonzales County Office">Gonzales County Office</option>
			    <option value="Gray County Office">Gray County Office</option>
			    <option value="Grayson County Office">Grayson County Office</option>
			    <option value="Gregg County Office">Gregg County Office</option>
			    <option value="Grimes County Office">Grimes County Office</option>
			    <option value="Guadalupe County Office">Guadalupe County Office</option>
			    <option value="Hale County Office">Hale County Office</option>
			    <option value="Hall County Office">Hall County Office</option>
			    <option value="Hamilton County Office">Hamilton County Office</option>
			    <option value="Hansford County Office">Hansford County Office</option>
			    <option value="Hardeman County Office">Hardeman County Office</option>
			    <option value="Hardin County Office">Hardin County Office</option>
			    <option value="Harris County Office">Harris County Office</option>
			    <option value="Harrison County Office">Harrison County Office</option>
			    <option value="Haskell County Office">Haskell County Office</option>
			    <option value="Hays County Office">Hays County Office</option>
			    <option value="Hemphill County Office">Hemphill County Office</option>
			    <option value="Henderson County Office">Henderson County Office</option>
			    <option value="Hidalgo County Office">Hidalgo County Office</option>
			    <option value="Hill County Office">Hill County Office</option>
			    <option value="Hockley County Office">Hockley County Office</option>
			    <option value="Hood County Office">Hood County Office</option>
			    <option value="Hopkins County Office">Hopkins County Office</option>
			    <option value="Houston County Office">Houston County Office</option>
			    <option value="Howard County Office">Howard County Office</option>
			    <option value="Hudspeth County Office">Hudspeth County Office</option>
			    <option value="Hunt County Office">Hunt County Office</option>
			    <option value="Hutchinson County Office">Hutchinson County Office</option>
			    <option value="Irion County Office">Irion County Office</option>
			    <option value="Jack County Office">Jack County Office</option>
			    <option value="Jackson County Office">Jackson County Office</option>
			    <option value="Jasper County Office">Jasper County Office</option>
			    <option value="Jefferson County Office">Jefferson County Office</option>
			    <option value="Jim Hogg County Office">Jim Hogg County Office</option>
			    <option value="Jim Wells County Office">Jim Wells County Office</option>
			    <option value="Johnson County Office">Johnson County Office</option>
			    <option value="Jones County Office">Jones County Office</option>
			    <option value="Karnes County Office">Karnes County Office</option>
			    <option value="Kaufman County Office">Kaufman County Office</option>
			    <option value="Kendall County Office">Kendall County Office</option>
			    <option value="Kent County Office">Kent County Office</option>
			    <option value="Kerr County Office">Kerr County Office</option>
			    <option value="Kimble County Office">Kimble County Office</option>
			    <option value="King County Office">King County Office</option>
			    <option value="Kinney County Office">Kinney County Office</option>
			    <option value="Kleberg-Kenedy County Office">Kleberg-Kenedy County Office</option>
			    <option value="Knox County Office">Knox County Office</option>
			    <option value="La Salle County Office">La Salle County Office</option>
			    <option value="Lamar County Office">Lamar County Office</option>
			    <option value="Lamb County Office">Lamb County Office</option>
			    <option value="Lampasas County Office">Lampasas County Office</option>
			    <option value="Lavaca County Office">Lavaca County Office</option>
			    <option value="Lee County Office">Lee County Office</option>
			    <option value="Leon County Office">Leon County Office</option>
			    <option value="Liberty County Office">Liberty County Office</option>
			    <option value="Limestone County Office">Limestone County Office</option>
			    <option value="Lipscomb County Office">Lipscomb County Office</option>
			    <option value="Live Oak County Office">Live Oak County Office</option>
			    <option value="Llano County Office">Llano County Office</option>
			    <option value="Lubbock County Office">Lubbock County Office</option>
			    <option value="Lynn County Office">Lynn County Office</option>
			    <option value="Madison County Office">Madison County Office</option>
			    <option value="Marion County Office">Marion County Office</option>
			    <option value="Martin County Office">Martin County Office</option>
			    <option value="Mason County Office">Mason County Office</option>
			    <option value="Matagorda County Office">Matagorda County Office</option>
			    <option value="Maverick County Office">Maverick County Office</option>
			    <option value="McCulloch County Office">McCulloch County Office</option>
			    <option value="McLennan County Office">McLennan County Office</option>
			    <option value="McMullen County Office">McMullen County Office</option>
			    <option value="Medina County Office">Medina County Office</option>
			    <option value="Menard County Office">Menard County Office</option>
			    <option value="Midland County Office">Midland County Office</option>
			    <option value="Milam County Office">Milam County Office</option>
			    <option value="Mills County Office">Mills County Office</option>
			    <option value="Mitchell County Office">Mitchell County Office</option>
			    <option value="Montague County Office">Montague County Office</option>
			    <option value="Montgomery County Office">Montgomery County Office</option>
			    <option value="Moore County Office">Moore County Office</option>
			    <option value="Morris County Office">Morris County Office</option>
			    <option value="Motley County Office">Motley County Office</option>
			    <option value="Nacogdoches County Office">Nacogdoches County Office</option>
			    <option value="Navarro County Office">Navarro County Office</option>
			    <option value="Newton County Office">Newton County Office</option>
			    <option value="Nolan County Office">Nolan County Office</option>
			    <option value="Nueces County Office">Nueces County Office</option>
			    <option value="Ochiltree County Office">Ochiltree County Office</option>
			    <option value="Oldham County Office">Oldham County Office</option>
			    <option value="Orange County Office">Orange County Office</option>
			    <option value="Palo Pinto County Office">Palo Pinto County Office</option>
			    <option value="Panola County Office">Panola County Office</option>
			    <option value="Parker County Office">Parker County Office</option>
			    <option value="Parmer County Office">Parmer County Office</option>
			    <option value="Pecos County Office">Pecos County Office</option>
			    <option value="Polk County Office">Polk County Office</option>
			    <option value="Potter County Office">Potter County Office</option>
			    <option value="Presidio County Office">Presidio County Office</option>
			    <option value="Rains County Office">Rains County Office</option>
			    <option value="Randall County Office">Randall County Office</option>
			    <option value="Reagan County Office">Reagan County Office</option>
			    <option value="Real County Office">Real County Office</option>
			    <option value="Red River County Office">Red River County Office</option>
			    <option value="Reeves County Office">Reeves County Office</option>
			    <option value="Refugio County Office">Refugio County Office</option>
			    <option value="Roberts County Office">Roberts County Office</option>
			    <option value="Robertson County Office">Robertson County Office</option>
			    <option value="Rockwall County Office">Rockwall County Office</option>
			    <option value="Runnels County Office">Runnels County Office</option>
			    <option value="Rusk County Office">Rusk County Office</option>
			    <option value="Sabine County Office">Sabine County Office</option>
			    <option value="San Augustine County Office">San Augustine County Office</option>
			    <option value="San Jacinto County Office">San Jacinto County Office</option>
			    <option value="San Patricio County Office">San Patricio County Office</option>
			    <option value="San Saba County Office">San Saba County Office</option>
			    <option value="Schleicher County Office">Schleicher County Office</option>
			    <option value="Scurry County Office">Scurry County Office</option>
			    <option value="Shackelford County Office">Shackelford County Office</option>
			    <option value="Shelby County Office">Shelby County Office</option>
			    <option value="Sherman County Office">Sherman County Office</option>
			    <option value="Smith County Office">Smith County Office</option>
			    <option value="Somervell County Office">Somervell County Office</option>
			    <option value="Starr County Office">Starr County Office</option>
			    <option value="Stephens County Office">Stephens County Office</option>
			    <option value="Sterling County Office">Sterling County Office</option>
			    <option value="Stonewall County Office">Stonewall County Office</option>
			    <option value="Sutton County Office">Sutton County Office</option>
			    <option value="Swisher County Office">Swisher County Office</option>
			    <option value="TFS Alpine">TFS Alpine</option>
			    <option value="TFS Austin Regional Office">TFS Austin Regional Office</option>
			    <option value="TFS Wichita Falls (Archer City)">TFS Wichita Falls (Archer City)</option>
			    <option value="TVMDL Amarillo Laboratory">TVMDL Amarillo Laboratory</option>
			    <option value="TVMDL College Station Laboratory">TVMDL College Station Laboratory</option>
			    <option value="TVMDL Gonzales Poultry Laboratory">TVMDL Gonzales Poultry Laboratory</option>
			    <option value="Tarrant County Office">Tarrant County Office</option>
			    <option value="Taylor County Office">Taylor County Office</option>
			    <option value="Terrell County Office">Terrell County Office</option>
			    <option value="Terry County Office">Terry County Office</option>
			    <option value="Throckmorton County Office">Throckmorton County Office</option>
			    <option value="Titus County Office">Titus County Office</option>
			    <option value="Tom Green County Office">Tom Green County Office</option>
			    <option value="Travis County Office">Travis County Office</option>
			    <option value="Trinity County Office">Trinity County Office</option>
			    <option value="Tyler County Office">Tyler County Office</option>
			    <option value="Upshur County Office">Upshur County Office</option>
			    <option value="Upton County Office">Upton County Office</option>
			    <option value="Uvalde County Office">Uvalde County Office</option>
			    <option value="Val Verde County Office">Val Verde County Office</option>
			    <option value="Van Zandt County Office">Van Zandt County Office</option>
			    <option value="Victoria County Office">Victoria County Office</option>
			    <option value="Waller County Office">Waller County Office</option>
			    <option value="Ward County Office">Ward County Office</option>
			    <option value="Washington County Office">Washington County Office</option>
			    <option value="Webb County Office">Webb County Office</option>
			    <option value="Wharton County Office">Wharton County Office</option>
			    <option value="Wheeler County Office">Wheeler County Office</option>
			    <option value="Wichita County Office">Wichita County Office</option>
			    <option value="Wilbarger County Office">Wilbarger County Office</option>
			    <option value="Willacy County Office">Willacy County Office</option>
			    <option value="Williamson County Office">Williamson County Office</option>
			    <option value="Wilson County Office">Wilson County Office</option>
			    <option value="Winkler-Loving County Office">Winkler-Loving County Office</option>
			    <option value="Wise County Office">Wise County Office</option>
			    <option value="Wood County Office">Wood County Office</option>
			    <option value="Yoakum County Office">Yoakum County Office</option>
			    <option value="Young County Office">Young County Office</option>
			    <option value="Zapata County Office">Zapata County Office</option>
			    <option value="Zavala County Office">Zavala County Office</option>
			  </select>				
			</li>
			
			<li class="research-legend">
				<label class="office legend-list" id="research-legend" value="Research &amp; Extension Centers"><span>Texas AgriLife Research &amp; Extension Centers</span></label>
				<select  class="search" id="search-string-research" onchange="changeMapResearch(this.value);">
    <option value="Centers Listing">Centers Listing</option>
				    <option value="Texas A&amp;M AgriLife Research &amp; Extension Center at Overton">Texas A&amp;M AgriLife Research &amp; Extension Center at Overton</option>
    <option value="Texas A&amp;M AgriLife Research Center at Beaumont">Texas A&amp;M AgriLife Research Center at Beaumont</option>
    <option value="Texas A&amp;M AgriLife Research at Weslaco">Texas A&amp;M AgriLife Research at Weslaco</option>
    <option value="Texas AgriLife Blackland Research and Extension Center">Texas AgriLife Blackland Research and Extension Center</option>
    <option value="Texas AgriLife Extension Center at Fort Stockton">Texas AgriLife Extension Center at Fort Stockton</option>
    <option value="Texas AgriLife Research &amp; Extension Center">Texas AgriLife Research &amp; Extension Center</option>
    <option value="Texas AgriLife Research &amp; Extension Center at Corpus Christi">Texas AgriLife Research &amp; Extension Center at Corpus Christi</option>
    <option value="Texas AgriLife Research &amp; Extension Center at Lubbock">Texas AgriLife Research &amp; Extension Center at Lubbock</option>
    <option value="Texas AgriLife Research and Extension Center">Texas AgriLife Research and Extension Center</option>
    <option value="Texas AgriLife Research and Extension Center at Amarillo">Texas AgriLife Research and Extension Center at Amarillo</option>
    <option value="Texas AgriLife Research and Extension Center at Dallas">Texas AgriLife Research and Extension Center at Dallas</option>
    <option value="Texas AgriLife Research and Extension Center at El Paso">Texas AgriLife Research and Extension Center at El Paso</option>
    <option value="Texas AgriLife Research and Extension Center at Stephenville">Texas AgriLife Research and Extension Center at Stephenville</option>
    <option value="Texas AgriLife Research and Extension Center at Vernon">Texas AgriLife Research and Extension Center at Vernon</option>
			</select>
			</li>
			
			<li class="tvmdl-legend"><label class="office" id="tvmdl-legend" value="Texas Veterinary Medical Diagnostic Laboratory"><span>TVMDL Locations</span></label>
				
				
			</li>	
			
			<li class="tfs-legend"><label class="office" id="tfs-legend" value="Texas Forest Service Offices"><span>Texas Forest Service Offices</span></label>
				
			</li>	
			
			<li class="hq-legend">Texas A&amp;M AgriLife Headquarters</li>											
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
