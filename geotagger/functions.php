<?php

function drawResults()
{
	$locale = null;
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
	
	$sqlWhere  = "1=1";
	if (strlen($includes) > 0)
	{
		$sqlWhere .= " AND (i.title LIKE " . db_quote("%" . $includes . "%") . " OR i.desc LIKE " . db_quote("%" . $includes . "%") . ")";
	}
	if (strlen($excludes) > 0)
	{
		$sqlWhere .= " AND (IFNULL(i.title, '') NOT LIKE " . db_quote("%" . $excludes . "%") . " AND IFNULL(i.desc, '') NOT LIKE " . db_quote("%" . $excludes . "%") . ")";
	}
	if (strlen($dateFrom) > 0)
	{
		$sqlWhere .= " AND i.date >= " . db_quote($dateFrom);
	}
	if (strlen($dateTo) > 0)
	{
		$sqlWhere .= " AND i.date <= " . db_quote($dateTo);
	}
	if (strlen($includeGeocoded) == 0)
	{
		$sqlWhere .= " AND i.EXIFGPSLatitude IS NULL AND i.EXIFGPSLongitude IS NULL";
	}
	
	$sql = "SELECT i.id, i.filename, i.title, i.filename, i.mtime, i.desc, a.folder, a.title AS album_title
			FROM " . prefix('images') . " i
			INNER JOIN " . prefix('albums') . " a ON i.albumid = a.id 
			WHERE " . $sqlWhere . " LIMIT 0, 20";
	$imageResults = query_full_array($sql);
	
	foreach ($imageResults as $image)
	{
	
		$imageId = $image['id'];
		$album = get_language_string($image['album_title'], $locale);
		$caption = get_language_string($image['title'], $locale);
		$description = get_language_string($image['desc'], $locale);
		
		$args = getImageParameters(array(250));
		$filename = getImageURI($args, $image['folder'], $image['filename'], $image['mtime']);
		
		if (strlen($description) > 0)
		{
			$caption = '<abbr title="' . $description . '">' . $caption .'</abbr>';
		}
?>
	<div class="imageOptionPanel">
		<input type="checkbox" id="image<?php echo $imageId ?>" value="<?php echo $imageId ?>" class="imageCheckbox imageOption">
		<label for="image<?php echo $imageId ?>">
			<img src="<?php echo $filename ?>" alt="<?php echo $image['title'] ?>" /><br />
			<?php echo $caption ?><br />
			In album: <?php echo $album ?>
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