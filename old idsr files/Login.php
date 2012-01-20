<?php
error_reporting(E_ALL ^ E_NOTICE);
include('functions.php');
require_once('/connection/config.php');

$test = $_SESSION['id'];
if ($test != '') {
    header('Location: logout.php');
}

$username = $_POST['username'];
$password = $_POST['password'];

$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
?>

<html>
    <title>Login Page</title>
    <head></head>
    <body style="background-image: url('images/columns_blue.jpg'); background-repeat: repeat-x">
        <div>
            <p style="color: white; font-size: 30px">INTEGRATED DISEASE SURVEILLANCE AND RESPONSE</p>  
            <div>
                <div style="position: fixed; top: 400px; left: 600px; width: 300px">
                    <form name="form1" method="post">
                        <table>
                            <tr><td style="color: white"> Username: </td><td><input type="text" name="username" id="username"></td><td></td></tr>
                            <tr><td style="color: white"> Password: </td><td><input type="password" name="password" id="password"></td><td><input style="color: #440" type="submit" name="Login" value="Login"/></td></tr>
                        </table>
                    </form>
                </div>
                <div style="background-image: url('images/index.jpg'); position: fixed; top: 300px; left: 400px; width: 160px; height: 160px;""></div>
            </div>
        </div>

    </body>
</html>

<?php
if ($_REQUEST['Login']) {
    if ((strlen($username) < 1) || (strlen($username) > 32)) {
        ?>
        <div class="error">
        <?php
        echo "<strong>Login failed, Please enter Username</strong>";
        ?>
        </div>
            <?php
        } else if ((strlen($password) < 1) || (strlen($password) > 32)) {
            ?>
        <div class="error">
        <?php
        echo "<strong>Login failed, Please enter Password</strong>";
        ?>
        </div>
        <?php
    } else {
        $checkuser = "SELECT id,role,district_or_province FROM users WHERE username='$username' AND password=md5('$password') 
AND flag = 1";
 
        $result = mysql_query($checkuser) or die(mysql_error());

        $checkdistrict = "SELECT ID,name,comment FROM districts WHERE name = '$username'";
        $districtresult = mysql_query($checkdistrict) or die(mysql_error());
        while ($districtset = mysql_fetch_assoc($districtresult)) {
            $_SESSION['districtname'] = $districtset[name];
            $_SESSION['districtcomment'] = $districtset[comment];
            $_SESSION['districtid'] = $districtset[ID];
        }
        $count = mysql_num_rows($result);

        if ($result) {
            if ($count > 0) {
                $userrec = mysql_fetch_assoc($result);


                $_SESSION['id'] = $userrec['id']; //the userid
                $_SESSION['role'] = $userrec['role'];
                $_SESSION['accounttype'] = $userrec['accounttype'];
                $_SESSION['username'] = $username;
                $_SESSION['district_or_province'] = $userrec['district_or_province'];
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

                    if ($_SESSION['role'] == '3') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='add_district_weekly.php'";
                        echo '</script>';
                    } else if ($_SESSION['role'] == '5') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='admin/admin.php'";
                        echo '</script>';
                    } else if ($_SESSION['role'] == '4') {
                        echo '<script type="text/javascript">';
                        echo "window.location.href='submissionlist.php'";
                        echo '</script>';
                    } else {
                        //echo "Wait";
                        echo '<script type="text/javascript">';
                        echo "window.location.href='overall.php'";
                        echo '</script>';
                    }
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
                echo '<script type="text/javascript">';
                echo "window.location.href='wrong.php'";
                echo '</script>';
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

