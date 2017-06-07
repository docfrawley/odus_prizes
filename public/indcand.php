<?php include_once("../includes/oopsinitialize.php");

$numindex=isset($_GET['numindex']) ? $_GET['numindex'] : "" ;
	if (!$numindex) $numindex=isset($_POST['numindex']) ? $_POST['numindex'] : "" ;	
$the_candidate = new candidate($numindex);

$candidate=isset($_GET['candidate']) ? $_GET['candidate'] : "" ;
	if (!$candidate) $candidate=isset($_POST['candidate']) ? $_POST['candidate'] : "" ;	
	
if($candidate) { 
	if ($candidate=='edpic') {$the_candidate->update_pic($_FILES); }
	else if ($candidate=='deletecand') {$the_candidate->not_show(); }
	else {$the_candidate->ed_candidate($_POST); }
}
	
$whatshow = $the_candidate->get_name();
include_once("../includes/layouts/header.php");



if (isset($_SESSION["casnetid"])) {

$task=isset($_GET['task']) ? $_GET['task'] : "" ;
	if (!$task) $task=isset($_POST['task']) ? $_POST['task'] : "" ;		
$edcom=isset($_GET['edcom']) ? $_GET['edcom'] : "" ;
	if (!$edcom) $edcom=isset($_POST['edcom']) ? $_POST['edcom'] : "" ;		


$comments = new comments($numindex);
$certificates = new certificates($numindex);	
	

if(isset($_POST['certificate'])) { 
	if ($_POST['certificate']=='deletecerts') { $certificates->delete_cert($_POST); }
	else {$certificates->add_cert($_POST['certificate']); }
}



if(isset($_POST['comments'])) { 
	if ($_POST['comments']=='deletecom') 	{$comments->delete_comment($_POST);}
 	elseif ($_POST['comments']=='editcom') 	{
		$editcom = new indcom($_POST['comindex']);
		$editcom->edit_comment($_POST['edcomment']); 
		}
	else {$comments->add_comment($_POST); }	
}
?>
<div class="row">
	<div class="medium-4 large-3 columns">
			<?
				if ($task == 'edcand') {
					$the_candidate->edit_form();
					$the_candidate->change_pic();
				} else {
					?><div class="panel radius"><?
					if ($_SESSION['level'] == 'admin' || $_SESSION['college'] == $the_candidate->get_college()) {
						echo '<a href="?numindex='.$numindex.'&task=edcand" class="custom-button-class">EDIT/DELETE CANDIDATE</a>'; 
					}
					$the_candidate->show_info(); 
					?></div><?
				} 


					if ($_SESSION['level'] == 'admin' || $_SESSION['college'] == $the_candidate->get_college()) {
						if ($task == 'delcert' && $certificates->num_cert() > 0) { $certificates->cert_del_form();}
						else {
							?><div class="panel radius"><?
							if ($certificates->num_cert() > 0) {
								echo '<a href="?numindex='.$numindex.'&task=delcert" class="custom-button-class">DELETE CERTIFICATES</a>'; 
								 $certificates->show_cert(); 
							}?><br/> <?
							$certificates->cert_form();
							?></div><?
						}
					} ?> 	
</div>
	<div class="medium-8 large-9 columns"><?
		if ($task=='edcom') {
			$comments->show_comments(true);
		} else {
			?> <a class="custom-button-class" href="?numindex=<? echo $numindex; ?>&task=edcom">EDIT/DELETE COMMENTS</a><?
			$comments->show_comments(false);
			$comments->comment_form();
		} ?>	
	</div>
 </div><?
if ($edcom) {
	?>
	<div id="blanket" style="display:block"></div>
	<div id="oncalllogstuff2">
        <div class="goingout">
        <? echo ('<a class="button tiny radius" href="?numindex='.$numindex.'">CLOSE</a>'); ?>
        </div> <!-- <div id="goinout"> -->
	<div id="oncallposition">

<?
	$editcom = new indcom($edcom);
	$editcom->edit_form($numindex);
}
?>
</div> <!-- <div id="oncallposition"> -->
</div> <!-- <div id="oncallstuff"> -->
<?
	
} //   (isset($_SESSION["casnetid"]) && $_SESSION['level']=='admin')
include("../includes/layouts/footer.php"); 
?>