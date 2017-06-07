<? include_once("oopsinitialize.php");

class userobject {
	
	private $numindex;
	private $level;
	private $college;
	private $netid;
	
	function __construct($numindex) {
		global $database;
		$this->numindex = $numindex;
		$sql="SELECT * FROM userlist WHERE numindex = '".$numindex."'";
		$result_set = $database->query($sql);
		$resultrow = $database->fetch_array($result_set);
		$this->netid = $resultrow['netid'];
		$this->college = $resultrow['college'];
		$this->level = $resultrow['level'];
	}
	
	function get_netid() {
		return $this->netid;	
	}
	
	function get_college() {
		return $this->college;	
	}
	
	function get_level() {
		return $this->level;	
	}
	
	function get_numindex() {
		return $this->numindex;	
	}
	
	function update_user($info) {
		global $database;
		$sql = "UPDATE userlist SET ";
		$sql .= "level='". $database->escape_value($info['level']) ."', ";
		$sql .= "college='". $database->escape_value($info['college']) ."'";
		$sql .= " WHERE numindex='". $database->escape_value($info['numindex']) ."'";
	  	$database->query($sql);
		if ($database->affected_rows() == 1) {
			?> <div <?
				echo "The requested changes for {$this->netid} has been made.";	
			?> </div> <?
		}
	}
	
	function delete_user() {
		global $database;
		$sql = "DELETE FROM userlist ";
	  	$sql .= "WHERE numindex='".$this->numindex."' ";
	  	$sql .= "LIMIT 1";
		$database->query($sql);
		if ($database->affected_rows() == 1) {
			?> <div <?
				echo $this->netid." has been deleted from this site and good riddance!";	
			?> </div> <?
		}
	}
	
		function edit_form() {
			?>
			<div class="row">
    			<div class="medium-12 columns">
					<p>Make what edits are needed and hit submit</p>
        			<form action="../public/admin.php" method="post">
        				<fieldset>
    						<legend><? echo $this->netid; ?></legend>
		        			<label>LEVEL:</label> 
		        			<select name="level">
								<option selected="selected" value="<? echo $this->level; ?>"><? echo $this->level; ?></option>
		    					<option value="admin">Admin</option>
		   						<option value="dsl">DSL</option>
		    					<option value="user">User</option>
		 			    	</select>
		        			<label>COLLEGE:</label> 
		        			<select name="college">
								<option selected="selected" value="<? echo $this->college; ?>"><? echo $this->college; ?></option>
		                        <option value=" ">None</option>
		    					<option value="Butler">Butler</option>
		   						<option value="Forbes">Forbes</option>
		    					<option value="Mathey">Mathey</option>
		                        <option value="Rocky">Rocky</option>
		   						<option value="Whitman">Whitman</option>
		    					<option value="Wilson">Wilson</option>
		 			    	</select>
        				</fieldset>
        		<input type="hidden" name="numindex" value="<? echo $this->numindex; ?>"/> 
				<input type="hidden" name="edtask" value="edituser"/>        
		<input type="submit" value="submit" class="button radius small"/>
		</form>
			</div> 
		</div>
		<? 
                
        	
	}
}
?>