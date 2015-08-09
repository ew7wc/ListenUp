<?php

function getSongsInPlaylist($p_id) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //echo "Connection made!";
  //SELECT Title, a_name FROM `Contains`NATURAL JOIN Performed_by where Contains.s_id = Performed_by.s_id and Contains.p_id = '7'

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("select s_id, Title, a_name FROM `Contains` natural join `Performed_by` where Contains.s_id = Performed_by.s_id and Contains.p_id = '$p_id'")) {
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->bind_result($s_id, $Title, $name);
 
    while($stmt->fetch()) {
       echo("<li id=" . $s_id . " class=\"list-group-item\"><button id=\"deleteSong\" onClick='DeleteSongFromPL(this)' class = \"btn btn-mini\"><i class=\"fa fa-times\"></i></button> " . $Title . " - " . $name . "</li>");
    }
  }
}

$getPlaylistID = $_GET['playlistID'];
getSongsInPlaylist($getPlaylistID);

?>