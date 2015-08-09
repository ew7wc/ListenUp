<?php

session_start();
function addSongToLikes($user, $songID, $songName) {

  //echo ("in php: " . $user . ", " . $songID . ", " . $songName);

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $songName = addslashes($songName);

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("INSERT INTO `Likes`(`Username`, `s_id`, `Title`, `likes?`) VALUES (?,?,?, 1)")) {
    $stmt->bind_param("sss", $user, $songID, $songName);
    $stmt->execute();
    $stmt->bind_result();
    while($stmt->fetch()) {
      //echo($name ." ". $title . "\n");
      echo("Added " . $songName . " for " . $user);
    }

  }
}

$getUserID = $_SESSION['loggedin'];
$songID = $_GET['songID'];
$songName = $_GET['songName'];

addSongToLikes($getUserID, $songID, $songName);

?>