<?php
session_start();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function init_event_post_type() {  
  $post_type = 'Events';
  
  $postarr = array(
      'post_type' => 'event',
      'post_title' => 'event5',
      'post_content' => 'asd',
      'post_status' => 'publish'
      );
    wp_insert_post($postarr);
  
  $labels = array(
    'name' => _x($post_type, 'post type general name'),
    'singular_name' => _x('Event', 'post type singular name'),
    'add_new' => _x('Add New', 'event'),
    'add_new_item' => __('Add New Event'),
    'edit_item' => __('Edit Event'),
    'new_item' => __('New Event'),
    'all_items' => __('All Events'),
    'view_item' => __('View Event'),
    'search_items' => __('Search Events'),
    'not_found' =>  __('No events found'),
    'not_found_in_trash' => __('No events found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Events'
  );

  $post_type_args = array(
      'label' => $post_type,
      'public' => true,
      'show_ui' => TRUE,
      'capability_type' => 'post',
      'hierarchical' => true,
      'rewrite' => array('slug' => strtolower($post_type)),
      'query_var' => true,      
      'supports' => array(
          'title',
          'editor',
          'excerpt',
          'trackbacks',
          'custom-fields',
          'comments',          
          'revisions',
          'thumbnail',
          'author',
          'page-attributes')
  );
  
  register_post_type('event', $post_type_args);
  register_taxonomy('event', array('event'),
          array(
              "hierarchical" => true,
              "label" => $post_type,
              "singular_label" => "Event",
              "rewrite" => true));
  flush_rewrite_rules();
}

add_action('init', 'init_event_post_type');
?>
