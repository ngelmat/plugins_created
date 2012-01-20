<?php

/*
  Plugin Name: reuse-image-uploader
  Plugin URI: http://reuse-image-uploader.org/
  Description: Write your description for the plugin.
  Author: Angelo
  Version: 1.0
  Author URI: http://Angelo.org/
 */
?>
<?php

function displayReuse() {
  add_options_page('Reuse Uploader', 'Reuse Uploader', 'level_8', 'reuse-uploader', 'options_page_reuse_uploader');
}

function options_page_reuse_uploader() {
  include_once WP_PLUGIN_DIR . '/reuse-image-uploader/options.php ';
}

function reuse_image_uploader_scripts() {
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_register_script('my-upload', WP_PLUGIN_URL . '/reuse-image-uploader/js/script.js', array('jquery', 'media-upload', 'thickbox'));
  wp_enqueue_script('my-upload');
}

function reuse_image_uploader_styles() {
  wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'reuse-uploader') {
  add_action('admin_print_scripts', 'reuse_image_uploader_scripts');
  add_action('admin_print_styles', 'reuse_image_uploader_styles');
  
}
add_action('admin_menu', 'displayReuse');
?>