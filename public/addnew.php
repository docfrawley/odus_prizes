<?php include_once("../includes/oopsinitialize.php");
$candidates = new the_candidates('all');
	if(isset($_POST['submit'])) { 
		$candidates->add_candidate($_POST, $_FILES); 
	}
	$whatshow="ADD NEW CANDIDATE";	
	include_once("../includes/layouts/header.php");


if (isset($_SESSION["casnetid"]) && ($_SESSION['level']=='admin' || $_SESSION['level']=='dsl')) {
	?><div class="grid-9 addform"><?
	$candidates->new_user_form();
	  
	?></div></div><?
	
	
	
} //   (isset($_SESSION["casnetid"]) && $_SESSION['level']=='admin')
include("../includes/layouts/footer.php"); 
?>