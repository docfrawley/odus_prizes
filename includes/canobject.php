<? include_once("oopsinitialize.php");

class candidate {
	
	private $name;
	private $fname;
	private $lname;
	private $college;
	private $gpa;
	private $major;
	private $dodds;
	private $dulles;
	private $douglass;
	private $pic_place;
	private $show_pic;
	private $certifcates;
	private $comments;
	
	function __construct($numindex) {
		global $database;
		$this->numindex = $numindex;
		$sql="SELECT * FROM candidates WHERE numindex = '".$numindex."'";
		$result_set = $database->query($sql);
		$resultrow = $database->fetch_array($result_set);
		$this->fname = $resultrow['fname'];
		$this->lname = $resultrow['lname'];
		$this->name = $resultrow['fname'].' '.$resultrow['lname'];
		$this->college = $resultrow['college'];
		$this->gpa = $resultrow['gpa'];
		$this->major = $resultrow['major'];
		$this->dodds = $resultrow['dodds'];
		$this->dulles = $resultrow['dulles'];
		$this->douglass = $resultrow['douglass'];
		$this->pic_place = $resultrow['picture'];
		$this->show_pic = $resultrow['showpic'];
		$this->certifcates = array();
		$this->comments = array();
	}
	
	function show_whichps() {
		if ($this->dodds) {echo 'Dodds ';}
		if ($this->dulles) {echo 'Dulles ';}
		if ($this->douglass) {echo 'Douglass';}
	}
	
	function get_name() {
		return $this->name;	
	}
	
	function get_college() {
		return $this->college;	
	}
	
	function get_gpa() {
		return $this->gpa;	
	}
	
	function get_numindex() {
		return $this->numindex;	
	}
	
	function pic_place() {
		return $this->pic_place;	
	}
	
	function show_pic($link=false) {
		if ($this->show_pic) {
			?><div class="custom-panel radius"><?
			if ($link) { echo "<a href='indcand.php?numindex={$this->numindex}'>";}
			
			echo $this->get_name().'</br/>';
			
			?>
			<img src="<? echo $this->pic_place(); ?>"/>
			<?
			if ($link) { echo '</a>';}
            ?> </div><?
		}
	}
	
	
	function show_info() {
		?><p><strong>CANDIDATE FOR:</strong></br/><?
		$this->show_whichps();
		?></p>
        <img src="<? echo $this->pic_place(); ?>"/>
        <table>
		<tr><td>College:</td><td><? echo $this->college; ?></td></tr>
		<tr><td>Major:</td><td><? echo $this->major; ?></td></tr>
        <tr><td>GPA: </td><td><? echo $this->gpa; ?></td></tr>
        </table>
		<?
	}
	
	function ed_candidate($info) {
		global $database;
		$this->fname = $database->escape_value($info['fname']) ;
		$this->lname = $database->escape_value($info['lname']);
		$this->name = $this->fname.' '.$this->lname;
		$this->college = $database->escape_value($info['college']) ;
		$this->gpa = $database->escape_value($info['gpa']);
		$this->major = $database->escape_value($info['major']);
		$this->dodds = isset($info['dodds']);
		$this->douglass = isset($info['douglass']);
		$this->dulles = isset($info['dulles']);
		$sql = "UPDATE candidates SET ";
		$sql .= "fname='". $this->fname ."', ";
		$sql .= "lname='". $this->lname ."', ";
		$sql .= "college='". $this->college ."', ";
		$sql .= "gpa='". $this->gpa ."', ";
		$sql .= "major='". $this->major ."', ";
		$sql .= "dodds='". $this->dodds."', ";
		$sql .= "dulles='". $this->dulles ."', ";
		$sql .= "douglass='". $this->douglass ."'";
		$sql .= " WHERE numindex='". $this->numindex ."'";
	  	$database->query($sql);
	}
	
	function update_pic($filestuff) {
		global $database;
		$tmp_file = $filestuff['file_upload']['tmp_name'];
		$target_file = basename($filestuff['file_upload']['name']);
		$upload_dir = "img";
		$the_place = $upload_dir."/".$target_file;
		unlink($this->pic_place);
		$this->pic_place = $the_place;
		if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)) {
			$message = "File uploaded successfully.";
		} else {
			$error = $_FILES['file_upload']['error'];
			$message = $upload_errors[$error];
		}
		$sql = "UPDATE candidates SET ";
		$sql .= "picture='". $the_place."'";
		$sql .= " WHERE numindex='". $this->numindex ."'";
	  	$database->query($sql);
	}
	
	function not_show() {
		global $database;
		$setpic = false;
		$sql = "UPDATE candidates SET ";
		$sql .= "showpic=0";
		$sql .= " WHERE numindex=". $this->numindex;
	  	$database->query($sql);
		redirect_to();
	}
	
	function change_pic() {
		?><table><form action="indcand.php" enctype="multipart/form-data" method="post">
        <tr><td>Upload New Picture:</td></tr>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<tr><td><input type="file" name="file_upload" /></td></tr>
        <form action="upload.php"  method="POST">     
        <input type="hidden" name="candidate" value="edpic"/> 
        <input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/> 
		<tr><td><input type="submit" name="submit" value="Upload" class="button radius small"/></td></tr>
		</form> 	</table>
        <?
	}
	
	function edit_form() {
		global $database;
		?> <div class="commentslink"><a href="?candidate=deletecand&numindex=<? echo $this->numindex; ?>">DELETE CANDIDATE FROM ALL PRIZES</a></div><br/>
        <img src="<? echo $this->pic_place(); ?>"/>
        <table><form action="indcand.php" method="post">
		<tr><td>First Name:</td><td> <input type="text" name="fname" value="<? echo $this->fname; ?>"/></td></tr>
        <tr><td>Last Name:</td><td>  <input type="text" name="lname" value="<? echo $this->lname; ?>"/></td></tr>
        <? if ($_SESSION['level'] == 'dsl') { 
				?> <input type="hidden" name="college" value="<? echo $_SESSION['college']; ?>"/>    <? 
			} else { ?>
                <td>COLLEGE:</td><td>  <select name="college">
                                <option selected="selected" value="<? echo $this->college; ?>"><? echo $this->college; ?></option>
                                <option value="Butler">Butler</option>
                                <option value="Forbes">Forbes</option>
                                <option value="Mathey">Mathey</option>
                                <option value="Rocky">Rocky</option>
                                <option value="Whitman">Whitman</option>
                                <option value="Wilson">Wilson</option>
                            </select>
                </td></tr> 
		<? } ?>
        <tr><td>GPA: </td><td><input type="text" name="gpa" value="<? echo $this->gpa; ?>"/></td></tr>
        <tr><td>Major: </td><td><input type="text" name="major" value="<? echo $this->major; ?>"/></td></tr>
        <tr><td>Dodds: <input type="checkbox" name="dodds" value="dodds" <? if ($this->dodds) {?> checked="checked"<? } ?>></td></tr>
        <tr><td>Dulles: <input type="checkbox" name="dulles" value="dulles" <? if ($this->dulles) {?> checked="checked"<? } ?>></td></tr>
        <tr><td>Douglass: <input type="checkbox" name="douglass" value="douglass" <? if ($this->douglass) {?> checked="checked"<? } ?>></td></tr>
        <input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/>  
        <input type="hidden" name="candidate" value="edcandidate"/>   
		<tr><td><input type="submit" name="submit" value="submit" class="button radius small"/></td></tr>
		</form> 	</table>
		<?
	}
}
?>