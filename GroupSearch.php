<?php 
include_once('php/database.php');
  if(!isset($_SESSION['email'])){
    header("location: registration.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Group Search</title>
  <link rel="stylesheet" type="text/css" href="css/GS.css">
</head>
<body>
	<div class="box">
    <form method="post">
    <h2 style="text-align: center; color: green;">Search Group</h2>
    <input type="text" name="group_search_value" placeholder="Enter group name" required>
    <input type="submit" name="group_search_button" value="Search">
    <a style="text-align: center;" href="index.php">Go Home</a>
  </form>

  <?php
    if(isset($_POST['group_search_value'])) {
      $search_value = $_POST['group_search_value'];

      $sql = "SELECT id, name, admin FROM groups WHERE name LIKE '%".$search_value."%'";
        
          $result = $conn->query($sql);

          if (!$result->num_rows > 0) {
            echo "Groups Not Found!";
          }
          else {
            ?>
            <table>
                  <tr>
                    <th>Group ID</th>
                    <th>Group Name</th>
                    <th>Group Admin</th>
                  </tr>
                  <?php
                    while ($GroupRow = $result -> fetch_assoc()) {
                      ?>
                        <!--adding new row start-->
                        <tr>
                          <th><?php echo $GroupRow["id"]; ?></th>
                          <th><?php echo $GroupRow["name"]; ?></th>
                          <th><?php echo $GroupRow["admin"]; ?></th>
                        </tr>
                        <!--adding new row end-->
                      <?php
                    }
                  ?>
                </table>
                <?php
          }
    }
  ?>
  </div>
</body>
</html>