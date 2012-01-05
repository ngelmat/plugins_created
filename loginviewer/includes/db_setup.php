<?php
//session_start();
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
class LoginViewer {

    
    var $table = 'loginlogged';
    var $user_login;
    var $user_email;



    function  __construct() {

    }

    
    function createDatabase () {
        global $table_prefix;
        global $wpdb;

        $this->dropDatabase();
        $query = "CREATE TABLE $table_prefix$this->table
                    (id BIGINT(20) NOT NULL AUTO_INCREMENT,
                    user_login VARCHAR(60) NOT NULL ,
                    user_email VARCHAR(100) NOT NULL ,
                    role VARCHAR(100) NOT NULL ,
                    user_display_name VARCHAR(250) NOT NULL ,
                    login_time DATETIME NOT NULL ,
                    logout_time DATETIME NOT NULL,
                    PRIMARY KEY (id)  );";

        dbDelta($query);

    }

    function dropDatabase() {        
        global $table_prefix;
        global $wpdb;

        $query = "DROP TABLE IF EXISTS $table_prefix$this->table; ";        
        dbDelta($query);
    }


    function postLoggedIn($user) {
        global $table_prefix;
        global $wpdb;
        
        $currentUser = $user;
        date_default_timezone_set('EST');
        $dateTimeStarted = date(' Y:m:d H:i:s A ');        

        if (isset ($currentUser)) {
            if (isset ($currentUser->user_login))
                $postUser['user_login'] = $currentUser->user_login;
            if (isset ($currentUser->user_email))
                $postUser['user_email'] = $currentUser->user_email;
            if (isset ($currentUser->display_name))
                $postUser['display_name'] = $currentUser->display_name;
            if (isset ($currentUser->roles[0]))
                $postUser['role'] = $currentUser->roles[0];
            $postUser['login_time'] = $dateTimeStarted;


        }
        $countUserField = count($postUser);                
        if ($countUserField == 5) {

            $query = "INSERT INTO $table_prefix$this->table
                                (
                                 user_login,
                                 user_email,
                                 role,
                                 user_display_name,
                                 login_time)
                    VALUES (
                            '" . $postUser['user_login'] . "',
                            '" . $postUser['user_email'] . "',
                            '" . $postUser['role'] . "',
                            '" . $postUser['display_name'] . "',
                            '" . $postUser['login_time'] . "')";
            
            $wpdb->query($query);
        }

    }

    function postLoggedOut() {
        global $table_prefix;
        global $wpdb;
        
        $currentUser = wp_get_current_user();        
        if (isset ($currentUser)) {
            if (isset ($currentUser->user_login))
                $postUser['user_login'] = $currentUser->user_login;
        }
        date_default_timezone_set('EST');
        $dateTimeEnded = date(' Y:m:d H:i:s A ');
        $postUser['logout_time'] = $dateTimeEnded;
        
        
        $loggedId = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $table_prefix$this->table WHERE user_login = %s ORDER BY id DESC LIMIT 1" , $postUser['user_login']));


        $query = "UPDATE $table_prefix$this->table
                    SET logout_time = '" . $postUser['logout_time'] . "'
                    WHERE id = $loggedId ;";
        $wpdb->query($query);
        
    }


    function selectAll () {
        global $table_prefix;
        global $wpdb;

        $query = "SELECT
                      user_login,
                      user_email,
                      role,
                      user_display_name,
                      login_time,
                      logout_time
                    FROM $table_prefix$this->table
                    ORDER BY id desc;";
        $result = $wpdb->get_results($query);
        $tableName = $table_prefix . $this->table;
        if($wpdb->get_var("show tables like '$tableName'") != $tableName) {
            $this->createDatabase();
        }
        
        return $result;
    }


   
}
?>