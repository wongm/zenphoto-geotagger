<!DOCTYPE html>
<html>
  <head>
    <title>Zenphoto Geotagger</title>
	<?php printZenJavascripts() ?>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="geotagger.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="geotagger.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  </head>
  <body>
	<?php adminToolbox() ?>
	<div id="wrapper">
		<form id="searchForm" class="sidebar">
			<div id="searchPanel">
				<h1>Zenphoto Geotagger</h1>
				<div id="actionMessage"></div>
				<label for="includes">Includes</label><input type="text" id="includes" />
				<label for="excludes">Excludes</label><input type="text" id="excludes" />
				<label for="dateFrom">From</label><input type="text" id="dateFrom" class="datepicker" placeholder="2015-01-01" />
				<label for="dateTo">To</label><input type="text" id="dateTo" class="datepicker" placeholder="2015-12-12" />
				<label for="includeGeocoded">Inc. geocoded</label><input type="checkbox" id="includeGeocoded" />
				<div id="locationPanel">
					<label for="lat">Latitude</label><input readonly type="text" id="lat" />
					<label for="lng">Longitude</label><input readonly type="text" id="lng" />
				</div>
			</div>
			<div class="actionPanel">
				<input type="button" id="search" value="Search for images" />
			</div>
		</form>
		<div id="searchResults" class="sidebar" style="display:none"></div>
		<input id="placeSearch" class="controls" type="text" placeholder="Search for location">
		<div id="map"></div>
	</div>
	<script src="//maps.googleapis.com/maps/api/js?callback=initMap&libraries=places" async defer></script>
  </body>
</html>