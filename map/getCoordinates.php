<?php

define("MAPS_HOST", "maps.google.com");
define("KEY", "ABQIAAAA4BaO70SoEnVrruQHg2dELxT2yXp_ZAY8_ufC3CFXhHIE1NvwkxRM-ZSAo7hKTImNT1VuAOHTX0kuNg");
function getCoordinates($address) {	
	$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;			
			$request_url = $base_url . "&q=" . urlencode($address);
			$xml = simplexml_load_file($request_url) or die("url not loading");
			$status = $xml->Response->Status->code;
				if (strcmp($status, "200") == 0) {
				  // Successful geocode
				  $geocode_pending = false;
				  $coordinates = $xml->Response->Placemark->Point->coordinates;
				  $coordinatesSplit = explode(",", $coordinates);
				  // Format: Longitude, Latitude, Altitude				  
				  $lat = $coordinatesSplit[1];
				  $lng = $coordinatesSplit[0];
				  $coords['lat'] = $lat;
				  $coords['lng'] = $lng;				  
				  

				}   				
return $coords;
				
}
?>