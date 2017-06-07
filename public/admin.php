<?php include_once("../includes/oopsinitialize.php");

$edtask=isset($_GET['edtask']) ? $_GET['edtask'] : "" ;
	if (!$edtask) $edtask=isset($_POST['edtask']) ? $_POST['edtask'] : "" ;	
if ($edtask) {
	$numindex=isset($_GET['numindex']) ? $_GET['numindex'] : "" ;
		if (!$numindex) $numindex=isset($_POST['numindex']) ? $_POST['numindex'] : "" ;	
		$edituser = new userobject($numindex);
	if ($edtask!='show') {$edituser->update_user($_POST);}
}

$whatshow="ADMIN PAGE";
include_once("../includes/layouts/header.php");
if (isset($_SESSION["casnetid"]) && $_SESSION['level']=='admin') {
?>
<div class="row">
    <div class="medium-6 columns"><?
        $userlist = new adminobject($_SESSION['casenetid']);

        $task=isset($_GET['task']) ? $_GET['task'] : "" ;
        if (!$task) $task=isset($_POST['task']) ? $_POST['task'] : "" ;	


        if ($edtask=='show') {$edituser->edit_form();} 

        switch ($task) {
            case '':
                break;
            case 'adduser':
                $userlist->insert_user($_POST);
                break;
            case 'edituser':
                $userlist->edit_user($_POST);
                break;
        	case 'deleteusers':
                $userlist->delete_users($_POST);
                break;	
        }
        $userlist->delete_form();
        ?> 
    </div>
    <div class="medium-6 columns">
        <?
        $userlist->new_user_form();
        ?> 
    </div>
</div>  <?
} //   (isset($_SESSION["casnetid"]) && $_SESSION['level']=='admin')
include("../includes/layouts/footer.php"); 
?>