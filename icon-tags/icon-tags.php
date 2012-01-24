<?php

/*
  Plugin Name: icon-tags
  Plugin URI: ICON TAGS
  Description: Select icon for tags
  Author: Angelo
  Version: 1.0
  Author URI: Icon tags
 */

class IconTags extends WP_Widget {

  function __construct() {
    $widget_options = array('classname' => 'IconTags', 'description' => 'ASAS');
    parent::__construct(false, 'Icon Tags', $widget_options, $control_options);
  }

  function widget($args, $instance) {
    extract($args);
    var_dump($instance);
  }

  function form($instance) {
    ?>
<select name="<?php echo $this->get_field_name('here');?>">
  <option value="here1" selected="selected">asas1</option>
  <option value="here2" selected="selected">asas2</option>
</select>
    <?php

  }

  function update($new_instance, $old_instance) {        
    $old_instance['here'] = $new_instance['here'];
    return $old_instance;    
  }

}

add_action('widgets_init', create_function('', 'register_widget("IconTags");'));



/**
 * For Adding Options Administration
 */
function icon_tags_options() {
  include_once WP_PLUGIN_DIR . '/icon-tags/options.php';
}


function icon_tag_menu() {
  add_options_page('Icon Tags', 'Icon Tags', 'level_8', 'icon-tags', 'icon_tags_options');
}
  
add_action('admin_menu', 'icon_tag_menu');



?>
