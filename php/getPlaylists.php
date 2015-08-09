<?php
session_start();

function getYourPlaylists($userID) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //SELECT * FROM Subscribes_to JOIN Playlists WHERE Subscribes_to.p_id = Playlists.p_id AND Username = 'ams5da'

  $defaultIcon = "images/default-playlist-artwork.png";

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT * FROM Subscribes_to JOIN Playlists WHERE Subscribes_to.p_id = Playlists.p_id AND Username = ?")) {
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->bind_result($Username, $p1, $playlistname, $p2, $pl2, $iconURL);
    //echo $userID;
    while($stmt->fetch()) {
      if (!isset($iconURL) || trim($iconURL)==='') {
          $iconURL = $defaultIcon;
      }
      echo("<div class=\"content-grid\" id=\"" . $p1 . "\"><a href=\"#\" onClick=\"play(" . $p1 . ", '" . addslashes($playlistname) . "')\"><img src=\"" . $iconURL . "\" title=\"album-name\" /></a><h3>" . $playlistname . "</h3><ul><button type=\"button\" class=\"btn btn-danger btn-sm\" onClick=\"Unsubscribe(" . $p1 . ")\">Unsubscribe</button></ul></div>");

    }

  }
}

//$getUserID = $_GET["userID"];
$getUserID = $_SESSION['loggedin'];
getYourPlaylists($getUserID);

?>