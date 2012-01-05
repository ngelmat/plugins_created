<?php
/*
Plugin Name: PopupDiv
Plugin URI: http://angelohere.wordpress.com/plugin
Description: Popup Div Content
Version: 1.0
Author: ngelMat
Author URI: http://angelohere.wordpress.com
License: A "Slug" license name e.g. GPL2
*/
?>
<?php
  
  function popupDivInit($content){
    
    
    ?>
      <div id="popupTesti">
            <a id="popupTestiClose" alt="Close" title="Close">x</a>
            <div id="content_popup">
            </div>
        </div>
        <div id="backgroundPopup"></div>
      <script type="text/javascript" src="<?php echo bloginfo('url'); ?>/wp-content/plugins/popupDIV/scripts/jquery.js"></script>      
      <!--end popup content css-->
      <script type="text/javascript">
          var $ = jQuery.noConflict();
          //var url = "<?php echo bloginfo('url'); ?>/wp-content/plugins/popupDIV/popupRequest.php";
          var url = "<?php echo bloginfo('url'); ?>/wp-admin/admin-ajax.php";
          $(document).ready(function() {
            
          });
      </script>
      <link rel="stylesheet" href="<?php echo bloginfo('url'); ?>/wp-content/plugins/popupDiv/scripts/popup-style.css" type="text/css" media="screen" />
      <script src="<?php echo bloginfo('url'); ?>/wp-content/plugins/popupDiv/scripts/popup.js" type="text/javascript"></script>
      <!--popup content css-->
      <link rel="stylesheet" type="text/css" media="all" href="<?php echo bloginfo('url'); ?>/wp-content/plugins/popupDiv/scripts/popup-content.css"/>
    <?php
    
    return $content;
  }
  add_filter('wp_footer', 'popupDivInit');
?>