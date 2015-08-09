<?php
session_start();

function getLikedSongs($u_id) {

  $uName = $_SESSION['loggedin'];

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }


  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT Title, a_name, s_id FROM `Likes` NATURAL Join `Songs` NATURAL Join `Performed_by` WHERE username = '$uName'")) {
    $stmt->bind_param("s", $uName);
    $stmt->execute();
    $stmt->bind_result($title, $name, $s_id);
    while($stmt->fetch()) {
      //echo($name ." ". $title . "\n");
      echo('<a id="' . $s_id . '" class="list-group-item"><button onclick="play(\''.$s_id . '\')" id="playSong" class ="btn btn-mini"><i class="fa fa-play"></i></button>' . $title . ' - ' . $name . '</a>');

    }

  }
}

$getUserID = $_GET['userID'];
getLikedSongs($getUserID);

?>