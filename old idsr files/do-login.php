<?php
error_reporting(0);
require_once('/connection/config.php');
include('/functions.php');

$username = $_POST['username'];
$password = $_POST['password'];
//$email = $_POST['email'];
// To protect MySQL injection
$username = stripslashes($username); //Un-quotes a quoted string.
$password = stripslashes($password);
$username = mysql_real_escape_string($username); //Escapes special characters in a string for use in an SQL statement
$password = mysql_real_escape_string($password);
?>
<?php
if ($_POST['action'] == 'user_login') {
    if ((strlen($username) < 1) || (strlen($username) > 32)) {
  
        echo '<div id="notification_error">Please Enter a Username.</div>';

    } else if ((strlen($password) <= 1) || (strlen($password) > 32)) {

			echo '<div id="notification_error">Something is wrong with your password</div>';
    } else {
        //$password = md5($password); //encrypt the password
        $checkuser = "SELECT surname,oname,id,role FROM users WHERE username='$username' AND password=md5('$password') AND flag = 1";
        $result = mysql_query($checkuser) or die(mysql_error());
        $count = mysql_num_rows($result);

        if ($result) {
            if ($count > 0) {
                $userrec = mysql_fetch_assoc($result);

                $_SESSION['id'] = $userrec['id']; //the userid
                $_SESSION['role'] = $userrec['role'];
$_SESSION['name'] = $userrec['oname']." ".$userrec['surname'];
                $_SESSION['accounttype'] = $userrec['accounttype'];
                session_write_close();

                //save the log in time
                $sessionuserid = $_SESSION['id'];
                $sessionuserrole = $_SESSION['role'];
                $sessionaccounttype = $_SESSION['accounttype'];
                $logindate = date('Y-m-d');
                $logintime = date("h:i:s A");

                $savelog = "INSERT INTO loghistory(user,logindate,logintime)VALUES('$sessionuserid','$logindate','$logintime')";
                $loghist = @mysql_query($savelog) or die(mysql_error());


                if ($loghist) {
                    //////////////////////////////////////////////////////////////////////////////////////
                    if ($_SESSION['role'] == '3') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='dashboard.php'";
                        echo '</script>';
                    } else if ($_SESSION['role'] == '5') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='admin/admin.php'";
                        echo '</script>';
                    } else if ($_SESSION['role'] == '4') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='NationalTimeliness.php'";
                        echo '</script>';
                    } else if ($_SESSION['role'] == '7') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='ReadOnly.php'";
                        echo '</script>';
                    } else {
                        //echo "Wait";
                        echo '<script type="text/javascript">';
                        echo "window.location.href='overall.php'";
                        echo '</script>';
                    }
                    echo 'OK';
                } else {
                    ?>
                    <div class="error">
                    <?php
                    echo "<strong>Unable to save Details. Please try again.</strong><br/>";
                    ?>
                    </div>
                    <?php
                }
            } else {
                ?>
                <?php
                $auth_error3 = '<div id="notification_error">You entered a wrong Username or Password.</div>';
                ?>
                <?php
            }
        } else {
            die("Query failed");
        }
        session_write_close();
    }
}
?>
        

