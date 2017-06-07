<? include_once("oopsinitialize.php");

class comments {
	
	private $numindex;
	private $comments;
	
	function __construct($nindex) {
		$this->numindex = $nindex;
		$this->comments = array();
	}
	
	function get_com($user=false) {
		global $database;
		$this->comments = array();
		$who = $_SESSION['casnetid'];
		if (!$user) {$sql="SELECT * FROM comments WHERE numindex = {$this->numindex}";}
		else {$sql="SELECT * FROM comments WHERE numindex = {$this->numindex} AND whocom ='".$who."'";} 
		$result_set = $database->query($sql);
		while ($resultrow = $database->fetch_array($result_set)) {
			$comnum = $resultrow['theindex'];
			$comment = new indcom($comnum);
			array_push($this->comments, $comment);
		}
		return $this->comments;
	}
	
	function num_com() {
		return count($this->comments);
	}
	
	function show_comments($edform=false) {
		if ($edform && $_SESSION['level']=='user') {$this->get_com(true);}
		else {$this->get_com();}
		if ($this->num_com() >0) {
				if ($edform) { ?><table><form action="indcand.php" method="post">
				
				<tr><td>Click on comment to edit. </td><td>Delete</td></tr>
				<? }
				foreach($this->comments as $comment) {
					
					if ($edform) {
						?><tr><td style="padding-right:10px;"><a style="text-decoration:none;" href='?numindex=<? echo $this->numindex; ?>&edcom=<? echo $comment->get_index(); ?>'> <? $comment->show_comment(true); ?></a> </td><td><input type="checkbox" name="<? echo $comment->get_index(); ?>" value="yes"></td></tr> <?
					} else {
						?><div class="custom-panel-two"><? $comment->show_comment(false); ?></div><? 
					}
				}
					if ($edform) { ?>
						<input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/>     
						<input type="hidden" name="comments" value="deletecom"/>    
				<tr><td><input type="submit" value="submit" /></td></tr></form></table>
					<? 
				}
			
		} else {
			echo "<p>There are no comments for this candidate at present</p>";
		}
	}
	
	
	function comment_form() {
		?>
		<div class="row">
    		<div class="large-12 columns">
        		<p>ADD COMMENT</p>
        	</div>
        	<div class="large-12 columns">
		       	<form action="indcand.php" method="post"><table><tr>
			        <td><textarea name="newcomment" rows="10" cols="80">
					</textarea>
			        </td></tr>
			        <input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/>     
			        <input type="hidden" name="comments" value="addcom"/>    
					<tr><td><input type="submit" value="submit" class="button radius small"/></td>
		        </tr></table></form>
	    	</div>
    	</div>
        <?
	}
	
	function add_comment($poststuff){
		global $database;
		$sql = "INSERT INTO comments (";
		$sql .= "numindex, whocom, comment, comdate";
 		$sql .= ") VALUES ('";
		$sql .= $this->numindex ."', '";
		$sql .= $_SESSION['casnetid'] ."', '";
		$sql .= $database->escape_value($poststuff['newcomment']) ."', '";
		$sql .= date('U') ."')";
		$database->query($sql);
	}
	
	function delete_comment($info){
		global $database;
		$this->get_com(false);
		foreach($this->comments as $comment) {
			$theindex = $comment->get_index();
			if (isset($info[$theindex])) {
				$sql = "DELETE FROM comments WHERE theindex ={$theindex}";
	 			$database->query($sql);
			}
		}
	}
}

?>