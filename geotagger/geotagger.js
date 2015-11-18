var map;

$(function() {
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#search").click(runSearch);
	$('#searchPanel input').keypress(function (e) {
		if (e.which == 13) {
			runSearch();
			return false;
		}
	});
});

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
	
	// Create the search box and link it to the UI element.
	var input = document.getElementById('placeSearch');
	var searchBox = new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	
	// Listen for the event fired when the user selects a prediction and retrieve more details for that place.
	
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();
		var bounds = new google.maps.LatLngBounds();

		if (places.length == 0) {
			return;
		}
		
		if (places[0].geometry.viewport) {
			// Only geocodes have viewport.
			bounds.union(places[0].geometry.viewport);
		} else {
			bounds.extend(places[0].geometry.location);
		}
		
		marker.setPosition(places[0].geometry.location);
		updateLatLng(places[0].geometry.location);
		map.fitBounds(bounds);
	});
	
	marker.addListener('dragend', function() {
		updateLatLng(marker.getPosition());
	});
	
	map.addListener('click', function(event) {
		marker.setPosition(event.latLng);
		updateLatLng(event.latLng);
	});
}

function updateLatLng(latLng) {
	$('#lat').val(latLng.lat());
	$('#lng').val(latLng.lng());
}

function runSearch() {
	$url = "?action=search&includes=" + $("#includes").val() + "&excludes=" + $("#excludes").val() + "&dateFrom=" + $("#dateFrom").val() + "&dateTo=" + $("#dateTo").val() + "&includeGeocoded=" + document.getElementById("includeGeocoded").checked;
	
	
	$.get($url, function( data ) {
		$("#searchResults").toggle();
		$("#searchForm").toggle();
	
		$("#searchResults").html( data );

		//register the event magic
		$("#allImagesBottom").click(function() { toggleCheckboxes(this.checked) });
		$("#allImagesTop").click(function() { toggleCheckboxes(this.checked) });
		$("#updateCoords").click(updateImageCoords);
		$(".cancelSearch").click(displaySearch);
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
	
	if (selectedImages.length == 0) {
		alert("Select an image to geotag!");
		return false;
	}
	
	var data = { 
		images: selectedImages,
		lat: $("#lat").val(),
		lng: $("#lng").val(),
	};
	
	var request = $.ajax({
		type: "POST",
		url: "#",
		data: data,
	});
	
	request.done(function() {
		$("#actionMessage").html( '<p class="message success">Geotagging of ' + selectedImages.length + ' images successful!</p>' );
	});
	request.fail(function() {
		$("#actionMessage").html( '<p class="message error">Geotagging of ' + selectedImages.length + ' images FAILED!</p>' );
	});
	request.always(function() {
		displaySearch();
	});

	return false;
}

function displaySearch() {
	$("#searchResults").toggle();
	$("#searchForm").toggle();
}

function toggleCheckboxes(selectAll) {
	$(".imageCheckbox").each(function( index ) {
		this.checked = selectAll;
	});
}