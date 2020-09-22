<?php
include_once('php/database.php');
  if(!isset($_SESSION['email'])){
    header("location: registration.php");
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>complain</title>
    <link rel="stylesheet" href="css/complain.css" type="text/css">
  </head>

  <body>
    <div class="container" >
      <a style="text-align: center; color: red;" href="index.php">Go Home</a>
        <form method="post">
          <h1>subject</h1>
          <input type="text" name="subject" placeholder="enter subject">
          <h1>Complain</h1>
          <p>Please write your complain in this box</p>
          <input type="text" name="complain_text" placeholder="write problem">
          <h1>suggestion</h1>
          <p style="color:Slateblue;">"Please wait  for our help.If you dont like any of our activities we will work our best to make you happy.</p>
          <h1>Submit </h1>
          <input type="submit" name="complain_button"value="SUBMIT">
     </form>

     <?php
       if(isset($_POST['complain_text']) && isset($_SESSION['groups'])){
         $complain_value = $_POST['complain_text'];
         $user_name = $_SESSION['name'];
         $user_email = $_SESSION['email'];
         $user_group = $_SESSION['groups'];

         $create = "CREATE TABLE complain (
           name VARCHAR(50) NOT NULL,
           email varchar(50) not NULL,
           groups  INT(20) NOT NULL,
           complain VARCHAR(150)
         )";

         mysqli_query($conn, $create);


         $sql = "INSERT INTO complain(name, email, groups, complain) VALUES('$user_name', '$user_email', '$user_group', '$complain_value')";
         if( mysqli_query($conn, $sql)) {
           echo "Successfull!";
         }
         else {
           echo "Error Found!";
         }
       }
     ?>
    </div>
  </body>
</html>
