<?php
if (isset($_GET["action"]))
{
	drawResults();
}
else if (isset($_POST["images"]))
{
	processRequest();
}
else
{
?>
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
		<div id="searchForm" class="sidebar">
			<div id="searchPanel">
				<h1>Zenphoto Geotagger</h1>
				<div id="actionMessage"></div>
				<label for="includes">Includes</label><input type="text" id="includes" />
				<label for="excludes">Excludes</label><input type="text" id="excludes" />
				<label for="dateFrom">From</label><input type="text" id="dateFrom" class="datepicker" />
				<label for="dateTo">To</label><input type="text" id="dateTo" class="datepicker" />
				<label for="includeGeocoded">Inc. geocoded</label><input type="checkbox" id="includeGeocoded" />
				<div id="locationPanel">
					<label for="lat">Latitude</label><input readonly type="text" id="lat" />
					<label for="lng">Longitude</label><input readonly type="text" id="lng" />
				</div>
			</div>
			<div class="actionPanel">
				<input type="button" id="search" value="Search for images" />
			</div>
		</div>
		<div id="searchResults" class="sidebar" style="display:none"></div>
		<div id="map"></div>
	</div>
	<script src="//maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
  </body>
</html>
<?php
}

function drawResults()
{
?>
	<form id="imageForm">
	<div class="imageOptionPanel">
		<label for="allImagesTop">All<input type="checkbox" id="allImagesTop" class="imageCheckbox" /></label>
	</div>
<?php
	$includes = $_GET["includes"];
	$excludes = $_GET["excludes"];
	$dateFrom = $_GET["dateFrom"];
	$dateTo = $_GET["dateTo"];
	$includeGeocoded = $_GET["includeGeocoded"];
	
	//echo "includeGeocoded = $includeGeocoded<BR>";
	//echo "includes = $includes<BR>";
	//echo "excludes = $excludes<BR>";
	//echo "dateFrom = $dateFrom<BR>";
	//echo "dateTo = $dateTo<BR>";
	
	for ($imageId = 4564; $imageId <= 4600; $imageId++)
	{
		$caption = "Caption for image $imageId is here";
		$description = "Description for image $imageId is here";
?>
	<div class="imageOptionPanel">
		<input type="checkbox" id="image<?php echo $imageId ?>" value="<?php echo $imageId ?>" class="imageCheckbox imageOption">
		<label for="image<?php echo $imageId ?>">
			<img src="http://railgallery.wongm.com/cache/connex/D139_3947_250_thumb.jpg" alt="<?php= $caption ?>" />
			<?php echo $caption ?> / <?php echo $description ?>
		</label>
	</div>
<?php
	}
?>
	<div class="imageOptionPanel">
		<label for="allImagesBottom">All<input type="checkbox" id="allImagesBottom" class="imageCheckbox" /></label>
	</div>
	<div class="actionPanel">
		<input type="button" id="updateCoords" value="Update image coordinates" />
	</div>
</form>
<?php
}

function processRequest()
{
	$lat = $_POST["lat"];
	$lng = $_POST["lng"];

	foreach($_POST["images"] as $imageId)
	{
		echo "SET $imageId to $lat, $lng<br>";
	}
}
?>