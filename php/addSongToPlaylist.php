<?php

function addSongToPlaylist($songID, $songTitle, $playlistID, $playlistName, $a_Name) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5da', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }
  $songTitle = addslashes($songTitle);
  $playlistName = addslashes($playlistName);
  //INSERT INTO Contains (`p_id`, `s_id`, `p_name`, `Title`) VALUES (7, 't55174310', 'Fav Songs', 'Always In My Head')
  //echo($playlistID . " " . $playlistName . " " . $songID . " " . $songName);

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("Insert into `Contains` (`p_id`, `s_id`, `p_name`, `Title`) VALUES ($playlistID, '$songID', '$playlistName', '$songTitle')")) {
    $stmt->bind_param('isss', $songID, $songTitle, $playlistID, $playlistName);
    $stmt->execute();
    //echo("executed");
    echo("<li id=" . $songID . " class=\"list-group-item\"><button id=\"deleteSong\" onclick=\"DeleteSongFromPL(this)\" class = \"btn btn-mini\"><i class=\"fa fa-times\"></i></button> " . $songTitle . " - " . $a_Name . "</li>");

  }
}

$playlistID = $_GET['playlistID'];
$playlistName = $_GET['playlistName'];
$songID = $_GET['songID'];
$songName = $_GET['songName'];
$artistName = $_GET['artistName'];

//echo($playlistID . " " . $playlistName . " " . $songID . " " . $songName . " " . $artistName);

addSongToPlaylist($songID, $songName, (int)$playlistID, $playlistName, $artistName);

?>