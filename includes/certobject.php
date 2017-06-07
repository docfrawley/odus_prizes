<? include_once("oopsinitialize.php");

class certificates {
	
	private $numindex;
	private $certifcates;
	
	function __construct($nindex) {
		$this->numindex = $nindex;
		$this->certifcates = array();
	}
	
	function get_cert() {
		global $database;
		$this->certifcates = array();
		$sql="SELECT * FROM certificates WHERE numindex = '".$this->numindex."'";
		$result_set = $database->query($sql);
		while ($resultrow = $database->fetch_array($result_set)) {
			$certname = $resultrow['cname'];
			array_push($this->certifcates, $certname);
		}
		return $this->certifcates;
	}
	
	function num_cert(){
		$this->get_cert();
		return count($this->certifcates);
	}
	
	function show_cert() {
		$this->get_cert();
		if ($this->num_cert() > 0) {
			?><p><strong>CERTIFICATES:</strong><br/><?
			foreach($this->certifcates as $cert) {
				echo "&nbsp;".$cert.'<br/>';
			}
			?></p><?
		} else {
			echo "<p>No Certificates</p>";
		}
	}
	
	
	
	function cert_form() {
		
		?><strong>ADD CERTIFICATE</strong>
        <form action="indcand.php" method="post">
	        <select name="certificate" style="font-size:12px;"><? generate_certs(); ?></select>
	        <input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/>        
			<input type="submit" value="submit" class="button radius small"/>
        </form>
        <?
	}
	
	function add_cert($cert){
		global $database;
		$sql = "INSERT INTO certificates (";
		$sql .= "numindex, cname";
 		$sql .= ") VALUES ('";
		$sql .= $this->numindex ."', '";
		$sql .= $cert ."')";
		$database->query($sql);
	}
	
	function cert_del_form() {
		$this->get_cert();
		?><table><form action="indcand.php" method="post"><?
		foreach($this->certifcates as $cert) {
			?><tr><td> <? echo $cert; ?> </td><td><input type="checkbox" name="<? echo $cert; ?>" value="yes"></td></tr>
            <?
		} ?>
		<input type="hidden" name="numindex" value="<? echo $this->numindex ?>"/>  
        <input type="hidden" name="certificate" value="deletecerts"/>  
		<tr><td><input type="submit" value="submit" class="button radius small"/></td></tr>
		</form></table><?
	}
	
	function delete_cert($info){
		global $database;
		$this->get_cert();
		echo $info['African Studies'];
		foreach($this->certifcates as $cert) {
			$temp = str_replace(' ', '_', $cert);
			if (isset($info[$temp])) {
				$sql = "DELETE FROM certificates WHERE numindex ={$this->numindex} AND cname='{$cert}'";
	 			$database->query($sql);
			}
		}
	}
}

?>