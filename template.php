<?php

/**
 * @file
 * Template file for GovCMS Subtheme.
 */
include 'google-map.php';

/**
 * @function
 * Hook Preprocess
 * Handle to add parent-active class to the 2nd level menu if 3 rd level menu active for sidebar
 */
function gov_subtheme_preprocess_page(&$variables) {


    if (!empty($variables) && isset($variables['page']['sidebar_first']['menu_block_1'])) {

        $main_menu = $variables['page']['sidebar_first']['menu_block_1']['#content'];

        if (!empty($main_menu)) {
            foreach ($main_menu as $key => $menu) {

                if (isset($menu['#below'])) {

                    foreach ($menu['#below'] as $sub_key => $sub_menu) {

                        if (( isset($sub_menu['#original_link']['in_active_trail']) && $sub_menu['#original_link']['in_active_trail'] == 1 ) && $menu['#href'] == $sub_menu['#href']) {

                            $menu['#attributes']['class'][] = 'first-parent-active';
                        }

                        if (isset($sub_menu['#below'])) {

                            foreach ($sub_menu['#below'] as $s_sub_key => $s_sub_menu) {

                                if (isset($s_sub_menu['#original_link']['in_active_trail']) && $s_sub_menu['#original_link']['in_active_trail'] == 1) {
                                    // print '<pre>';
                                    // print_r($sub_menu);exit;
                                    $sub_menu['#attributes']['class'][] = 'parent-active';
                                }
                            }
                        }

                        $menu['#below'][$sub_key] = $sub_menu;
                    }
                }

                $main_menu[$key] = $menu;
            }
        }
        $variables['page']['sidebar_first']['menu_block_1']['#content'] = $main_menu;
    }

}

function gov_subtheme_js_alter(&$js) {
    //dpm($js);
    $key = "&key=AIzaSyB1dlh3XWqohCArxi5HNlsqj4PRb0FFJA8";

    //for geofield input widget
    if (isset($js['//maps.google.com/maps/api/js?sensor=true'])) {

        $js['//maps.google.com/maps/api/js?sensor=true']['data'] .= $key;
    }

    //for geofield map views style plugin ?! (I think)
    if (isset($js['//maps.googleapis.com/maps/api/js?sensor=false'])) {

        $js['//maps.googleapis.com/maps/api/js?sensor=false']['data'] .= $key;
    }

    // Swap out jQuery to use an updated version of the library.
    // if ($replace_jquery) {
    $js['misc/jquery.js']['data'] = '//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js';
    // }
}

/* function gov_subtheme_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  // print '<pre>';
  // print_r($variables);exit;
  // Always display a link to the current page by duplicating the last link in
  // the active trail. This means that menu_get_active_breadcrumb() will remove
  // the last link (for the current page), but since it is added once more here,
  // it will appear.

  // if (!drupal_is_front_page()) {
  //   $end = end($active_trail);
  //   if ($item['href'] == $end['href']) {
  //     $active_trail[] = $end;
  //   }
  // }
  } */

function gov_subtheme_menu_breadcrumb_alter(&$active_trail, $item) {

    if (arg(0) == 'search') {

        if (!empty($active_trail[3])) {
            unset($active_trail[3]);
        }

        if (!empty($active_trail[2])) {
            if (isset($active_trail[2]['link_title']) && $active_trail[2]['link_title'] == 'Content') {

                unset($active_trail[2]);

                $active_trail[] = array(
                    'title' => t("Search results"),
                    'href' => '',
                    'link_path' => '',
                    'localized_options' => array(),
                    'type' => 0
                );
                // $active_trail[2]['link_title'] = 'Search results';
            }
        }
    }

    if (isset($active_trail[1]['map']) && !empty($active_trail[1]['map'])) {
        $current = $active_trail[1]['map'];
        $node_obj = '';
        if (isset($current[0]) && $current[0] == 'node') {
            $node_obj = $current[1];
        }

        if (!empty($node_obj) && $node_obj->type == 'technical_reference_group') {
            $temp = $active_trail[1];

            $active_trail[1] = array(
                'title' => t("Governance"),
                'href' => 'technical-reference-group',
                'link_path' => 'technical-reference-group',
                'localized_options' => array(),
                'type' => 0
            );

            $active_trail[] = array(
                'title' => t("Technical Reference Group"),
                'href' => 'technical-reference-group',
                'link_path' => 'technical-reference-group',
                'localized_options' => array(),
                'type' => 0
            );

            $active_trail[] = $temp;
        }

        if (!empty($node_obj) && $node_obj->type == 'our_team') {
            $temp = $active_trail[1];

            $active_trail[1] = array(
                'title' => t("About"),
                'href' => 'about',
                'link_path' => 'about',
                'localized_options' => array(),
                'type' => 0
            );

            $active_trail[] = array(
                'title' => t("Our Team"),
                'href' => 'our-team',
                'link_path' => 'our-team',
                'localized_options' => array(),
                'type' => 0
            );

            $active_trail[] = $temp;
        }
    }
}

function gov_subtheme_preprocess_search_result(&$vars) {

    //delete user + date
    $vars['info'] = "";
}

function gov_subtheme_process_page(&$variables) {

    if (arg(0) == 'search') {

        $variables['breadcrumb'] = str_replace('Content', 'Search results', $variables['breadcrumb']);
        $variables['title'] = 'Search results';
    }
}

/**
 * Implements hook_theme().
 */
function gov_subtheme_theme($existing, $type, $theme, $path) {

    $themes['gov_subtheme'] = array(
        'variables' => array(
            'location' => NULL,
            'display' => NULL,
            'entity' => NULL,
            'entity_type' => NULL,
        ),
    );
    return $themes;
}


