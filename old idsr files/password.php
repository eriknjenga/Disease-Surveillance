<?php	//Start session
session_start();
include("connection/config.php");
$userid=$_SESSION['id'] ;


//Check whether the clients session variable  is present or not
	if(!isset($_SESSION['id']) || (trim($_SESSION['id']) == '')) {
		header("location: wrong.php");
		
	}
	
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$cpassword = clean($_POST['cpassword']);
	$newpassword = clean($_POST['password']);
	$confirm = clean($_POST['confirm']);
		
	


	//Check for duplicate login ID
	if($cpassword != '')
	 {    
	    $pass=md5($cpassword);
		$qry = "SELECT * FROM users WHERE password='$pass' AND id='$userid'";
		$result = mysql_query($qry);
		$j=mysql_fetch_array($result);
		$name=$j['surname'];
		$username=$j['username'];
		$email=$j['email'];
		if($result) 
		{
			if(mysql_num_rows($result) == 0)
			 {
				$errmsg_arr[] = 'Wrong current password, reenter';
				$errflag = true;
			}
			@mysql_free_result($result);
		}
		else
		{
			die("Query failed to execute");
		}
	}
	
	//If there are input validations, redirect back to the registration form

	$new=md5($newpassword);
  $sql =("UPDATE users SET password='$new' WHERE id='$userid'");
  	
	$result = @mysql_query($sql);
	
	//Check whether the query was successful or not
if($result )
{

$st=" Password Successfully Changed ";
		header("location: districts_submission_list.php");
                
		
}
else {
		die("Query failed");
	}
?>