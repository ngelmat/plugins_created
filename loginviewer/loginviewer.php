<?php
/*
Plugin Name: Login Viewer
Plugin URI: http://angelohere.wordpress.com/plugin
Description: View the User login logs
Version: 1.0
Author: Angelo M.
Author URI: http://angelohere.wordpress.com
License: A "Slug" license name e.g. GPL2
*/
?>
<?php
include_once 'includes/db_setup.php';
$objLoginViewer = new LoginViewer();


function admin_init_loginviewer() {
    register_setting('loginviewer', 'log');
}


function admin_activate_loginviewer() {
    global $objLoginViewer;
    $objLoginViewer = new LoginViewer();
    $objLoginViewer->createDatabase();    
}

function admin_deactivate_loginviewer() {
    global $objLoginViewer;
    $objLoginViewer = new LoginViewer();
    $objLoginViewer->dropDatabase();    
}


function admin_menu_loginviewer() {    
//    add_menu_page('Login Viewer', 'Login Viewer', 'level_8', 'loginviewer', 'options_page_loginviewer');
    add_options_page('Login Viewer', 'Login Viewer', 'level_8', 'loginviewer', 'options_page_loginviewer');
    
}


function options_page_loginviewer() {    
//    include_once WP_PLUGIN_DIR . '\loginviewer\optionsLoginViewer.php';
    include_once WP_PLUGIN_DIR . '/loginviewer/options.php';;
}

function postUserLogged($user) {
    global $objLoginViewer;
    $objLoginViewer->postLoggedIn($user);
}

function postUserLoggedOut() {
    global $objLoginViewer;    
    date_default_timezone_set('EST');
    $dateTimeEnded = date(' Y:m:d H:i:s A ');
    $_SESSION['logout_time'] = $dateTimeEnded;
    $objLoginViewer->postLoggedOut();
}


register_activation_hook(__FILE__, 'admin_activate_loginviewer');
register_deactivation_hook(__FILE__, 'admin_deactivate_loginviewer');

if (is_admin ()) {
    add_action('admin_init', 'admin_init_loginviewer');
    add_action('admin_menu', 'admin_menu_loginviewer');
}
add_filter('wp_logout', 'postUserLoggedOut');

?>