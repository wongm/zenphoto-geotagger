<?php
/**
 * Zenphoto Geotagger
 *
 * Helper page for Zenphoto, enabling the geotagging of photos already uploaded to the gallery.
 *
 * @author Marcus Wong (wongm)
 * @package plugins
 */

$plugin_description = gettext("Helper page for Zenphoto, enabling the geotagging of photos already uploaded to the gallery.");
$plugin_author = "Marcus Wong (wongm)";
$plugin_version = '1.0.0'; 
$plugin_URL = "https://github.com/wongm/zenphoto-geotagger/";

zp_register_filter('admin_toolbox_global', 'zenphotoGeotagger::addGlobalLink');

class zenphotoGeotagger {

    static function addGlobalLink() {
    	echo "<li>";
    	printLinkHTML(WEBPATH.'/plugins/geotagger', gettext("Geotag photos"), NULL, NULL, NULL);
    	echo "</li>";
    }
}
?>