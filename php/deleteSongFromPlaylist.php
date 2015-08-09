<?php

function deleteSongFromPlaylist($p_id, $s_id) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //DELETE FROM `Contains` WHERE `Contains`.`p_id` = 7 AND `Contains`.`s_id` = \'t55174310\'"?
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("Delete from `Contains` where p_id=$p_id and s_id='$s_id'")) {
    $stmt->bind_param('is', $p_id, $s_id);
    $stmt->execute();

  }
}

/*$playlistID = $_GET['playlistID'];
$playlistName = $_GET['playlistName'];
$songID = $_GET['songID'];
$songName = $_GET['songName'];
$artistName = $_GET['artistName'];*/

$plID = $_POST['playlistID'];
$sID = $_POST['songID'];
//echo($plID . " " . $sID);

deleteSongFromPlaylist($plID, $sID);

?>