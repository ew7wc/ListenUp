<?php

function getAllPlaylists($userID) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }
  
  $defaultIcon = "images/default-playlist-artwork.png";
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT * FROM Playlists")) {
    $stmt->execute();
    $stmt->bind_result($p1, $playlistname, $iconURL);

    while($stmt->fetch()) {
      if (!isset($iconURL) || trim($iconURL)==='') {
          $iconURL = $defaultIcon;
      }

      echo("<div class=\"content-grid\" style=\"width: 10%;\"><a href=\"#\" onClick=\"play(" . $p1 . ", '" . addslashes($playlistname) . "')\"><img src=\"" . $iconURL . "\" title=\"album-name\" /></a><h3>" . $playlistname . "</h3><ul><button id=" . $p1 . " type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"editPlaylist(this.id, '" . addslashes($playlistname) . "')\"><i class=\"fa fa-pencil\"></i> Edit Me</button></ul></div>");
    }
  }
}

getAllPlaylists();

?>