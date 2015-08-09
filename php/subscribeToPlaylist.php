<?php

session_start();
$getPlaylistID = $_POST['playlistID'];
$username = $_SESSION['loggedin'];
$p_name = $_POST['p_name'];

//getSongsInPlaylist($getPlaylistID);



function subscribeToPlaylist($p_id, $username, $p_name) {

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  //echo "Connection made!";
  //SELECT Title, a_name FROM `Contains`NATURAL JOIN Performed_by where Contains.s_id = Performed_by.s_id and Contains.p_id = '7'
  //select Subscribes_to.p_id, Subscribes_to.p_name, Username, al_art_URL from Subscribes_to Join Playlists where Subscribes_to.p_id = Playlists.p_id AND Username = 'ams5da' and Subscribes_to.p_name = 'Work out!!!!' and Subscribes_to.p_id = 5
  //echo $p_name;
  $defaultIcon = "images/default-playlist-artwork.png";
  //First check if user is already subscribed to the playlist
  //Then if not, get the album URL
  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("SELECT * FROM Subscribes_to WHERE Username = ? and p_id = ? and p_name = ?" )) {
      $stmt->bind_param("sis", $username, $p_id, $p_name);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($user, $pid, $pname);
      $stmt->fetch();
      //echo $stmt->num_rows;
      if($stmt->num_rows==0){
        $art_URL;

        if($stmt->prepare("Select al_art_URL from Playlists WHERE p_id = ?")) {
          $stmt->bind_param("s", $p_id);
          $stmt->execute();
          $stmt->bind_result($artURL);
          while($stmt->fetch()) {
            $art_URL = $artURL;
            if (!isset($art_URL) || trim($art_URL)==='') {
            $art_URL = $defaultIcon;
            }
            //echo $artURL;
          }  

        }
        if($stmt->prepare("INSERT into Subscribes_to(Username, p_id, p_name) VALUES (?, ?, ?)")) {
          $stmt->bind_param("sis", $username, $p_id, $p_name);
          $stmt->execute();
          

          echo("<div class=\"content-grid\" id=\"" . $p_id . "\"><a href=\"#\" onClick=\"play(" . $p_id . ", '" . addslashes($p_name) . "')\"><img src=\"" . $art_URL . "\" title=\"album-name\" /></a><h3>" . $p_name . "</h3><ul><button type=\"button\" class=\"btn btn-danger btn-sm\" onClick=\"Unsubscribe(" . $p_id . ")\">Unsubscribe</button></ul></div>");

        }  
      }
  }
}
subscribeToPlaylist($getPlaylistID, $username, $p_name);

?>