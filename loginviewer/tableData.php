<?php
$objLoginViewer = new LoginViewer();
$loginLogs = $objLoginViewer->selectAll();
?>
<style type="text/css">
.loginViewer-logs {
    border: 1px solid #DFDFDF;
    width: 100%;    
}
.loginViewer-logs thead,#loginViewer-logs th  {
    background: #ddd6d6;
    font-weight: bold;
}
.loginViewer-logs #odd {
    background: #fcf1f1;
}
.loginViewer-logs #even {
    background: #fff;
}
.loginViewer-logs td,
.loginViewer-logs td {
    width: 200px;
    text-align: left;
}
#login-dataTitle {    
    color: #21759B;
    text-align: left;
}
#loginlogs-data {
    max-height: 400px;
    overflow: scroll;
}

</style>
<table class="loginViewer-logs" cellspacing="0" cellpadding="2">
    <thead id="login-dataTitle">
        <td>Login Name</td>
        <td>Email</td>
        <td>Role</td>
        <td>Name</td>
        <td>Login Time</td>
        <td>Logout Time</td>
    </thead>
</table>
<div id="loginlogs-data">
<table class="loginViewer-logs">
    <tbody>
        <?php
            $row = 0;
            if (isset ($loginLogs) && count($loginLogs))
            foreach ($loginLogs as $loginLog) {
                $row++;
        ?>
            <?php
                if ($row % 2 == 1) {
            ?>
                    <tr id="odd">
                        <td><?php echo $loginLog->user_login; ?></td>
                        <td><?php echo $loginLog->user_email; ?></td>
                        <td><?php echo $loginLog->role; ?></td>
                        <td><?php echo $loginLog->user_display_name; ?></td>
                        <td><?php
                            if ($loginLog->login_time != '0000-00-00 00:00:00')
                                echo date("m/d/Y g:i:s A",strtotime($loginLog->login_time)) ;
                            else
                                echo $loginLog->login_time;
                            ?>
                        </td>
                        <td><?php

                            if ($loginLog->logout_time != '0000-00-00 00:00:00')
                                echo date("m/d/Y g:i:s A",strtotime($loginLog->logout_time)) ;
                            else
                                echo $loginLog->logout_time;
                            ?>
                        </td>
                    </tr>
            <?php
                } else {
            ?>
                    <tr id="even">
                        <td><?php echo $loginLog->user_login; ?></td>
                        <td><?php echo $loginLog->user_email; ?></td>
                        <td><?php echo $loginLog->role; ?></td>
                        <td><?php echo $loginLog->user_display_name; ?></td>
                        <td><?php
                            if ($loginLog->login_time != '0000-00-00 00:00:00')
                                echo date("m/d/Y g:i:s A",strtotime($loginLog->login_time)) ;
                            else
                                echo $loginLog->login_time;
                            ?>
                        </td>
                        <td><?php

                            if ($loginLog->logout_time != '0000-00-00 00:00:00')
                                echo date("m/d/Y g:i:s A",strtotime($loginLog->logout_time)) ;
                            else
                                echo $loginLog->logout_time;
                            ?>
                        </td>

                    </tr>
        <?php
                }
        }
        ?>
    </tbody>
</table>
</div>