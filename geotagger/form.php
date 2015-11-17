<!DOCTYPE html>
<html>
  <head>
    <title>Zenphoto Geotagger</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="geotagger.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="geotagger.css" />
  </head>
  <body>
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
		<div id="map"></div>
	</div>
	<script src="//maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
  </body>
</html>