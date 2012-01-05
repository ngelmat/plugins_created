<?php
session_start();
/*
  Plugin Name: Yahoo Weather Like
  Plugin URI: http://angelohere.wordpress.com/plugin
  Description: Create Weather Forecast based on the Yahoo API core
  Version: 1.0
  Author: Angelo Matildo
  Author URI: http://angelohere.wordpress.com
  License: A "Slug" license name e.g. GPL2
 */


global $actualFileNameContents;
global $yahooWeatherFileNameContents;
global $isDaytime;  
global $sunrise;
global $sunset;
global $timeBuild;
global $weatherCount;
$actualFileNameContents = 'weather-contents.xml';
$yahooWeatherFileNameContents = 'clean-weather-contents.txt';
$weatherCount = 0;

/**
 * Activate the Plugin
 */
function activateForecastWeather() {
  add_shortcode('getWeather', 'doGetWeather');
  add_filter('widget_text', 'do_shortcode');  
  
}

/**
 * @author Angelo M.
 * @global string $actualFileNameContents
 * @global string $yahooWeatherFileNameContents
 * @param type $atts 
 */
function doGetWeather($atts) {
  global $actualFileNameContents;
  global $yahooWeatherFileNameContents;
  
  extract(shortcode_atts(array('zip_code'=> '', 'location'=> ''), $atts));
  $URI = 'http://xml.weather.yahoo.com/forecastrss/' . $zip_code . '_f.xml';

  $success = false;
  do {
    $value = array();
    if (strlen($zip_code) > 0) {
      $contents = file_get_contents($URI);      
      $file = fopen($actualFileNameContents, 'w+'); 
      fputs($file, $contents); 
    } else {
      $value = getGeoDetails($location);       
      if (strlen($value['zipcode']) > 0) {
        $URI = 'http://xml.weather.yahoo.com/forecastrss/' . $value['zipcode'] . '_f.xml';
        $contents = file_get_contents($URI);
      }        
    }
    
    if ($contents) {
      $contents = extractYahooWeather($contents);        
      $contents = implode('' . PHP_EOL, $contents);
      $file = fopen($yahooWeatherFileNameContents, 'w+'); 
      fputs($file, $contents);
      fclose($file);  
    } 
    
    
    if (strlen($contents) > 0 && $contents) {
      displayTitle($location, $URI);
      $currentWeather = htmlCurrentWeather($contents);
      $success = true;
    } else {      //if zip codes contain only two forecasts
      $URI = 'http://weather.yahooapis.com/forecastrss?w=' . $value['woeid'];     
      $contents = file_get_contents($URI);
      $contents = extractYahooWeather($contents);  
      $contents = implode('' . PHP_EOL, $contents);
      $file = fopen($yahooWeatherFileNameContents, 'w+'); 
      fputs($file, $contents);
      fclose($file);     
      displayTitle($location, $URI);
      $currentWeather = htmlCurrentWeather($contents);
      $success = true;
    }     
  } while (!$success);
  $weatherForecasts = htmlYahooWeatherForecast();
}

//functions 

/**
 * @author Angelo M.
 * @copyright October 20, 2011 
 * @param type $contents
 * @return type 
 */
function extractYahooWeather($contents) {
  preg_match_all("/yweather:.*>/", $contents, $matches, PREG_PATTERN_ORDER);
  $contents = $matches[0];
  return $contents;
}

/**
 *
 * @param type $contents
 * @return type string
 */
