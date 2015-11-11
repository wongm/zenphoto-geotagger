<?php
if (isset($_GET["includes"]))
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
	<style>
      html, body {
        min-height: 100%;
        margin: 0;
        padding: 0;
      }
	  #wrapper {
		position: absolute;
		top: 35px;
		bottom: 0;
		left: 0;
		right: 0;
	  }
	  #searchForm {
		padding: 5px;
		height: 35px;
	  }
      #map {
        height: 100%;
      }
      #searchResults {
        height: 100%;
		width: 300px;
		float: left;
		overflow-y: scroll;
		overflow-x: hidden;
      }
    </style>
  </head>
  <body>
	<form id="searchForm">
		<label for="includes">Includes</label><input type="text" id="includes" />
		<label for="excludes">Excludes</label><input type="text" id="excludes" />
		<label for="dateFrom">From</label><input type="text" id="dateFrom" class="datepicker" />
		<label for="dateTo">To</label><input type="text" id="dateTo" class="datepicker" />
		<label for="includeGeocoded">Inc. geocoded</label><input type="checkbox" id="includeGeocoded" />
		<input type="button" id="search" value="Search" />
	</form>
	<div id="wrapper">
		<div id="searchResults"></div>
		<div id="map"></div>
	</div>
	<script>
	var map;
	var lat;
	var lng;
	
	function initMap() {
	  var centreLatlng = {lat: -37.8136, lng: 144.9631};

	  map = new google.maps.Map(document.getElementById('map'), {
		center: centreLatlng,
		zoom: 10,
		mapTypeId: google.maps.MapTypeId.HYBRID
	  });
	  
	  var marker = new google.maps.Marker({
		position: centreLatlng,
		map: map,
		title: 'Click to focus',
		draggable: true
	  });
	  
	  updateLatLng(marker.getPosition());
	  
	  marker.addListener('dragend', function() {
		updateLatLng(marker.getPosition());
	  });
	  
	  map.addListener('click', function(event) {
		marker.setPosition(event.latLng);
		updateLatLng(event.latLng);
	  });
	}
	
	function updateLatLng(latLng) {
	  lat = latLng.lat();
	  lng = latLng.lng();
	}
	
	$(function() {
		$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
		$("#search").click(runSearch);
    });
	
	function runSearch() {
		$url = "?includes=" + $("#includes").val() + "&excludes=" + $("#excludes").val() + "&dateFrom=" + $("#dateFrom").val() + "&dateTo=" + $("#dateTo").val() + "&includeGeocoded=" + document.getElementById("includeGeocoded").checked;
		
		$.get($url, function( data ) {
		  $("#searchResults").html( data );
		});
		return false;
	}
	
	function updateImageCoords() {
		var selectedImages = [];
		$(".imageOption").each(function( index ) {
			if (this.checked) {
				selectedImages.push(this.value);
			}
		});
		
		var data = { 
			images: selectedImages,
			lat: lat,
			lng, lng,
		};
		
		var request = $.ajax({
		  type: "POST",
		  url: "#",
		  data: data,
		});
		
		request.done(function() {
			console.log( "success" );
		});
		request.fail(function() {
			console.log( "error" );
		});
		request.always(function() {
			console.log( "finished" );
		});
	
		return false;
	}
	
	function toggleCheckboxes(selectAll) {
		$(".imageCheckbox").each(function( index ) {
			this.checked = selectAll;
		});
	}
	</script>
	<script src="//maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
  </body>
</html>
<?php
}

function drawResults()
{
?>
	<form id="imageform">
	<label for="allImagesTop">All</label><input type="checkbox" id="allImagesTop" class="imageCheckbox" onclick="toggleCheckboxes(this.checked)" /><br />
<?php
	$includes = $_GET["includes"];
	$excludes = $_GET["excludes"];
	$dateFrom = $_GET["dateFrom"];
	$dateTo = $_GET["dateTo"];
	$includeGeocoded = $_GET["includeGeocoded"];
	
	echo "includeGeocoded = $includeGeocoded<BR>";
	echo "includes = $includes<BR>";
	echo "excludes = $excludes<BR>";
	echo "dateFrom = $dateFrom<BR>";
	echo "dateTo = $dateTo<BR>";
	
	for ($imageId = 4564; $imageId <= 4600; $imageId++)
	{
?>
<label for="image<?php echo $imageId ?>"><?php echo $imageId ?></label><input type="checkbox" id="image<?php echo $imageId ?>" value="<?php echo $imageId ?>" class="imageCheckbox imageOption"><br />
<?php
	}
?>
	<label for="allImagesBottom">All</label><input type="checkbox" id="allImagesBottom" class="imageCheckbox" onclick="toggleCheckboxes(this.checked)" /><br />
	<input type="button" id="updateCoords" value="Update Coords" onclick="updateImageCoords()" />
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