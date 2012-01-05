<?php
include_once 'map-utils.php';

if(isset ($_POST['save'])) {    
    var_dump($_POST);
    $locationValue = $_POST['location'];
    $locationNumber = $_POST['hidden_location_number'];
    $locationOptionName = $locationNumber . 'cat_' . $_POST['category'];    
    if (!get_option($locationOptionName)) {
        add_option($locationOptionName, $locationValue);
    }        
}

$categories = array('a',  'b', 'c');
$locations = getAllLocations();
var_dump($locations);
$locationsThisCat = getLocationsByCat('a');
var_dump($locationsThisCat);
$last = count($locations);
$last++;
?>
<?php
    $locationOptionName = 'location_' . $last . '_';
?>
<div class="wrap">
  <h2>Dynamic Map Marker Input Options</h2>
  <div>
    <form method="post">
<!--      <input type="text" name="sample_input" value="<?php echo get_option('sample_input'); ?>"/>-->
        <input type="text" name="location" value=""/>
        <input type="text" name="hidden_location_number" value="<?php echo $locationOptionName; ?>"/>
        <select name="category">
            <?php
            foreach ($categories as $value) {
                ?>
                <option value="<?php echo $value?>"><?php echo $value; ?></option>
                <?php
            }
            ?>
            
        </select>
      <input type="submit" value="Save" name="save"/>
    </form>
  </div>
</div>


