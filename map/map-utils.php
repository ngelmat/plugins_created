<?php

function getAllLocations () {
    $categories = array('a',  'b', 'c');
    $assumeExist = TRUE;
    $last = 0;
    
    
    while ($assumeExist == TRUE) {   
        $existLocation = 0;
        $last++;
        foreach ($categories as $value) {
            $locationOptionName = 'location_' . $last . '_cat_' . $value;
            if (get_option($locationOptionName)) {                
                $locations[] = get_option($locationOptionName);
                $existLocation++;
            }            
        }
        if ($existLocation > 0)
            $assumeExist = TRUE;
        else
            $assumeExist = FALSE;    
    }
    return $locations;
}

function getLocationsByCat($cat) {
    $assumeExist = TRUE;
    $last = 0;
    $locations = array("Davao", "Panabo");
    /*
    while ($assumeExist == TRUE) {   
        $existLocation = 0;
        $last++;
        //foreach ($categories as $value) {
        $locationOptionName = 'location_' . $last . '_cat_' . $cat;
        if (get_option($locationOptionName)) {
            //echo $locationOptionName . ': ' . get_option($locationOptionName) . '<br/>';
            $locations[] = get_option($locationOptionName);
            $existLocation++;
        }                    
        if ($existLocation > 0)
            $assumeExist = TRUE;
        else
            $assumeExist = FALSE;    
    }*/
    return $locations;
}






?>
