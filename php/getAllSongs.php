<?php

function getAllSongs($userID) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //original query "select s_id, Title, a_name FROM `Songs` natural join `Performed_by` where Songs.s_id = Performed_by.s_id"
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("select s_id, Title, a_name FROM song_artist_album ORDER BY `song_artist_album`.`Title` ASC")) {
    $stmt->execute();
    $stmt->bind_result($s_id, $title, $name);

    while($stmt->fetch()) {
      echo("<li id=" . $s_id. " onclick=\"play(this.id)\"><a href=\"javascript:;\">" . $title . " - " . $name . "</a></li>");
    }
  }
}

getAllSongs();

?>