function htmlCurrentWeather($contents) {
  global $isDaytime;
  global $sunrise;
  global $sunset;
  global $weatherCount;
  
  $weather['temperature'] = extractYahooWeatherParam('chill') . '°';
  $weather['humidity']    = extractYahooWeatherParam('humidity') . '%';
  $weather['sunrise']     = extractYahooWeatherParam('sunrise');
  $weather['sunset']      = extractYahooWeatherParam('sunset');
  $weather['speed_unit']  = extractYahooWeatherParam('speed');
  $weather['speed']       = extractConditionWeatherParam(getYahooWeatherCategory('wind'), 'speed');
  $weather['distance']    = extractYahooWeatherParam('distance');
  $weather['condition']   = getCurrentYahooCondition();
  $weather['low']         = extractConditionWeatherParam(getYahooWeatherCategory('forecast'), 'low') . '°';
  $weather['high']        = extractConditionWeatherParam(getYahooWeatherCategory('forecast'), 'high') . '°';
  $sunrise = $weather['sunrise'];
  $sunset = $weather['sunset'];  
  unset($_SESSION['sunrise']);
  unset($_SESSION['sunset']);
  unset($_SESSION['isDaytime']);
  
  $_SESSION['sunrise'] = $sunrise;
  $_SESSION['sunset'] = $sunset;
  
  
  $_SESSION['isDaytime'] = isDaytime();
  $weatherCount++;

  $style = '<style>' .
          '.yahoo-current-weather_' . $weatherCount . ' {
              width: 347px;';  
  if ($_SESSION['isDaytime']) {
        $style = $style .               
              'background: url("http://l.yimg.com/a/i/us/nws/weather/crntcondbg_day.gif") repeat-x scroll 0 0 #CCE1FF;';
  } else {
    $style = $style . 
            'background: url("http://l.yimg.com/a/i/us/nws/weather/crntcondbg_night.gif") repeat-x scroll 0 0 #CCE1FF;';
  }  
  $style = $style .
            'height: 155px;
            font-size: 13px;
            color: #000000; 
            font-family: arial;
            overflow: hidden;
            max-height: 180px;
            padding-bottom: 0px;';
  if ($_SESSION['isDaytime']) {
    $style = $style . 
          'border-color: #5182CE -moz-use-text-color;';
  } else {
    $style = $style . 
          'border-color: #8E8E8E -moz-use-text-color;';
  }  
  $style .= 'border-style: solid none;
            border-width: 1px medium;
           }' .
          '' .
          '.current_date, .current_conditions {
              display: block;
              font-size: 11px;
              padding: 10px 0 5px 10px;
            }
            .current_text_condition {
              color: #000000;
              font-size: 16px;
              font-weight: bold;
              padding: 0px 0 5px 10px;
              position: relative;
              z-index: 2;
            }
            .current_conditions {
              float: left;
            }  
            ' ;
      $style = $style . 
              '.current_weather_info_' . $weatherCount . ' {
                  float: right;
                  top: 15px;
                  position: relative;
                  ' ;
      if ($_SESSION['isDaytime']) {
        $style = $style . 
              'background: url("http://l.yimg.com/a/i/us/nws/weather/wdgt_day.png") no-repeat scroll 0 0 transparent;';
      } else {
        $style = $style . 
              'background: url("http://l.yimg.com/a/i/us/nws/weather/wdgt_night.png") no-repeat scroll 0 0 transparent;';
      }      
      
      $style = $style .
                'min-height: 67px;
                min-width: 190px;  
                margin: 10px;
                width: 55%;
              }' .
              '' . 
              '.current_weather_info_' . $weatherCount . ' img {
                  position: relative;
                  top: -10px;
                  width: 75%;
                  float: left;
                }
                .weather_temp {
                  color: #FFFFFF;
                  float: right;
                  font-size: 30px;
                  font-weight: bold;
                  left: -7px;
                  position: relative;
                  text-shadow: 0 -1px 1px #315895;
                  top: 10px;
                }
                .current_high_low {
                  clear: both;
                  color: #FFFFFF;
                  float: right;
                  padding-right: 11px;
                  position: relative;
                  top: 35px;
                }
                .current-weather-icon {
                  float: right;
                  left: 16px;
                  position: relative;
                  top: -120px;
                }
              </style>';
      
      echo $style;
    ?>
   <div class="yahoo-current-weather_<?php global $weatherCount; echo $weatherCount;?>">    
    <div class="current_date"><?php echo $weather['condition']['date'];?></div>
    <div class="current_text_condition"><?php echo $weather['condition']['text'];?></div>
    <div class="current_conditions">
      <ul>
        <li style="list-style: disc outside none;"> Sunrise: <?php echo $weather['sunrise'] ?></li>
        <li style="list-style: disc outside none;"> Sunset: <?php echo $weather['sunset'] ?></li>
        <li style="list-style: disc outside none;"> Humidity: <?php echo $weather['humidity'] ?></li>
        <li style="list-style: disc outside none;"> Wind: <?php echo $weather['speed'] . ' ' . $weather['speed_unit'];  ?></li>
      </ul>        
    </div>
    <div class="current_weather_info_<?php global $weatherCount; echo $weatherCount; ?>">
        <div class="weather_temp">
          <?php echo $weather['temperature']; ?><br/>          
        </div>
        <div class="current_high_low"><span style="font-size: 10px;">High: <?php echo $weather['high'] . '&nbsp;&nbsp;&nbsp;Low: ' . $weather['low']; ?></span></div>  
    </div>
    <img alt="" src="<?php echo $weather['condition']['img_url'];?>" style="" class="current-weather-icon"/>
  </div>
  <?php
  
  
  return $contents;
}


