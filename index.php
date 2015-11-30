<?
	$failed = false;
	//If this has been submitted to
	if($_GET['action'] == "Login") {
		$db = new SQLite3("database.db");
		$result = $db->query("SELECT * FROM user WHERE name='".$_GET['user']."'");
		$failed = true;
		
		if(isset($_GET['new'])) {
			if(!($row = $result->fetchArray())) {
				$db->exec("INSERT INTO user (name,pwd_hash) VALUES ('".$_GET['user']."','notnull')");
				header("Location: http://aarontag.com/addressbook/list.php?uid=".$db->lastInsertRowID());
			}
		} else {
			if($row = $result->fetchArray()) {
				header("Location: http://aarontag.com/addressbook/list.php?uid=".$row['id']);
			}
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>A little test</title>
    </head>
    <body>
    	<?
    		if($failed){
    			echo("<b>The username ".$_GET['user']." cannot be used, try again</b>\n");
    		}
    	?>
        <form action="index.php" method="GET">
            User: <input type="text" id="user" name="user" value="" /><br/>
            New user?: <input type="checkbox" name="new" id="new" />
            <!--<input type="hidden" name="action" value="login" />-->
            <input type="submit" name="action" value="Login" />
        </form>
    </body>
</html>