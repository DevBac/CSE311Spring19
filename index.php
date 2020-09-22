<?php include_once('php/database.php');
  if(!isset($_SESSION['email'])){
    header("location: registration.php");
  }
  else {
    if(isset($_SESSION['groups']) && $_SESSION['groups'] != NULL) {
      $group_id = $_SESSION['groups'];

      $sql = "SELECT name FROM groups WHERE id = '$group_id'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $group_name = $row["name"];
        }
      }

      echo '<style type="text/css">
        #id_group_search {
          display: none;
        }
        #id_meal {
          display: block;
        }
      </style>';
    }
    else{
      echo '<style type="text/css">
        #id_group_search {
          display: block;
        }
        #id_meal {
          display: none;
        }
      </style>';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bachelor - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bree+Serif">
  <script src="scripts/chat.js" type="text/javascript"></script>
  <script src="scripts/functions.js" type="text/javascript"></script>
  
  <style>
    table {
      width: 100%;
      padding: 5px;
      margin-top: 10px;
      border-radius: 4px;
      background-color: #bbb;
    }
    th, td{
      border: 1px solid black;
      border-collapse: collapse;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <!--header start-->
  <header>
    <div class="top_nav">
      <!--header logo start-->
      <div class="nav_left">
        <a href="#">Bachelor</a>
      </div>
      <!--header logo end-->

      <!--header menu start-->
      <div class="nav_right">
        <a href="#">Home</a>
        <a href="GroupSearch.php">Search</a>
        <a href="complain.php">Complain</a>
        <a class="active_menu" href="php/logout.php">Logout</a>
      </div>
      <!--header menu end-->
    </div>
  </header>
  <!--header end-->

  <!--container start-->
  <div class="container">
    <!--container left start-->
    <div class="left">
      <div class="user">
        <h3 id="main_user_name">Welcome <?php if(isset($_SESSION['name'])){echo $_SESSION['name'];} ?></h3>
        <h4 id="main_user_email"><?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?></h4>
      </div>

      <div id="id_group_search" class="group_search">
        <form method="post">
          <h3>Create Group</h3>
          <input type="text" name="create_group" placeholder="Group Name" required>
          <input type="submit" name="create_group_button" value="Create">
        </form>

        <?php
        if(isset($_POST['create_group']) && isset($_SESSION['id'])) {
            $GroupName = $_POST['create_group'];
            $AdminID = $_SESSION['id'];

            $check = mysqli_query($conn, 'select 1 from `groups`');

          if($check == FALSE){
              $create = "CREATE TABLE groups (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                admin INT(20) NOT NULL
              )";

              if (!mysqli_query($conn, $create)) {
                echo "Error found! Please try again later";
              }
          }
          $sql = "INSERT INTO groups (name, admin) VALUES('$GroupName', '$AdminID')";

          if (mysqli_query($conn, $sql)) {
            $SetGroupSql = "UPDATE users SET groups = (SELECT id FROM groups WHERE name = '$GroupName' AND
            admin = '$AdminID') WHERE id = '$AdminID'";

            if(mysqli_query($conn, $SetGroupSql)) {
              echo "<p style='text-align:center; color:green; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>Group Created</p>";
              header("location: php/logout.php");
            }
          }
          else {
            echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px;
            background-color: #bbb;'>Error found!</p>";
          }
        }
      ?>
      </div>

      <div id="id_meal" class="meal">
        <h3>Group: <?php if(isset($group_name)) echo $group_name; ?></h3>
        <h4 id="main_balance">Account Balance: 0.0 tk</h4>
        <p id="main_cash_in">Total Cash In: 0.0 tk</p>
        <p id="main_cost">Total Cost: 0.0 tk</p>
        <p id="main_meal">Total Meal: 0</p>
        <p id="main_meal_rate">Meal Rate: 0.0 tk</p>
      </div>
    </div>
    <!--container left start-->

    <!--container middle start-->
    <div class="main">
      <div class="article">
        <p style="text-align: center;">Welcome to Bachelor</p>
      </div>
    </div>
    <!--container middle end-->


    <!--container right start-->
    <div class="right">
      <div class="important_info">
        <marquee>Welcome to Bachelor website. It's a group Database project developed by <a href="https://www.facebook.com/SalekurPolas3">Salekur Rahaman</a>, <a href="https://www.facebook.com/profile.php?id=100003164965915">Ania Chowdhury</a> and <a href="https://www.facebook.com/profile.php?id=100006116749308">Syeda Tasmiah Asad</a>.</marquee>
      </div>
      <div class="notice">
        <h3 style="text-align: center;">Notice</h3>
        <p>There is no notice at this moment please try again later or refresh your browser, thank you.</p>
      </div>

      <div class="member_search">
        <form action="" method="post">
          <h3>Add Member</h3>
          <input type="text" name="search_member" placeholder="Search Member" required>
          <input type="submit" name="search_member_button" value="Search">
        </form>

        <!--displaying search value start-->
        <?php
          if (isset($_POST['search_member'])) {
            $MemberSearchValue = $_POST['search_member'];
            
            $MemberSearchSql = "SELECT id, name, groups FROM users WHERE name LIKE '%".$MemberSearchValue."%'";
            $MemberSearchResult = $conn->query($MemberSearchSql);

            if ($MemberSearchResult->num_rows > 0) {
              $counter = 0;
              ?>
                <table>
                  <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                  <?php
                    while ($MemberRow = $MemberSearchResult -> fetch_assoc()) {
                      if($MemberRow["groups"] == NULL || empty($MemberRow["groups"])) {
                        $member_id = $MemberRow["id"];
                        $counter = $counter + 1;
                        ?>
                          <!--adding new row start-->
                          <tr>
                            <th><?php echo "<p>".$counter.".</p>"; ?></th>
                            <th><?php echo $MemberRow["name"]; ?></th>
                            <th><p style="cursor: pointer; color: green" onclick="AddMember(<?php echo $member_id; ?>, <?php echo $group_id; ?>)">ADD</p></th>
                          </tr>
                          <!--adding new row end-->
                        <?php
                      }
                    }
                    if($counter == 0) {
                      echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Member Found!</p>";
                    }
                  ?>
                </table>
              <?php
            }
            else {
              echo "<p style='text-align:center; color:red; width: 100%; padding: 5px; margin-top: 10px; border-radius: 4px; background-color: #bbb;'>No Member Found!</p>";
            }
          }
        ?>
        <!--displaying search value end-->
      </div>
    </div>
    <!--container right end-->

  </div>
  <!--container end-->

  <!--page footer start-->
  <footer>
    <p>Copyright all right reserved by <a href="#">Bachelor</a></p>
  </footer>
  <!--page footer end-->
</body>
</html>