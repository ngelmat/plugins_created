<?php
include_once('getCoordinates.php');
include_once 'map-utils.php';

if (isset($_POST['choice']))
	$choice  = $_POST['choice'];

$locationsArr = array();
$latArr = array();
$lngArr = array();
foreach($_POST as $choice) {	
	switch ($choice) {

		case 'a' :
			//$locations = array("Davao", "Panabo", "Tagum");
			$locations = getLocationsByCat('a');
			$locationsArr = array_merge($locationsArr, $locations );			
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			
			break;
		case 'b':
			$locations = array("Cotabato", "Kidapawan", "Digos");		
			$locationsArr = array_merge($locationsArr, $locations );
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			
			break;
		case 'c' :
			$locations = array("Cebu", "Leyte", "Bohol");	
			$locationsArr = array_merge($locationsArr, $locations );			
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			//$var = array('locations' => $locations, 'lat' => $lat, 'lng' => $lng);		
			//echo json_encode($var);	
			break;
		default:
			break;
	}
	$latArr = array_merge($latArr, $lat);
	$lngArr = array_merge($lngArr, $lng);
	
}
$var = array('locations' => $locationsArr, 'lat' => $latArr, 'lng' => $lngArr);		
echo json_encode($var);

die();
	switch ($choice) {

		case 'a' :
			$locations = array("Davao", "Panabo", "Tagum");
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			
			echo json_encode($var);
			break;
		case 'b':
			$locations = array("Cotabato", "Kidapawan", "Digos");		
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			$var = array('locations' => $locations, 'lat' => $lat, 'lng' => $lng);		
			echo json_encode($var);		
			break;
		case 'c' :
			$locations = array("Cebu", "Leyte", "Bohol");		
			foreach($locations as $loc)	 {
				$coordinates = getCoordinates($loc);
				$lat[] = $coordinates['lat'];
				$lng[] = $coordinates['lng'];
			}
			$var = array('locations' => $locations, 'lat' => $lat, 'lng' => $lng);		
			echo json_encode($var);	
			break;
		default:
			break;
	}

?>