/**
 *
 * @global string $yahooWeatherFileNameContents
 * @param type $param
 * @return type 
 */
function getYahooWeatherCategory($param) {
  global $yahooWeatherFileNameContents;
  
  $file = fopen($yahooWeatherFileNameContents, 'r');
  while (!feof($file)) {
    $str = fgets($file);    
    $value['start'] = strpos($str, $param);
    if ($value['start']) {         
      $value['str'] = $str;      
      break;
    }
  }  
  return $value['str'];  
}


function getCurrentYahooCondition() {
  global $yahooWeatherFileNameContents;  
  
  $file = fopen($yahooWeatherFileNameContents, 'r');
  while (!feof($file)) {
    $str = fgets($file);    
    $value['start'] = strpos($str, 'condition');
    if ($value['start']) {         
      $value['str'] = $str;      
      break;
    }
  }  
  $weather['text'] = extractConditionWeatherParam($str, 'text');
  $weather['code'] = extractConditionWeatherParam($str, 'code');
  $weather['temp'] = extractConditionWeatherParam($str, 'temp');
  $date = extractConditionWeatherParam($str, 'date');
  $weather['temp'] = $date;
  $_SESSION['isDaytime'] = isDaytime();  
  if ($_SESSION['isDaytime'])
    $weather['img_url'] = 'http://l.yimg.com/a/i/us/nws/weather/gr/' . $weather['code'] . 'd.png';
  else
    $weather['img_url'] = 'http://l.yimg.com/a/i/us/nws/weather/gr/' . $weather['code'] . 'n.png';
  return $weather;
  
}

/**
 *
 * @global string $yahooWeatherFileNameContents
 * @param type $param
 * @return type 
 */
function extractYahooWeatherParam($param) {
  global $yahooWeatherFileNameContents;
  
  $file = fopen($yahooWeatherFileNameContents, 'r');
  while (!feof($file)) {
    $str = fgets($file);
    
    $value['start'] = strpos($str, $param . '="');
    if ($value['start']) {         
      $value['str'] = $str;
      $compressed = substr($str, $value['start'] + strlen($param . '="'));  
      $value['end'] = strpos($compressed,'"');
      $value[$param] = substr($compressed, 0, $value['end']);
      break;
    }    
  }
  return $value[$param];
}


/**
 *
 * @global string $yahooWeatherFileNameContents
 * @param type $str
 * @param type $param
 * @return type 
 */
