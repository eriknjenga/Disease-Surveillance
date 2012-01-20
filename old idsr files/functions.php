<?php
require('/connection/config.php');

//get the user info
//save district details
function Savedistrict($name,$province,$comment)
{
$savedistrict = "INSERT INTO
districts(name,province,comment,flag)VALUES('$name','$province','$comment',1)";
			$districts = @mysql_query($savedistrict) or die(mysql_error());
	return $districts;

}
// the patient information
function GetUserInfo($sessionuserid)
{
	$user = "SELECT * FROM users WHERE id = '$sessionuserid'";
	$user = mysql_query($user) or die(mysql_error());
	$userrec = mysql_fetch_array($user);
	return $userrec;
}
function GetDistrictInfo($sessionaccounttype)
{
	$d = "SELECT * FROM districts WHERE id = '$sessionaccounttype'";
	$di = mysql_query($d) or die(mysql_error());
	$drec = mysql_fetch_array($di);
	return $drec;
}
//get province id
function GetProvid($distid)
{
$districtnamequery=mysql_query("SELECT province
            FROM districts
            WHERE  ID='$distid'");
			$districtname = mysql_fetch_array($districtnamequery);
			$provid=$districtname['province'];
			return $provid;
}
//get province name
function GetProvname($provid)
{
$provincenamequery=mysql_query("SELECT name
            FROM provinces
            WHERE  ID='$provid'");
			$provincename = mysql_fetch_array($provincenamequery);
			$provname=$provincename['name'];
			return $provname;
			}

// the session details
function GetSessionInfo($sessionuserid)
{
	//get the session id from log history
	$checksessionid = "SELECT MAX(sessionid) AS maxsession FROM loghistory WHERE user='$sessionuserid'";
	$sessionresult = mysql_query($checksessionid) or die(mysql_error());
	$sessionrec = mysql_fetch_assoc($sessionresult);

	return $sessionrec;
}
// the facility information
function GetFacilityInfo($facility)
{
	$f = "SELECT * FROM facilitys WHERE id = '$facility'";
	$result = mysql_query($f) or die(mysql_error());
	$frec = mysql_fetch_array($result);
	return $frec;
}

//get facility name
function GetFacility($autocode)
{
$facilityquery=mysql_query("SELECT name FROM facilitys where ID='$autocode' ")or die(mysql_error());
$dd=mysql_fetch_array($facilityquery);
$fname=$dd['name'];
return $fname;
}
//get total distrcts
function GetTotalDistricts()
{
$query = "SELECT ID  FROM districts where flag=1";
$result = mysql_query($query) or die(mysql_error());
$numrows = mysql_num_rows($result);
return $numrows;
}

function GetLastEpiweek($currentyear)
{

$query = "SELECT MAX(epiweek)AS epiweek FROM surveillance where YEAR(datecreated)='$currentyear'";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$lastepiweek = $row['epiweek'];
return $lastepiweek ;
}

function GetDistrictSubmitted($district,$epiweek)
{
$query = "SELECT submitted FROM surveillance where epiweek='$epiweek' AND district='$district' limit 0,1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$num_submitted = $row['submitted'];
return $num_submitted;

}

function GetDistrictExpected($district,$epiweek)
{
$query = "SELECT expected FROM surveillance where epiweek='$epiweek' AND district='$district' limit 0,1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$num_submitted = $row['expected'];
return $num_submitted;
}
// the community information
function GetCommunityInfo($community)
{
	$f = "SELECT * FROM communitys WHERE id = '$community'";
	$result = mysql_query($f) or die(mysql_error());
	$frec = mysql_fetch_array($result);
	return $frec;
}
//get id of last saved community unit
function GetLastCommunityUnit()
{
	$getcommunityid = "SELECT MAX(id) as communityid
            FROM communitys
			 ";
			$getid=mysql_query($getcommunityid);
			$communityrec=mysql_fetch_array($getid);
			$communityid=$communityrec['communityid'];
			return $communityid;
}


//get indicator value for community unit
function getindicatortargets($indicator,$comunity)
{
$getrecord=mysql_query("select baseline,target  from communityplan where community='$comunity' AND indicator='$indicator'")or die(mysql_error());
$getindicator=mysql_fetch_array($getrecord);
$indicatorvalue=$getindicator['target'];
return $indicatorvalue;
}

//get total targets  for community unit
function getcommunitytotaltargets($comunity)
{
$getrecord=mysql_query("select SUM(target) AS 'community_totals'  from communityplan where community='$comunity'")or die(mysql_error());
$getindicator=mysql_fetch_array($getrecord);
$communitytotals=$getindicator['community_totals'];
return $communitytotals;

}

//get total indicator values  for community unit
function getindicatortotals($indicator,$district)
{
$getrecord=mysql_query("select SUM(communityplan.target) AS 'indicator_totals'  from communityplan,facilitys  where communityplan.facility=facilitys.ID AND facilitys.district='$district' AND communityplan.indicator='$indicator'")or die(mysql_error());
$getindicator=mysql_fetch_array($getrecord);
$indicatortotals=$getindicator['indicator_totals'];
return $indicatortotals;

}

//get month names from ID
function GetMonthName($month)
{
 if ($month==1)
 {
     $monthname=" Jan ";
 }
else if ($month==2)
 {
     $monthname=" Feb ";
 }else if ($month==3)
 {
     $monthname=" Mar ";
 }else if ($month==4)
 {
     $monthname=" Apr ";
 }else if ($month==5)
 {
     $monthname=" May ";
 }else if ($month==6)
 {
     $monthname=" Jun ";
 }else if ($month==7)
 {
     $monthname=" Jul ";
 }else if ($month==8)
 {
     $monthname=" Aug ";
 }else if ($month==9)
 {
     $monthname=" Sep ";
 }else if ($month==10)
 {
     $monthname=" Oct ";
 }else if ($month==11)
 {
     $monthname=" Nov ";
 }
  else if ($month==12)
 {
     $monthname=" Dec ";
 }
  else if ($month==13)
 {
     $monthname=" Jan - Sep  ";
 }
return $monthname;
}

//get total users
function GetTotalUsers()
{
$query = "SELECT ID  FROM users where flag=1";
$result = mysql_query($query) or die(mysql_error());
$numrows = mysql_num_rows($result);
return $numrows;
}
//get account type name
function GetAccountType($account)
{
$userquery=mysql_query("SELECT name FROM level where id='$account' ")or die(mysql_error());
$dd=mysql_fetch_array($userquery);
$grupname=$dd['name'];
return $grupname;
}
//save facility details
function Savefacility($code,$name,$district,$lab,$postal,$telephone,$otelephone,$fax,$email,$fullname,$contacttelephone,$ocontacttelephone,$contactemail)
{
$saved = "INSERT INTO
facilitys(facilitycode,name,district)VALUES('$code','$name','$district')";
			$users = @mysql_query($saved) or die(mysql_error());
	return $users;

}
//get total facilities
function GetTotalFacilities()
{
$query = "SELECT ID  FROM facilitys where Flag=1";
$result = mysql_query($query) or die(mysql_error());
$numrows = mysql_num_rows($result);
return $numrows;
}
?>