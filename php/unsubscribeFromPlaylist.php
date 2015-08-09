<?php

session_start();
$getPlaylistID = $_POST['playlistID'];
$username = $_SESSION['loggedin'];

//getSongsInPlaylist($getPlaylistID);



function unsubscribeFromPlaylist($p_id, $username) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //echo "Connection made!";

  // "DELETE FROM `cs4750ams5da`.`Subscribes_to` WHERE `Subscribes_to`.`Username` = \'ams5da\' AND `Subscribes_to`.`p_id` = 2"?
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("Delete FROM Subscribes_to WHERE Username = ? and p_id = ?")) {
      $stmt->bind_param("si", $username, $p_id);
      $stmt->execute();     
  }
}

unsubscribeFromPlaylist((int)$getPlaylistID, $username);

?>