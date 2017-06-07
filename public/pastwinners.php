<?php include_once("../includes/oopsinitialize.php");
include_once("../includes/layouts/header.php");
if (isset($_SESSION["casnetid"])) {

	include("../includes/layouts/menu.php");   
	
	
} //   (isset($_SESSION["casnetid"]))
include("../includes/layouts/footer.php"); 
?>