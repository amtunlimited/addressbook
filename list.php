<?php

if($_GET['action'] == "New Entry")
{
	header("Location: http://aarontag.com/addressbook/edit.php?eid=-1&uid=".$_GET['uid']);
}
?>
<!DOCTYPE html>


<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Welcome, User!</title>
    </head>
    <body>
	<?php 

	$uid = $_GET['uid'];
	$db = new SQLite3("database.db") or die('Could not open file');
	//$result = $db->query('SELECT name, id, uid FROM entry');
	$result = $db->query('SELECT name, id, uid FROM entry WHERE uid == '.$uid);
	while($row = $result->fetchArray())
	{
		$eid = $row['id'];
		$name = $row['name'];
		$uid = $row['uid'];
		echo "<a href=edit.php?eid=".$eid."&uid=".$uid.">".$name."</a><br/>";
		
	}
	
	
	?>
	<form action = "list.php" method = "GET">
		<input type = "submit" name = "action" value = "New Entry" />
		<input type="hidden" name="uid" value="<?echo($_GET['uid'])?>" />
		
        
		
        
    </body>
</html>