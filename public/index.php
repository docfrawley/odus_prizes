<?php include_once("../includes/oopsinitialize.php");
include_once("../includes/oopslogin.php"); 
$award=isset($_GET['award']) ? $_GET['award'] : "" ;
	if (!$award) $award=isset($_POST['award']) ? $_POST['award'] : "all" ;
	
switch ($award) {
	case "dodds":
		$whatshow= "Dodds Award";
		break;
	case "douglass":
		$whatshow= "Douglass Award";
		break;
	case "dulles":
		$whatshow= "Dulles Award";
		break;
	case "all":
		$whatshow= "ALL CANDIDATES";
		break;	
	case "edidel":
		$whatshow= "EDIT CANDIDATES";
		break;	
	case "resurrect":
		$whatshow= "DELETED CANDIDATES";
		break;
}

include_once("../includes/layouts/header.php");
if (isset($_SESSION["casnetid"])) {

if ($award =='edidel' && $_SESSION["level"]=='dsl') {$candidates = new the_candidates('dsl'); }
 else {$candidates = new the_candidates($award);}

?><div class="row">
      <div class="large-12 columns">
          <ul class="large-block-grid-4 medium-block-grid-3 small-block-grid-2"><?
			$candidates->list_candidates(); ?>
          </ul>
       </div><!-- end large-9 -->
  </div>
<?
} //   isset $_SESSION['casenetid']
include("../includes/layouts/footer.php"); 
?>