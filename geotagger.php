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
$plugin_is_filter = 500 | ADMIN_PLUGIN;
$option_interface = 'zenphotoGeotagger';

zp_register_filter('admin_utilities_buttons', 'zenphotoGeotagger::button');

class zenphotoGeotagger {

	function getOptionsSupported() {
		return array(	gettext('API key') => array('key' => 'gmap_api_key', 'type' => OPTION_TYPE_TEXTBOX,
										'order' => 3,
										'desc' => gettext('Enter your API key - it will be shared with the offical \' GoogleMap\' plugin. You can get one <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#key">here</a>.'))
		);
	}
	
	static function button($buttons) {
		$buttons[] = array(
						'category'		 => gettext('Admin'),
						'enable'			 => true,
						'button_text'	 => gettext('Geotag photos'),
						'formname'		 => 'zenphotoGeotagger_button',
						'action'			 => WEBPATH.'/plugins/geotagger',
						'icon'				 => 'images/pencil.png',
						'title'				 => gettext('Geotag photos in your gallery.'),
						'alt'					 => '',
						'hidden'			 => '',
						'rights'			 => ALBUM_RIGHTS
		);
		return $buttons;
    }
}
?>