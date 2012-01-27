<?php
wp_enqueue_style('thickbox');
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL . '/icon-tags/js/script.js', array('jquery', 'media-upload', 'thickbox'));
wp_enqueue_script('my-upload');
wp_enqueue_style('style', WP_PLUGIN_URL . '/icon-tags/css/style.css');

if (isset($_POST['submit'])) {  
  unset($_POST['submit']);
  $i = 0;
  $tagsElements = $_POST;
  foreach ($tagsElements as $name => $icon) {
    delete_option($name);
    add_option($name, $icon);
    $tags[$i]['name'] = $name;
    $tags[$i]['icon'] = $icon;
    $i++;
  }
}
?>
<div class="wrap">
  <div class="" id="tag-icon-setting"></div><h2>Tag Icon Settings</h2>    
  <p class="settings-description">By default WordPress uses tags for post/s. In these settings you can set the icon for the particular tag.</p>
  <form method="post">    
    <?php
    $tags = get_tags();
    ?>
    <table id="post-tag-options">
      <?php
      foreach ($tags as $tag) {
        $iconName = 'icon-' . $tag->name;
        $iconSrc = get_option($iconName);
        ?>        
          <tr>
            <td class="label-tag-name">Tag Name: </td>
            <td class="label-tag-name"><?php echo $tag->name; ?></td>
          </tr>
          <tr>
            <td class="label-tag-description">Tag Description: </td>
            <td class="label-tag-description"><?php echo $tag->description; ?></td>
          </tr>
          <tr>
            <td>Icon Image:</td>
            <td><input id="uploaded_image-<?php echo $tag->name; ?>" type="text" size="50" name="icon-<?php echo $tag->name; ?>" 
                 value="<?php echo $iconSrc; ?>" />
            </td>
            <td><input class="uploadBtn button-primary" type="button" value="Upload Tag Icon" id="<?php echo $tag->name; ?>"/><br/></td>
          </tr>        
        <?php
      }
      ?>  
    </table>      
    <p class="submit"><input type="submit" value="Save Changes" class="button-primary icon-save-btn" id="submit" name="submit"></p>
  </form>
</div>


