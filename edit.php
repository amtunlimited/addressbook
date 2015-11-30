<?
	$db = new SQLite3("database.db");
	$labels = array(
		'name'=> "Name", 
		'address'=>"Address",
		'phone_num'=>"Phone Number",
		'email'=>"Email",
	);
	
	if($_GET['eid']=="-1") {
		$db->exec("INSERT INTO entry (name,uid) VALUES ('New Entry',".$_GET['uid'].")");
		header("Location: http://aarontag.com/addressbook/edit.php?eid=".$db->lastInsertRowID()."&uid=".$_GET['uid']);
	}
	
	if(isset($_GET['action'])) {
		//This is to save edits
		if($_GET['action'] == "Save") {
			$query = "UPDATE entry SET ";
			foreach($labels as $key=> $val) {
				$query .= "$key='".$_GET[$key]."',";
			}
			
			$query = trim($query, ",");
			$query .= " WHERE id=".$_GET['eid'];
			
			$db->exec($query) or die("That got messed up. The query is $query");
			header("Location: http://aarontag.com/addressbook/list.php?uid=".$_GET['uid']);
		}
		
		//This is to delete an entry
		if($_GET['action'] == "Delete") {
			$db->exec("DELETE FROM entry WHERE id=".$_GET['eid']);
			header("Location: http://aarontag.com/addressbook/list.php?uid=".$_GET['uid']);
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Edit an entry</title>
	</head>
	
	<body>
		<form action="edit.php" method="GET">
			<table>
			<?
				//generate edit form in php, because screw that
				$entryq = $db->query("SELECT * FROM entry WHERE id=".$_GET['eid']) or die("Query Failed");
				if($entry = $entryq->fetchArray()) {
					foreach($labels as $key => $value) {
						$val = $entry[$key];
						echo("<tr><th>$value</th><td><input name='$key' value='$val' /></td></tr>\n");
					}
				} else {
					echo("Entry could not be found");
				}
			?>
			<table>
			<table id="xlist">
				<tr><th colspan=2>Extras</th><tr>
				<?
					//Make the extras
					$extraq = $db->query("SELECT * FROM extra WHERE eid=".$_GET['eid']);
					while($extra = $extraq->fetchArray()) {
						$cat = $extra['cat'];
						$data = $extra['data'];
						echo("<tr><td><input name='cat' value='$cat' /></td><td><input name='data' value='$data' /></td></tr>");
					}
				?>
			<table>
			<a href="#" id="addnew">Add another option</a><br />
			<input type="hidden" name="eid" value="<?echo($_GET['eid'])?>" />
			<input type="hidden" name="uid" value="<?echo($_GET['uid'])?>" />
			<input type="submit" name="action" value="Save" />
			<input type="submit" name="action" value="Delete" />
		</form>
	</body>
	
	<script>
	document.getElementById("addnew").onclick = function() {
		var parent = document.getElementById("xlist");
		
		var tr = document.createElement("tr");
		
		var td1 = document.createElement("td");
		var td2 = document.createElement("td");
		var td3 = document.createElement("td");
		
		var cat = document.createElement("input");
		cat.name = "cat";
		var data = document.createElement("input");
		data.name = "data";
		
		var remove = document.createElement("a");
		remove.href = "#";
		remove.appendChild(document.createTextNode("Remove"))
		remove.onclick = function() {
			parent.removeChild(tr);
			return false;
		}
		
		td1.appendChild(cat);
		td2.appendChild(data);
		td3.appendChild(remove);
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(remove);
		
		parent.appendChild(tr);
		
		return false;
	}
</script>
</html> 