function extractConditionWeatherParam($str, $param) {
  global $yahooWeatherFileNameContents;
  
  $value['start'] = strpos($str, $param . '="');
  if ($value['start']) {         
    $value['str'] = $str;
    $compressed = substr($str, $value['start'] + strlen($param . '="'));  
    $value['end'] = strpos($compressed,'"');
    $value[$param] = substr($compressed, 0, $value['end']);    
  }
  return $value[$param];
}


/**
 *
 * @global string $yahooWeatherFileNameContents
 * @return type 
 */
function htmlYahooWeatherForecast() {
  global $yahooWeatherFileNameContents; 
  
  $file = fopen($yahooWeatherFileNameContents, 'r');
  while (!feof($file)) {
    $str = fgets($file);    
    $value['start'] = strpos($str, 'forecast');
    if ($value['start']) {
      $dayForecasts['day'][] = extractConditionWeatherParam($str, 'day');      
      $code= extractConditionWeatherParam($str, 'code');
      if (isDaytime())
        $dayForecasts['img_url'][] = '<img src="http://l.yimg.com/a/i/us/nws/weather/gr/' . $code .'d.png" alt="" width="60px" style="max-width: 60px;"/>';
      else
        $dayForecasts['img_url'][] = '<img src="http://l.yimg.com/a/i/us/nws/weather/gr/' . $code .'n.png" alt="" width="60px" style="max-width: 60px;"/>';
      $dayForecasts['text'][] = extractConditionWeatherParam($str, 'text');
      $dayForecasts['high'][] = extractConditionWeatherParam($str, 'high') . '°';
      $dayForecasts['low'][] = extractConditionWeatherParam($str, 'low') . '°';
    }
  }  
  $countAssoc = count($dayForecasts);
  $countDays = count($dayForecasts['day']);      
  ?>
  
  <style>
    .days-forecasts_<?php global $weatherCount; echo $weatherCount;?> {
      width: 347px;
      font: 13px arial,helvetica,clean,sans-serif;
    }
    .days-forecasts_<?php global $weatherCount; echo $weatherCount;?> table {
      border-bottom: 1px solid #DDDDDD;
      margin: 5px 0px;
      border-left: 1px solid #ccc; 
      background: #fff;
      font-size: 13px;
    }
    .days-forecasts_<?php global $weatherCount; echo $weatherCount;?> td {
       border-top: none;
       text-align: center;
       border-right: 1px solid #ccc;       
       padding: 0 2px;
    }
    .days-forecasts_<?php global $weatherCount; echo $weatherCount;?> td.forecast-day {
      <?php
        global $weatherCount;
        if ($_SESSION['isDaytime']) {
          ?>
          background: url("http://l.yimg.com/a/i/us/nws/weather/frcstbg_day.gif") repeat-x scroll right top #5F90D9;      
          <?php
        } else {
          ?>
          background: url("http://l.yimg.com/a/i/us/nws/weather/frcstbg_night.gif") repeat-x scroll right top #50485D;           
          <?php
        }
      ?>
      
      margin: 2px;   
      text-transform: uppercase;
      color: #fff;   
      font-size: 12px;
    }
    .days-forecasts_<?php global $weatherCount; echo $weatherCount;?> img {
      left: 10px;
      position: relative;         
      top: 10px;
    }
    .forecast-text {
      font-size: 12px;
      font-weight: bold;
    }
    .forecast-high {
      font-size: 11px;
      font-weight: bold;
    }
    .forecast-low {
      font-size: 11px;      
    }
  </style>
    <div class="days-forecasts_<?php global $weatherCount; echo $weatherCount;?>">
      <table>
  <?php
  $assoc = 0;
  while ($assoc < $countAssoc) {
    ?>
        <tr>
          <?php
            $i = 0;
            while ($i < $countDays) {
              switch ($assoc) {
                case 0:
                  ?>
                    <td class="forecast-day">
                      <?php 
                        if ($i == 0)
                          echo 'today';
                        else
                          echo $dayForecasts['day'][$i];
                      ?>
                    </td>
                  <?php
                  break;
                case 1:
                  ?>
                    <td><?php echo $dayForecasts['img_url'][$i];?></td>
                  <?php
                  break;
                case 2:
                  ?>
                    <td class="forecast-text"><?php echo $dayForecasts['text'][$i];?></td>
                  <?php
                  break;
                case 3:
                  ?>
                    <td class="forecast-high"> High: <?php echo $dayForecasts['high'][$i];?></td>
                  <?php
                  break;
                case 4:
                  ?>
                    <td class="forecast-low"> Low: <?php echo $dayForecasts['low'][$i];?></td>
                  <?php
                  break;
                
                default:
                  break;
              }     
              $i++;
            }  
          ?>
        </tr>
    <?php    
    $assoc++;
  }
  ?>
      </table>    
    </div>
  <?php
  return $dayForecasts;
}
activateForecastWeather();

