<?php

    if (isset ($_POST['log'])) {
        update_option('log', $_POST['log']);
    }
//$GLOBALS['objLoginViewer']->postLoggedIn();
?>
<div class="wrap">
    <form method="post" action="">
        <input type="text" name="log" value="<?php echo get_option('log'); ?>">
        <p class="submit">
            <input type="submit" value="<?php _e('Save Changes'); ?>">

        </p>
    </form>

</div>
<?php
    global $table_prefix;
//    echo $table_prefix;
?>
