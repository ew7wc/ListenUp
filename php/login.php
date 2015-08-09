<?php
session_start();

//====================================================================
//	GET FORM FIELDS
//====================================================================
$username = htmlspecialchars($_POST['username']);
$pword = htmlspecialchars($_POST['password']);

//====================================================================
//	ESTABLISH DATABASE CONNECTION
//====================================================================
  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5dab', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

//==========================================
//	FIND USERNAME AND PASSWORD MATCH
//==========================================
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT Username FROM Users WHERE Username = ? AND Password = PASSWORD(?)")) {
    $stmt->bind_param("ss", $username, $pword);
    $stmt->execute();
    $stmt->bind_result($uName);
    $stmt->fetch();

    if($uName != NULL){
      //==========================================
      //  SET SESSION VARIABLE TO USER ID
      //==========================================
      $_SESSION['loggedin'] = $uName;

      //==========================================
      //  HEAD TO ADMIN HOME PAGE OR USER HOME PAGE
      //==========================================
        if($_SESSION['loggedin'] == 'admin'){
            header("Location:http://plato.cs.virginia.edu/~ams5da/ListenUp/admin.html");
         }
        else{
            header("Location:http://plato.cs.virginia.edu/~ams5da/ListenUp/Home.html");
         }
    }
    else{
      //==========================================
      //  IF THERE WAS NO RESULT USERNAME FROM QUERY
      //==========================================      
      //echo "<center><h3>Incorrect Username and Password combination!<center></h3>";
      //header("Refresh:2; URL=http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html");

      echo '
        <script type="text/javascript">
            alert("Incorrect username and password combination"); 
            window.location.href = "http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html";</script>';
     // header("Location:http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html");
    }
  }

  $stmt->close();
  $db_connection->close();

?>