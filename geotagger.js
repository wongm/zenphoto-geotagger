var map;
var lat;
var lng;

$(function() {
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#search").click(runSearch);
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
		lat: lat,
		lng, lng,
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
		$("#searchResults").toggle();
		$("#searchForm").toggle();
	});

	return false;
}

function toggleCheckboxes(selectAll) {
	$(".imageCheckbox").each(function( index ) {
		this.checked = selectAll;
	});
}