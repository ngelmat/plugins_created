/**
* Use for setting the Icon in Tags 
*
*/
e.g:

/**
* Sample of code to display the tag icon based from the plugin
*/
the_post();
$tags = get_the_tags(get_the_ID());
foreach ($tags as $tag) {
  var_dump($tag->name);
  ?>
  <img alt="" src="<?php echo get_option('icon-' . $tag->name); ?>"/>
  <?php
}
?>
*  
*/