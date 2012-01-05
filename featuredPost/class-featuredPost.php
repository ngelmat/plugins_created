<?php
/*
  Plugin Name: Featured Post
  Plugin URI: http://angelohere.wordpress.com/plugin
  Description: Displaying Featured Post
  Version: 1.0
  Author: Angelo M.
  Author URI: http://angelohere.wordpress.com
  License: A "Slug" license name e.g. GPL2
 */

/**
 * Description of class
 *
 * @author Angelo
 */
class FeaturedPost extends WP_Widget {
  
  function __construct() {
    $widget_options = array('classname' => 'FeaturedPost', 'description' => 'Displayed Featured Posts');
    parent::__construct(false, 'Featured Post', $widget_options, $control_options);    
  }
  
  
  /**
   *
   * @param type $args
   * @param type $instance 
   */
  function widget($args, $instance) {
    extract($args);
    $title = $instance['title'];
    $catID = $instance['feat_category'];
    //for custom css of the widget contents
    echo '<link rel="stylesheet" media="all" type="text/css" href="' . get_bloginfo('url') .'/wp-content/plugins/featuredPost/css/style.css"/>'; 
    echo $before_widget;
    ?>
    <h3 class="widget-title"><?php echo $title; ?></h3>
    <?php
    $this->displayFeaturedPost($catID);
    echo $after_widget;
  }
  
  /**
   *
   * @param type $new_instance
   * @param type $old_instance
   * @return type 
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['feat_category'] = $new_instance['feat_category'];
    return $instance;
  }
  
  
  /**
   *
   * @param type $instance 
   */
  function form($instance) {
    ?>
    <p>        
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label>
      <input id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>"  style="width:200px"/>
    </p>    
      <?php 
        $gender = $instance['gender'];      
        $selCategory = $instance['feat_category'];
        $categories = get_categories();
      ?>
    <p>
      <label for="<?php echo $this->get_field_id('gender'); ?>"><?php _e('Featured Category: '); ?></label><br/>
      <select id="<?php echo $this->get_field_id('feat_category'); ?>" name="<?php echo $this->get_field_name('feat_category')?>">
        <?php
          foreach ($categories as $category) {
            ?>
            <option <?php if ($selCategory == $category->cat_ID) echo 'selected="selected"';?> value="<?php echo $category->cat_ID; ?>">
              <?php echo $category->name; ?>
            </option>
            <?php
          }
        ?>
      </select>
    </p>
    <?php
  }
  
  /**
   * @author Angelo M.
   * @param type $catID
   * @uses for Displaying and managing thg Featured Post 
   */
  function displayFeaturedPost($catID) {
    
    $args = array( 'numberposts'=> 5,
    'offset'          => 0,
    'cat'        => $catID,
    'orderby'         => 'post_date',
    'order'           => 'DESC',    
    'post_type'       => 'post',    
    'post_status'     => 'publish' );
    
    $posts = get_posts($args);
    $count = count($posts);
    for($i = 0; $i < $count; $i++) {
      ?>
    <?php
      if ($i != $count-1) {
    ?>
    <div id="home-headlines-article">
        <?php
      } else {
        ?>
        <div id="home-headlines-article-last">
      <?php
      }
        $anchor = '<h1 class="headlines" id="headlines-post-title" >'. $posts[$i]->post_title . '"</h1>';  
        echo '<p>'. $anchor . '</p>';
         $content = $posts[$i]->post_content;
         $ellipseLength = 300;
         $strLen = strlen($content);
         if ($ellipseLength <= $strLen)
          $subContent = $this->stringEllipsis($content, $ellipseLength, '');
         else
          $subContent = $this->stringEllipsis($content, $strLen, ''); 
        echo $subContent;
        ?>
          <div style="float: right;">
            <br><a class="readmore" style="color: #BB0011;" href="<?php echo get_permalink($posts[$i]->ID); ?>">Read More&nbsp;>></a>  
          </div>							         
      </div>
      <?php
    }
  }
  
  
  /**
   *
   * @param type $text
   * @param type $maxChars
   * @param type $splitter
   * @return type 
   */
  function stringEllipsis($text, $maxChars = 20, $splitter = '...') {
    $theReturn = $text;
    $lastSpace = false;

    if (strlen($text) > $maxChars) {
      $theReturn = substr($text, 0, $maxChars - 1);
      if (in_array(substr($text, $maxChars - 1, 1),array(' ', '.', '!', '?'))) {
        $theReturn .= substr($text, $maxChars, 1);
      } else {
        $theReturn = substr($theReturn, 0, $maxChars - strlen($splitter));
        $lastSpace = strrpos($theReturn, ' ');
        if ($lastSpace !== false) {
          $theReturn = substr($theReturn, 0, $lastSpace);
        }
        if (in_array(substr($theReturn, -1, 1), array(','))) {
          $theReturn = substr($theReturn, 0, -1);
        }
        $theReturn .= $splitter;
      }
    }
    return $theReturn;
  }
}

add_action('widgets_init', create_function('', 'register_widget("FeaturedPost");'));
?>