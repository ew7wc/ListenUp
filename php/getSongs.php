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
  if($stmt->prepare("select s_id, Title, a_name FROM `song_artist_album` natural join `Contains` where song_artist_album.s_id = Contains.s_id and Contains.p_id = '$p_id'")) {
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->bind_result($s_id, $title, $name);
    while($stmt->fetch()) {
      //echo($name ." ". $title . "\n");
     /* echo('<li id="' . $s_id. '" onclick="play(this.id)"><a href="javascript:;">' . $title . ' - ' . $name . ' ' . '</a><button id="like" class="btn btn-mini"><i class="fa fa-thumbs-o-up"></i></button></li><input type="image" src="images/likes.png" id="' . $s_id. '" onClick="likeSong(this, \'' . addslashes($title) . '\')"/>');*/

     echo('<a id="' . $s_id . '" class="list-group-item"><button onclick="play(this)" id="playSong" class ="btn btn-mini"><i class="fa fa-play"></i></button>' . $title . ' - ' . $name . '<button onclick="likeSong(this, \'' . addslashes($title) . '\')" id="like" class="btn btn-mini" ><i class="fa fa-thumbs-o-up"></i></button></a>');

    }

  }
}

$getPlaylistID = $_GET['playlistID'];
getSongsInPlaylist($getPlaylistID);

?>