/**
 * Determine if it is daytime
 * @return type boolean
 */  
function isDaytime() {
  global $timeBuild;
  global $sunrise;
  global $sunset;
  
  $timeBuild = $_SESSION['timeBuild'];
  $sunrise = $_SESSION['sunrise'];
  $sunset = $_SESSION['sunset'];
  
  $pos = strrpos($timeBuild, 'am');
  if ($pos <= 0)
    $pos = strrpos($timeBuild, 'pm');
  $timeBuildLen = strlen($timeBuild);  
  $timeBuild = substr($timeBuild, 0, $pos+2);
  
  $str = $timeBuild;
  $timeBuild = strtotime($str);
  $timeBuild = date('H:i ', $timeBuild);
  
  $str = $sunrise;
  $timeSunrise = strtotime($str);
  $timeSunrise = date('H:i ', $timeSunrise);  
  
  $str = $sunset;
  $timeSunset = strtotime($str);  
  $timeSunset = date('H:i ', $timeSunset);  
    
  if ($timeBuild >= $timeSunrise && $timeBuild < $timeSunset)
    return true;  
  else
    return false;

  
}


function getGeoDetails($location) {  
  $url = "http://where.yahooapis.com/geocode?q=" . urlencode(trim($location)) . "&appid=9Bcly4jV34EPDzBrDvdEGgznbwEXpVPCRieCmTSc4KYkmbzOMKSyVpgTAwTOTD6mWYhBFBgP";      
  $contents = file_get_contents($url);      
  $pattern = '/woeid.*woeid/';
  $contents = preg_match_all($pattern, $contents, $matches, PREG_PATTERN_ORDER);
  $contents = $matches[ 0];
  $contents = str_replace('woeid>', '', $contents);
  $contents = str_replace('</woeid', '', $contents);    
  $woeid = $contents[0];  
  $value['woeid'] = $woeid;
  
  $contents = file_get_contents($url);      
  $pattern = '/uzip.*uzip/';
  $contents = preg_match_all($pattern, $contents, $matches, PREG_PATTERN_ORDER);
  $contents = $matches[ 0];
  $contents = str_replace('uzip>', '', $contents);
  $contents = str_replace('</uzip', '', $contents);    
  $zipcode = $contents[0];  
  $value['zipcode'] = $zipcode;  
  return $value;
}


function displayTitle($location, $URI) {
  global $timeBuild;
  $contents = file_get_contents($URI);
  $objDOM = new DOMDocument();
  $objDOM->loadXML($contents);
  $date = $objDOM->getElementsByTagName("lastBuildDate")->item(0)->nodeValue;
  unset($_SESSION['timeBuild']);
  $timeBuild = $date;
  $_SESSION['timeBuild'] = $timeBuild;  
  $currentTime = '<br/><span style="color: #CCC; font-size: 10px; color: #766565; font-variant: normal; left: 10px; position: relative;">( ' . $date . ' )</span>';
  echo '<h3 class="widget-title">' . $location . $currentTime . '</h3>';  
}



?>