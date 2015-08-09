<?php

function getSpecificSongs($query) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $query = addslashes($query);


  //SELECT DISTINCT s_id, Title FROM `Songs` where UPPER(Title) like UPPER('%r%')
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT DISTINCT s_id, Title, a_Name FROM Performed_by where UPPER(Title) like UPPER('%$query%')")) {
    $stmt->bind_param('s', $query);
    $stmt->execute();
    $stmt->bind_result($s_id, $Title, $a_Name);

	echo("<ul class=\"list-group\">");
    while($stmt->fetch()) {
    	echo('<a id="' . $s_id . '" class="list-group-item"><button onclick="AddSongToPL(this, \'' . addslashes($Title) . '\', \'' . addslashes($a_Name) . '\')" id="addSong" class = "btn btn-mini"><i class="fa fa-plus-circle"></i><button onclick="PlaySong(this)" id="playSong" class ="btn btn-mini"><i class="fa fa-play"></i></button>' . $Title . ' - ' . $a_Name . '<button id="like" onclick="likeSong(this, \'' . addslashes($Title) . '\')" class="btn btn-mini"><i class="fa fa-thumbs-o-up"></i></button></a>');
    }
    echo("</ul>");

  }
}

$songQuery = $_GET['songQuery'];
getSpecificSongs($songQuery);

?>