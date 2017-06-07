<? include_once("oopsinitialize.php");

class indcom {
	
	private $comindex;
	private $who;
	private $comment;
	private $comdate;
	
	function __construct($index) {
		global $database;
		$this->comindex = $index;
		$sql="SELECT * FROM comments WHERE theindex='".$this->comindex."'";
		$result_set = $database->query($sql);
		$resultrow = $database->fetch_array($result_set);
		$this->who = $resultrow['whocom'];
		$this->comment = $resultrow['comment'];
		$this->comdate = $resultrow['comdate'];
	}
	
	function get_index() {
		return $this->comindex;
	}
	
	function get_who() {
		return $this->who;
	}
	
	function get_comment() {
		return $this->comment;
	}
	
	function get_date(){
		return date("n/j/Y", $this->comdate);
	}
	
	function show_comment($isform=false) {
		if ($isform) { ?> <div class="commentboxb">  <? }
		else { ?> <div class="commentbox">  <? }
		?><span style="float:right; font-size:11px;"><? echo $this->who.' '.$this->get_date(); ?></span> <? 
		echo '<br/>'.nl2br($this->comment);  
		?> </div><?

	}
	
	function edit_form($numindex) {
		echo "MAKE ANY EDITS BELOW<br/>";
		?>
        <form action="indcand.php" method="post"><table><tr>
        <td><textarea name="edcomment">
        <? echo $this->comment; ?>
		</textarea>
        </td></tr>
        <input type="hidden" name="comindex" value="<? echo $this->comindex ?>"/>    
        <input type="hidden" name="numindex" value="<? echo $numindex ?>"/>  
        <input type="hidden" name="comments" value="editcom"/>      
		<tr><td><input type="submit" value="submit" /></td>
        </tr></table></form>
        <?
	}
	
	function edit_comment($info){
		global $database;
		$sql = "UPDATE comments SET ";
				$sql .= "comment='". $database->escape_value($info) ."' ";
				$sql .= "WHERE theindex=". $this->comindex;
				$database->query($sql);
	}
	
}

?>