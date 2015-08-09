<?php
session_start();

//====================================================================
//	GET FORM FIELDS
//====================================================================
$name = htmlspecialchars($_POST['name']);
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$pword = htmlspecialchars($_POST['password']);

//====================================================================
//	ESTABLISH DATABASE CONNECTION
//====================================================================
  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5da', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

//==========================================
//  CHECK TO SEE IF USERNAME HAS BEEN TAKEN
//==========================================
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT Username FROM Users WHERE Username = ?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($uName);
    $stmt->fetch();
    if($uName != NULL){
      //echo "<center><h3>The username you selected has already been taken!<center></h3>";
      //header("Refresh:2; URL=http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html");
      echo '<script type="text/javascript">
            alert("The username you selected has already been taken"); 
            window.location.href = "http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html";</script>';
    }
    else{
      //==========================================
      //  INSERT USER CREDENTIALS INTO DATABASE
      //==========================================
      $stmt = $db_connection->stmt_init();
      if($stmt->prepare("INSERT INTO Users(Name, Username, EmailAddress, Password) 
          VALUES (?, ?, ?, PASSWORD(?))")) {
          $stmt->bind_param("ssss", $name, $username, $email, $pword);
          $stmt->execute();
          $_SESSION['loggedin'] = $username;
          //echo "<center><h3>You have been successfully registered! You will now be logged in and redirected to your user page.<center></h3>";
          //header("Refresh:3; URL=http://plato.cs.virginia.edu/~ams5da/ListenUp/Home.html");
          echo '<script type="text/javascript">
            alert("You have been successfully registered! You will now be logged in and redirected to your user page"); 
            window.location.href = "http://plato.cs.virginia.edu/~ams5da/ListenUp/Home.html";</script>';
      }
    }
  }

  $stmt->close();
  $db_connection->close();

?>