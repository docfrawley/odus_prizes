<? include_once("oopsinitialize.php");

class the_candidates {
	
	private $canlist;
	
	function __construct($award) {
		global $database;		
		$this->canlist = array();
		$resurrect = false;
		switch ($award) {
			case 'edidel':
			case 'all' :
				$sql="SELECT * FROM candidates ORDER BY lname";
				break;
			case 'resurrect' :
				$sql="SELECT * FROM candidates WHERE showpic=false ORDER BY lname";
				break;	
			case 'dodds' :
				$sql="SELECT * FROM candidates WHERE dodds=true ORDER BY lname";
				break;
			case 'douglass' :
				$sql="SELECT * FROM candidates WHERE douglass=true ORDER BY lname";
				break;
			case 'dulles' :
				$sql="SELECT * FROM candidates WHERE dulles=true ORDER BY lname";
				break;
			case 'dsl' :
				$sql="SELECT * FROM candidates WHERE college = '".$_SESSION['college']."' ORDER BY lname";
				break;
		}
		$result_set = $database->query($sql);
		while ($resultrow = $database->fetch_array($result_set)) {
			$cand = $resultrow['numindex'];
			array_push($this->canlist, $cand);
		}
	}
	
	function list_candidates($award) {
		foreach ($this->canlist as $candidate) {
			$the_candidate = new candidate($candidate);
			?> <li> <? $the_candidate->show_pic(true); ?> </li> <? 
		}
	}

	function add_candidate($poststuff, $filestuff) {
		global $database;
		// process the form data
		$tmp_file = $filestuff['file_upload']['tmp_name'];
		$target_file = basename($filestuff['file_upload']['name']);
		$upload_dir = "img";
		$the_place = $upload_dir."/".$target_file;
		if(move_uploaded_file($tmp_file, $upload_dir."/".$target_file)) {
			$message = "File uploaded successfully.";
		} else {
			$error = $_FILES['file_upload']['error'];
			$message = $upload_errors[$error];
		}
		$show = true;
		$dodds = isset($poststuff['dodds']);
		$douglass = isset($poststuff['douglass']);
		$dulles = isset($poststuff['dulles']);
		$sql = "INSERT INTO candidates (";
		$sql .= "fname, lname, college, gpa, major, dodds, douglass, dulles, picture, showpic";
 		$sql .= ") VALUES ('";
		$sql .= $database->escape_value($poststuff['fname']) ."', '";
		$sql .= $database->escape_value($poststuff['lname']) ."', '";
		$sql .= $database->escape_value($poststuff['college']) ."', '";
		$sql .= $database->escape_value($poststuff['gpa']) ."', '";
		$sql .= $database->escape_value($poststuff['major']) ."', '";
		$sql .= $dodds ."', '";
		$sql .= $douglass ."', '";
		$sql .= $dulles ."', '";
		$sql .= $the_place ."', '";
		$sql .= $show ."')";
		$database->query($sql);
		redirect_to();
	}	
	
	function new_user_form() {
		?> 
		<div class="row">
    		<div class="large-12 columns">
        		<p>Please complete the form below to add a new candidate.</p>
        	</div>
        </div>
        <form action="addnew.php" enctype="multipart/form-data" method="post">
		<div class="row">
    		<div class="large-6 medium-6 columns">
	    		<label>Full Name</label>
	    		<input type="text" name="fname" placeholder="First" />
    		</div>
    		<div class="large-6 medium-6 columns">
    			<label> &nbsp </label>
    			<input type="text" name="lname" placeholder="Last" />
    		</div>
    	</div>
        <? if ($_SESSION['level'] == 'dsl') { 
				?> <input type="hidden" name="college" value="<? echo $_SESSION['college']; ?>"/>    <? 
		} else { ?>
		<div class="row">
    		<div class="large-6 medium-6  columns">
        		<label>COLLEGE:</label>
        		<select name="college">
         			<option selected="selected" value=""></option>
                    <option value="Butler">Butler</option>
                    <option value="Forbes">Forbes</option>
                    <option value="Mathey">Mathey</option>
                    <option value="Rocky">Rocky</option>
                    <option value="Whitman">Whitman</option>
                    <option value="Wilson">Wilson</option>
                </select>
    		</div>
    	</div>
               
		<? } ?>
		<div class="row">
    		<div class="large-6 medium-6 columns">
        		<label>GPA: </label><input type="text" name="gpa" placeholder="GPA"/>
        	</div>
        	<div class="large-6 medium-6  columns">
        		<label>Major: </label><input type="text" name="major" placeholder="Major"/>
        	</div>
        </div>
        <div class="row">
    		<div class="large-6 medium-12 columns">
    			<fieldset>
    				<legend>Prizes</legend>
    				<div class="row">
    					<div class="large-4 medium-4 small-4 columns">
        					<input type="checkbox" name="dodds" value="dodds"><label style="display:inline">Dodds:  </label>
        				</div>
        				<div class="large-4 medium-4 small-4 columns">
				        	<input type="checkbox" name="dulles" value="dulles"><label style="display:inline">Dulles:  </label>
				        </div>
				        <div class="large-4 medium-4 small-4 columns">
				        	<input type="checkbox" name="douglass" value="douglass"><label style="display:inline">Douglass: </label>
				        </div>
				    </div>
				</fieldset>
			</div>

		</div>
        <div class="row">
    		<div class="large-6 medium-12 columns">
        		<label>Upload Picture:</label>
        		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		  		<input type="file" name="file_upload" /></li>
        		<form action="upload.php"  method="POST">     
		    </div>
    	</div>
    	<div class="row">
    		<div class="large-6 medium-12 columns">
            	<input type="submit" name="submit" value="Upload" class="button radius small"/>
    		</div>
    	</div>
</form>
		
		<?
	}
	
	function delete_form() {
		$this->generate_list();
		?> <table><form action="../public/admin.php" method="post">
        <tr><td>NAME</td><td>DELETE USER</td></tr>
        <?  
		foreach ($this->users as $value) {
			?>
                <tr><td> <? echo "<a href='?edtask=show&numindex={$value->get_numindex()}'> {$value->get_netid()}</a>"; ?> </td>
                <td>
                <input type="checkbox" name="<? echo $value->get_numindex(); ?>" value="<? echo $value->get_numindex(); ?>"></td>
                </tr>
			<? 
		} ?>   
				<input type="hidden" name="task" value="deleteusers"/>  
                <tr><td><input type="submit" value="submit" /></td></tr>
				</form> 	</table>
		<?
	}
	
	function delete_users($info) {
		$this->generate_list();
		foreach ($info as $key => $value){
			if ($key != 'task') {
				$the_key = (int)$key;
				$the_user = new userobject($the_key);
				$the_user->delete_user();
			}
		}
	}

}
?>