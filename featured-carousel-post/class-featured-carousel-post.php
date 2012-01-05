<?php
/*
  Plugin Name: Featured Carousel Post
  Plugin URI: http://class-featured-carousel-post.org/
  Description: Write your description for the plugin.
  Author: Angelo
  Version: 1.0
  Author URI: http://Angelo.org/
 */

class Featured_Carousel_Post extends WP_Widget {
	
	function __construct() {
		$widget_options = array('classname' => 'Featured_Carousel_Post', 'description' => 'Display Featured Carousel Post');
		parent::__construct(false, 'Featured Carousel Post', $widget_options, $control_options);
	}
	
	
	function widget($args, $instance) {
		extract($args);
		$title = $instance['title'];		
		$featured_category = $instance['featured_category'];		
		echo $before_widget;
		$this->displayFeaturedCarouselPost($featured_category);
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] =  $new_instance['title'];
		$instance['featured_category'] =  $new_instance['featured_category'];		
		return $instance;		 	
	}
	
		
	function form($instance) {
		$categories = get_categories();				
		$optCategories = ""; 	
		foreach ($categories as $category) {
			
			if ($category->cat_ID == $instance['featured_category'])
				$strSelected = "selected=''";				
			else
				$strSelected = "";								
				$optCategories .= "<option $strSelected value='" . $category->cat_ID .  "'>$category->name</option>";
		}
		
		$str = "
			<link rel='stylesheet' type='text/stylesheet' href='" . plugins_url() . "/featured-carousel-post/css/style.css' media='all'/> 	
			<p>
				<label for='" . $this->get_field_id('title')  . "'>Title</label><br/>
				<input type='text' value='" . $instance['title'] . "' id='" . $this->get_field_id('title') . "' name='" . $this->get_field_name('title') . "' class='carousel-tf'/>
			</p>
			<p>
				<label for='" . $this->get_field_id('featured_category') . "'>Featured Category</label><br/>
				<select name='" . $this->get_field_name('featured_category') . "' id='" . $this->get_field_id('featured_category') . "'>" . $optCategories . "					
				</select>
			</p>			
		";
		echo $str;
	}
	
	
	function displayFeaturedCarouselPost($catID) {
		echo "<link rel='stylesheet' type='text/stylesheet' src='" . WP_PLUGIN_URL . "/featured-carousel-post/css/style.css' media='all'/>";
 		echo "<script type='text/javascript' src='" . WP_PLUGIN_URL . "/featured-carousel-post/js/jquery-1.6.4.min.js'></script>"; 						
		echo "<script type='text/javascript' src='" . WP_PLUGIN_URL . "/featured-carousel-post/js/jquery.infinitecarousel.js'></script>";
		echo "<input type='hidden' id='imagesPath' value='" . WP_PLUGIN_URL . "/featured-carousel-post/images'>
					<script type='text/javascript'>		
					$(function(){
		        $('#carousel').infiniteCarousel({
		        displayTime: 6000,
		        textholderHeight : .25
		        });
		      });		
				</script>";
	?>
	  <div id="featured-latest-news" class="">
	  <h1 class="latest-news-title"><span style="color: #AE2330;">Latest</span> <span style="color: #395A8B;"> News</span></h1>
	  
	  <div id="featured-post-article">
			<?php
		    $posts = query_posts('cat=4&orderby=post_date&order=asc');
		      $count = count($posts);
		      for ($i = 0; $i < $count; $i++) {
		         $featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($posts[$i]->ID), 'large');
		      }
		  ?>
		  <div id="carousel" style="width:330px;padding-bottom: 60px">
				<ul>
			    <?php
			      $posts = query_posts("cat=$catID&orderby=post_date&order=asc");
			      $count = count($posts);
			      for ($i = 0; $i < $count; $i++) {
	         		$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($posts[$i]->ID), 'large');
			  	?>
					    <li><img alt="" src="<?php echo $featured_image_url[0]; ?>" width="330" height="213"/>
					      <p><?php echo $this->stringEllipsis($posts[$i]->post_content, 150, ''); ?></p>
							</li>
			  	<?php
			      }
			  	?>
				</ul>
			</div>
    </div>      
  </div>  
  <?php
	}
	
	
	/**
	* 
	* @param type $text
	* @param type $maxChars
	* @param type $splitter
	* @return type
	* 
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
add_action('widgets_init', create_function('', 'register_widget("Featured_Carousel_Post");'));
?>