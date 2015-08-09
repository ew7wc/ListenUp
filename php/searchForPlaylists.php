<?php

function searchForPlaylists($query) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $query = addslashes($query);

  $defaultArtURL = "images/default-playlist-artwork.png";

  //SELECT DISTINCT * FROM `Playlists` where p_name LIKE '%summer%'
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT DISTINCT * FROM Playlists where UPPER(p_name) like UPPER('%$query%') LIMIT 8")) {
    $stmt->bind_param('s', $query);
    $stmt->execute();
    $stmt->bind_result($p_id, $p_name, $art_URL);


    while($stmt->fetch()) {
      if (!isset($art_URL) || trim($art_URL)==='') {
          $art_URL = $defaultArtURL;
      }
      echo("<div class=\"content-grid\" style=\"width: 22%\"><a href=\"#\" onClick=\"play(" . $p_id . ", '" . addslashes($p_name) . "')\"><img src=\"" . $art_URL . "\" title=\"album-name\" /></a><h3>" . $p_name . "</h3><ul><button type=\"button\"  onClick=\"subscribe(" . $p_id . ", '" . addslashes($p_name) . "')\" class=\"btn btn-success btn-sm\">Subscribe!</button></ul></div>");
    }


  }
}

$plQuery = $_GET['plQuery'];
//echo($plQuery);
searchForPlaylists($plQuery);

?>