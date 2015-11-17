<?php

function drawResults()
{
?>
	<form id="imageForm">
	<div class="imageOptionPanel">
		<label for="allImagesTop"><?php echo gettext("All") ?><input type="checkbox" id="allImagesTop" class="imageCheckbox" /></label>
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
			<img src="http://railgallery.wongm.com/cache/connex/D139_3947_250_thumb.jpg" alt="<?php echo $caption ?>" />
			<?php echo $caption ?> / <?php echo $description ?>
		</label>
	</div>
<?php
	}
?>
	<div class="imageOptionPanel">
		<label for="allImagesBottom"><?php echo gettext("All") ?><input type="checkbox" id="allImagesBottom" class="imageCheckbox" /></label>
	</div>
	<div class="actionPanel">
		<input type="button" id="updateCoords" value="<?php echo gettext("Update image coordinates") ?>" />
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