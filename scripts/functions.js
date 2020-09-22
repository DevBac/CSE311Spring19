function ChangeDateFormat(x, y) {
    var date = new Date(x.value);
   	var month = date.getMonth();
    var day = date.getDate();
    var year = date.getFullYear();
    document.getElementById(y).value = year + "-" + month + "-" + day;
}

function AddMember(x, y) {
	alert("Working on Adding \nMember ID: " + x + "\nGroup ID: " + y);

	/*
	<?php include_once('../php/database.php');
		$user_id = echo "<script>document.writeln(x);</script>";
		$group_id = echo "<script>document.writeln(y);</script>";

		$sql = "UPDATE users SET groups = '$group_id' WHERE id = '$user_id' ";

		if(mysqli_query($conn, $sql)) {
			header("location: ../php/logout.php");
		}
	?>
	*/
}