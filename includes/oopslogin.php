<?php session_start(); ?>
<?php //include_once('../public/CAS.php');

//phpCAS::client(CAS_VERSION_2_0,'fed.princeton.edu',443,'cas','false');
//phpCAS::setNoCasServerValidation();
//phpCAS::forceAuthentication();

//$casnetid = phpCAS::getUser();
$casnetid = 'mfrawley';
									
$sql = "SELECT * FROM userlist WHERE netid = '".$casnetid."'";
$result_set = $database->query($sql);
$found_user = $database->fetch_array($result_set);


if(!isset($found_user['netid']))
{
        include_once('unauth.php');
        exit();
        
} else {
	$_SESSION['casnetid'] = $casnetid;
	$_SESSION['fullname'] = 'Matt Frawley';
	$_SESSION['level'] = $found_user['level'];
	$_SESSION['college'] = $found_user['college'];
}

?>