<?php
/**
 * 
 * Plugin Name: Dynamic Location Map Marker
 * Plugin URI: http://angelohere.wordpress.com/plugin
 * Description: Adding Dynamic Location Map Marker
 * Version: 1.0
 * Author: Angelo M.
 * Author URI: http://angelohere.wordpress.com
 * License: A “Slug” license name e.g. GPL2 
 */

function admin_input_dynamic_map() {
  add_option('sample_input');
  add_options_page('Dynamic Map Location Marker', 'Dynamic Map Option ', 'level_8', 'dynamic_map', 'dynamic_map_options_page');
}


function dynamic_map_options_page() {
  include_once WP_PLUGIN_DIR . '/map/dynamic-map-options-page.php';  
}


if (is_admin ()) 
  add_action('admin_menu', 'admin_input_dynamic_map');


?>


<script type="text/javascript"> 
  var string = "";
  var arrLat = new Array();
  var arrLng = new Array();
  var arrLatTemp = new Array();
  var arrLngTemp = new Array();
  var firstLat;
  var firstLng;
  var infoLocationHTML = new Array();
  var Iconpin = new Array();
  var gField = "";
  var FirstLoad = true;
  var markerArray =  new Array();
  $counter=0; 
    
</script>
<?php
include_once("getCoordinates.php");
//map_piner_function();

	function map_piner_function() {
	  $location = array("Davao", "Panabo", "Tagum");
	  
	  $areadescription = array("Hello Davao Desc", "Hello Panabo Desc", "Hello Davao Desc",);  
	  $i = 0;		
	  foreach ($location as $loc) {
		$coordinates = getCoordinates($loc) ;		
		$lat = $coordinates["lat"];
		$lng = $coordinates["lng"];	
		$infoHTML = '<a href="#' . $loc . '">' . $loc . '</a><p>'. $areadescription[$i].'</p>';
		?>
		<script type="text/javascript">      		
		  arrLat[<?php echo $i; ?>]	= '<?php echo $lat; ?>';
		  arrLng[<?php echo $i; ?>]	= '<?php echo $lng; ?>';      
		  infoLocationHTML[<?php echo $i; ?>]	= '<?php echo $infoHTML; ?>';	  	  
		</script>
		<?php
		$i++;
	  }	
	}
  ?>
  
    
  <div id="panelMap" style="height:500px;top:30px; width: 500px; margin: 0 auto;"></div>
  <script type="text/javascript" src="<?php echo plugins_url();?>/map/js/jquery.js"> </script>  
  <script src="http://maps.google.com/maps?file=api&v=2&key=abcdefg&sensor=true"
        type="text/javascript">
</script>
    <script type="text/javascript">
  
					
    var  varGeoCode;
    var  map;
    // Create a base icon for all of our markers that specifies the
    // shadow, icon dimensions, etc.
    var baseIcon = new GIcon();
	//baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
    baseIcon.iconSize = new GSize(20, 34);
    baseIcon.shadowSize = new GSize(37, 34);
    baseIcon.iconAnchor = new GPoint(9, 34);
    baseIcon.infoWindowAnchor = new GPoint(9, 2);
    baseIcon.infoShadowAnchor = new GPoint(18, 25);
             
             
    // Creates a marker whose info window displays the letter corresponding
    // to the given index.
    function createMarker(point, infoHTML, pin) {
      // Create a lettered icon for this point using our icon class              
      var icon = new GIcon(baseIcon);
      var icon1 = new GIcon(baseIcon);
      var icon2 = new GIcon(baseIcon);
	  
      //icon.image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
      //icon.image = "http://mito.offshore-development.org/wp-content/themes/simplicity/images/government.png";
      icon.image = "http://mito.offshore-development.org/wp-content/themes/simplicity/images/constructionv1.png";     
	  var marker = new GMarker(point, icon);
	  
	 
      GEvent.addListener(marker, "click", function() {
        marker.openInfoWindowHtml(infoHTML);
      });
      return marker;
    }
    	  
		function objctmap(arrLat1, arrLng1){		
		  var map = new GMap2(document.getElementById("panelMap"));
		  
		  
		  if (arrLat1.length > 0) {
			  map.setCenter(new GLatLng(arrLat1[0], arrLng1[0]), 8);
			  map.addControl(new GLargeMapControl());             
			  map.addControl(new GMapTypeControl());
			  //map.setZoom(5);	  
			  map.setZoom(7);	  
			   
			  var pin = "";			  
			  for (i = 0; i < arrLat1.length; i++) {
				firstLat = arrLat[0];
				firstLng = arrLng1[0];
				var point = new GLatLng(arrLat1[i], arrLng1[i]);						
				markerArray[i] = createMarker(point, infoLocationHTML[i], pin);
				map.addOverlay(markerArray[i]);
			} 
		} else {
			if (firstLat != "")
			  map.setCenter(new GLatLng(firstLat, firstLng, 8));
			else
			  map.setCenter(new GLatLng(-34.397, 150.644, 8));
			  map.addControl(new GLargeMapControl());             
			  map.addControl(new GMapTypeControl());			  	 
			  map.setZoom(7);	  			  
			}
		
		
		}
		

  </script> 
  <br>  
  <input type="checkbox" id="a" value="a" class="check" checked="checked"/>A</a><br/>
  <input type="checkbox" id="b" value="b" class="check"/>B</a><br/>
  <input type="checkbox" id="c" value="c" class="check"/>C</a><br/>
  
  
  <script type="text/javascript">
  $(document).ready(function(){  
	init_controls();
	fetchLocations();	
  });
  
  function init_controls() {
	
	$('.check').change(function(){
		var obj = this;		
		fetchLocations();		
	});
  
  }
  
  
  function fetchLocations() {		
	var category = new Array('a', 'b', 'c');	
	var locations = new Array();	
	var query = "";
	arrLat =  new Array();
	arrLng =  new Array();
	for(i=0; i<category.length; i++) {
		
		var letter = category[i];
		var id = "#" + letter;			
		if ($(id).attr('checked') == "checked") {			
			query = query + "choice" + i + "=" + letter + "&";														
		}		
	}	
	$.ajax({
				type: "post",
				data: query,
				url: "<?php echo plugins_url(); ?>/map/fetch-api.php",
				success: function (resp){					
					var jsonTemp = $.parseJSON(resp);							
					arrLat = jsonTemp.lat;
					arrLng = jsonTemp.lng;							
					objctmap(arrLat, arrLng);							
				}						
			});
  }
  
  
  
  
  </script>
  
  
  
  
<?php
//}
//add_shortcode('dynamic_map_marker', 'map_piner_function');

?>
  

