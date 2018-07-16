<?php

/**
 * Implements hook_preprocess_HOOK().
 *
 * - Preprocess the styled google map view template.
 */
function gov_subtheme_preprocess_views_view(&$vars) {
  $view = &$vars['view'];
  // print '<pre>';
  // print_r($view);exit;
  // Make sure it's the correct view
  if ($view->name == 'health_security_corps_map_block' || $view->name == 'health_system_research_organisation_map' || $view->name == 'national_regulators_block' || $view->name == 'where_we_work' ) {
  	
  	drupal_add_js('//maps.google.com/maps/api/js?sensor=true', array('type' => 'external', 'group' => JS_LIBRARY));

    // add needed javascript
    drupal_add_js(drupal_get_path('theme', 'gov_subtheme') . '/js/google-map.js');
    drupal_add_js(drupal_get_path('theme', 'gov_subtheme') . '/js/infobubble.js');

    $locations = array();

	foreach ($vars['view']->result as $row) {
		
	    $location = array();

	    if ( isset($row->field_field_organisation_geo_location) ) {
	      // Add geofield data.
	      if (isset($row->field_field_organisation_geo_location )) {
	        $location = $location + array( 'location' => $row->field_field_organisation_geo_location[0]['raw'] );
	      } else {
	        break;
	      }
	      // Add pin image url.
	      if (isset($row->field_field_map_pin_image)) {
	          $location = $location + array(
	            'pin' => file_create_url($row->field_field_map_pin_image[0]['raw']['uri'])
	          );
	      }

	      // Add pin popup html.
	      if (isset($row->node_title) ) {
	        $vars['view']->row_index = 0; // TODO: Check why this is necessary.

	        $location = $location + array(
	          // 'popup' => $row->node_title,
	        	'popup' => $vars['view']->field['title']->theme($row)
	        );
	      }
	    }

	    if ($location) {
	      $locations[] = $location;
	    }

	}

	$map_settings['gov_google_map'][] = array('gov-google-map');

	$map_settings['idgov-google-map'] = array(
    	'id' => 'gov-google-map',
    	'locations' => $locations,
    	'style' => '[
			  {
			    "stylers": [
			      { "gamma": 1.03 },
			      { "weight": 1.2 },
			      { "hue": "#00b2ff" },
			      { "saturation": -28 },
			      { "lightness": 10 }
			    ]
			  }
			]',
    	);
	
	drupal_add_js($map_settings, 'setting');
  }
}
