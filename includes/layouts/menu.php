<div>
        <ul>
            <li><a href="index.php">HOME</a></li>
            <? if ($_SESSION['level'] == 'admin') { ?>
                <li><a href="admin.php">ADMIN</a></li>
            <? } 
               if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'dsl') {
            ?>
            <li><a href="addnew.php">ADD NEW</a></li>
            <li><a href="index.php?award=edidel">EDIT/DELETE</a></li>
            <li><a href="index.php?award=resurrect">RESURRECT</a></li>
            <li><a href="https://www.princeton.edu/collegefacebook/">FACEBOOK</a></li>
            <? } ?>
            <li><a href="index.php?award=dodds">DODDS</a></li>
            <li><a href="index.php?award=douglass">DOUGLASS</a></li>
            <li><a href="index.php?award=dulles">DULLES</a></li>
            <li><a href="pastwinners.php">PAST WINNERS</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
	</div>        
