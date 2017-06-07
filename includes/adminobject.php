<? include_once("oopsinitialize.php");

class adminobject {
	
	private $netid;
	private $users;
	
	function __construct($netid) {
		$this->netid = $netid;
		$this->users = array();
	}
	
	function generate_list(){
		global $database;
		$this->users = array();
		$sql="SELECT * FROM userlist ORDER BY netid";
		$result_set = $database->query($sql);
		$counter = 0;
		while ($resultrow = $database->fetch_array($result_set)) {
			$the_user = new userobject($resultrow['numindex']);
			array_push($this->users, $the_user);
			$counter++;
		}
	}

	function insert_user($info) {
		global $database;
		$sql = "INSERT INTO userlist (";
	  	$sql .= "netid, level, college";
 		$sql .= ") VALUES ('";
		$sql .= $database->escape_value($info['netid']) ."', '";
		$sql .= $database->escape_value($info['level']) ."', '";
		$sql .= $database->escape_value($info['college']) ."')";
		$database->query($sql);
	}	
	
	function new_user_form() {
		?> 
		<div class="row">
    		<div class="medium-12 columns">
        		<p>To enter a new user to this site, please add their netid,<br/>user level, and college affiliation only if DSL.</p>
        		<form action="admin.php" method="post">
				<label>NETID:</label> <input type="text" name="netid" class="field-long" placeholder="NetID"/>
	        	<label>LEVEL:</label> 
	        		<select name="level">
						<option selected="selected" value=""></option>
	    				<option value="admin">Admin</option>
	   					<option value="dsl">DSL</option>
	    				<option value="user">User</option>
	 			   	</select>
	        	
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
					<input type="hidden" name="task" value="adduser"/>        
				<input type="submit" value="submit" class="button radius small" />
            	</form> 
            </div>
        </div>	
		<?
	}
	
	function delete_form() {
		$this->generate_list();
		?> 
        <p>Click on a NETID to edit. Use the checkboxes to delete users.</p>
        <form action="../public/admin.php" method="post">
        
        <table><tr><td>
        <label>NETID</label></td><td><label>DELETE USER</label></td></tr>
        <?  
		foreach ($this->users as $value) {
			?> <tr><td><? echo "<a href='?edtask=show&numindex={$value->get_numindex()}'> {$value->get_netid()}</a>"; ?> </td>
               <td align="center"> <input type="checkbox" name="<? echo $value->get_numindex(); ?>" value="<? echo $value->get_numindex(); ?>" /></td></tr>			<? 
		} ?>   
				<input type="hidden" name="task" value="deleteusers"/>  
                <tr><td><input type="submit" value="submit" class="button radius small" /></td></tr></table>
				</ul>
                </form> 	
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