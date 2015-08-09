<?php
//session_start();

function updatePlaylistName($p_id, $new_p_name) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("UPDATE `Playlists` SET `p_name`= ? WHERE `p_id` = ?")) {
    $stmt->bind_param("si", $new_p_name, $p_id);
    $stmt->execute();
    //echo $userID;
    while($stmt->fetch()) {
    }

  }
}

$p_id = $_POST["playlistID"];
$new_p_name = $_POST["newPlayName"];

updatePlaylistName($p_id, $new_p_name);

?>