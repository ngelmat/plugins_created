<?php
wp_enqueue_style('thickbox');
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', WP_PLUGIN_URL . '/icon-tags/js/script.js', array('jquery', 'media-upload', 'thickbox'));
wp_enqueue_script('my-upload');
?>
<div class="wrap">
  <h2>Tag Icons</h2>
  <form method="post">    
    <?php
    $tags = get_tags();
    foreach ($tags as $tag) {
      echo $tag->name;
      ?>
      <input id="uploaded_image-<?php echo $tag->name; ?>" type="text" size="36" name="uploaded_image" value="" />
      <input class="uploadBtn" type="button" value="Upload Tag Icon" id="<?php echo $tag->name; ?>"/><br/>
      <?php
    }
    ?>    
    <input type="submit" value="Save"/><br/>
  </form>
</div>


