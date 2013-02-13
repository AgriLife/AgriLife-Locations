<!DOCTYPE html>
<?php get_header();?>
<html> 
<head> 
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<title>AgriLife Locations</title> 
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo get_template_directory_uri() . '/css/style.css'; ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/map.js?v=2'; ?>"></script>


</head> 
<body> 
	<div id="map_canvas"></div> 
	<section class="legend">
	<div class="legend-button">Options</div>
	<div class="legend-inner">
		<div class="wrap">
<p class="heading">Texas A&amp;M Agrilife Locations</p>
			<div class="agency extension-legend">
				<p class="office legend-list" id="extension-legend" value="Texas AgriLife Extension Service County Offices"><span>Extension County Offices</span></p>
			  <select class="search" id="ext-locations">
			    <option value="">Select a County Office</option>
			  </select>				
			</div>
			
			<div class="agency research-legend">
				<p class="office legend-list" id="research-legend" value="Research &amp; Extension Centers"><span>Research Centers</span></p>
<p>
				<select  class="search" id="res-locations">
          <option value="Centers Listing">Select a Research Center</option>
        </select>
</p>
			</div>
			
			<div class="agency tvmdl-legend"><p class="office" id="tvmdl-legend" value="Texas Veterinary Medical Diagnostic Laboratory"><span>TVMDL</span></p>
			</div>	
			
			<div class="agency tfs-legend"><p class="office" id="tfs-legend" value="Texas Forest Service Offices"><span>Texas Forest Service</span></p>
				
			</div>	
			
			<div class="agency hq-legend">Texas A&amp;M AgriLife Headquarters</div>
      <div class="show-all"><p class="office" id="reset" value="Show All"><span>Show All</span></p></div>

		</div>
	</div>	
	</section>
	
<script>
</script>	
<?php get_footer(); ?>
</body> 
</html>
