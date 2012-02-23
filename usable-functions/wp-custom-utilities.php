<?php

/**
 *  Tailoring the dashboard to a client
 */
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {

  global $wp_meta_boxes;

  unset($wp_meta_boxes['dashboard']['normal']['core']
          ['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']
          ['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']
          ['dashboard_secondary']);

  wp_add_dashboard_widget('custom_help_widget', 'Help and Support',
          'custom_dashboard_help');
}

function custom_dashboard_help() {
  echo '<p>Welcome to your custom theme! Need help? Contact the
developer <a href="http://mytemplates.com ">here</a>.<a
href="”http://mytemplates.com ”"></a></p>';
}

//hook loading of new page and edit page screens
add_action('load-page-new.php', 'add_custom_help_page');
add_action('load-page.php', 'add_custom_help_page');

function add_custom_help_page() {
  //the contextual help filter
  add_filter('contextual_help', 'custom_page_help');
}

function custom_page_help($help) {
  echo $help;
  //add some new copy
  echo "<h5>Custom Features</h5>";
  echo "<p>Content placed above the more divider will appear in
column 1. Content placed below the divider will appear in column
2.</p>";
}

/**
 * adding custom options for the post and page
 */
/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'nyc_boroughs_add_custom_box');


/* Adds a custom section to the "side" of the post edit screen */

function nyc_boroughs_add_custom_box() {


  add_meta_box('nyc_boroughs', 'Applicable Borough',
          'nyc_boroughs_custom_box', 'post', 'side', 'high');
  add_meta_box('nyc_boroughs', 'Applicable Borough',
          'nyc_boroughs_custom_box', 'page', 'side', 'high');
}

/* prints the custom field in the new custom post section */

function nyc_boroughs_custom_box() {
  //get post meta value
  global $post;
  $custom = get_post_meta($post->ID, '_nyc_borough', true);

  // use nonce for verification
  echo '<input type="hidden" name="nyc_boroughs_noncename"
id="nyc_boroughs_noncename" value="' . wp_create_nonce('nyc-
boroughs') . '" />';

  // The actual fields for data entry
  echo '<label for="nyc_borough">Borough</label>';
  echo '<select name="nyc_borough" id="nyc_borough" size="1">';

  //lets create an array of boroughs to loop through
  $boroughs = array('Manhattan', 'Brooklyn', 'Queens', 'The
Bronx', 'Staten Island');
  foreach ($boroughs as $borough) {
    echo '<option value="' . $borough . '"';
    if ($custom == $borough)
      echo ' selected="selected"';
    echo '>' . $borough . '</option>';
  }

  echo "</select>";
}

/* use save_post action to handle data entered */
add_action('save_post', 'nyc_boroughs_save_postdata');

/* when the post is saved, save the custom data */

function nyc_boroughs_save_postdata($post_id) {
  // verify this with nonce because save_post can be triggered at other times
  if (!wp_verify_nonce($_POST['nyc_boroughs_noncename'], 'nyc-
boroughs'))
    return $post_id;

  // do not save if this is an auto save routine
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;

  $nyc_borough = $_POST['nyc_borough'];
  update_post_meta($post_id, '_nyc_borough', $nyc_borough);
}

function getting_featured_thumb() {
  //$postID = 19;
  //$post = get_post($postID);
  //setup_postdata($post);
  //var_dump($post);
  //echo get_post_thumbnail_id(get_the_ID());
  //echo '<pre>';
  //print_r(get_the_attachment_link(get_post_thumbnail_id(get_the_ID())));
  //the_attachment_link(get_post_thumbnail_id(get_the_ID()));
  //echo '</pre>';
  //the_excerpt();
}

/**
 * edit this and modify when developing plugin
 */
define('WP_DEBUG', false);
//Replace that line with the following:
// Turns WordPress debugging on
define('WP_DEBUG', true);

// Tells WordPress to log everything to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Doesn't force the PHP 'display_errors' variable to be on
define('WP_DEBUG_DISPLAY', false);

// Hides errors from being displayed on-screen
@ini_set('display_errors', 0);



/**
 * when creating plugin define the uri or directory
 *
 */
if (!defined('MYPLUGIN_THEME_DIR'))
  define('MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' .
          get_template());

if (!defined('MYPLUGIN_PLUGIN_NAME'))
  define('MYPLUGIN_PLUGIN_NAME',
          trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('MYPLUGIN_PLUGIN_DIR'))
  define('MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' .
          MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_PLUGIN_URL'))
  define('MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' .
          MYPLUGIN_PLUGIN_NAME);

$image = MYPLUGIN_PLUGIN_URL . '/images/my-image.jpg';
$style = MYPLUGIN_PLUGIN_URL . '/css/my-style.css';
$script = MYPLUGIN_PLUGIN_URL . '/js/my-script.js';



/**
 * Creating table in the database
 * @global <type> $wpdb
 */
function myplugin_create_database_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'myplugin_table_name';

    $sql = "CREATE TABLE " . $table . " (
              id INT NOT NULL AUTO_INCREMENT,
              name VARCHAR(100) NOT NULL DEFAULT '',
              email VARCHAR(100) NOT NULL DEFAULT '',
              UNIQUE KEY id (id)
              );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}









?>