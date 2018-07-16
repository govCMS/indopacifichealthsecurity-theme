<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>
<?php
$url = drupal_get_path_alias( 'node/'.$row->nid);

if( !empty( $field->view ) && !empty( $field->view->result ) ){

	foreach ( $field->view->result as $key => $data ) {
		if( $data->nid == $row->nid ) {
			if( !empty( $data->field_field_team_target_url ) ){
				if( !empty( $data->field_field_team_target_url[0]['rendered']['#element']['url'] ) ){
					$url = $data->field_field_team_target_url[0]['rendered']['#element']['url'];
				}
			}
		}
	}
}

print '<a href="'.$url.'" title="'.$row->node_title.'">'.$row->node_title.'</a>';