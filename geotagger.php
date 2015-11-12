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
	  #imageForm {
		padding-bottom: 30px;
      }
	  #updateCoordsPanel {
		position: fixed;
		bottom: 0;
		width: 100%;
		background: white;
		padding: 5px;
	  }
	  #updateCoords {
		width: 290px;
	  }
	  .imageCheckbox {
		float: right;
	  }
	  .imageOptionPanel {
		border-bottom: 1px solid black;
		padding: 5px;
	  }
	  .imageOptionPanel label {
	    width: 100%;
		display: block;
	  }
	  .message {
		color: white;
		padding: 10px;
		margin: 10px;
		text-align: center;
	  }
	  .error {
		background-color: red;
	  }
	  .success {
		background-color: green;
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
		$url = "?action=search&includes=" + $("#includes").val() + "&excludes=" + $("#excludes").val() + "&dateFrom=" + $("#dateFrom").val() + "&dateTo=" + $("#dateTo").val() + "&includeGeocoded=" + document.getElementById("includeGeocoded").checked;
		
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
			console.log( "update request success" );
			$("#searchResults").html( '<p class="message success">Image update successful!</p>' );
		});
		request.fail(function() {
			console.log( "update request error" );
			$("#searchResults").html( '<p class="message error">Image update FAILED!</p>' );
		});
		request.always(function() {
			console.log( "finished update request" );
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
	<form id="imageForm">
	<div class="imageOptionPanel">
		<label for="allImagesTop">All<input type="checkbox" id="allImagesTop" class="imageCheckbox" onclick="toggleCheckboxes(this.checked)" /></label>
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
		<label for="allImagesBottom">All<input type="checkbox" id="allImagesBottom" class="imageCheckbox" onclick="toggleCheckboxes(this.checked)" /></label>
	</div>
	<div id="updateCoordsPanel">
		<input type="button" id="updateCoords" value="Update Coords" onclick="updateImageCoords()" />
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