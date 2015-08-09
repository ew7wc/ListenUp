<?php

session_start();

function addPlaylist($p_name) {

  $uName = $_SESSION['loggedin'];

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $p_name = addslashes($p_name);
  //SELECT Title, a_name FROM `Contains`NATURAL JOIN Performed_by where Contains.s_id = Performed_by.s_id and Contains.p_id = '7'

  $stmt = $db_connection->stmt_init();
  if($stmt->prepare("INSERT INTO `Playlists`(`p_name`, `al_art_URL`) VALUES (?, 'images/default-playlist-artwork.png')")) {
    $stmt->bind_param('s', $p_name);
    $stmt->execute();
    //$stmt->bind_result($title, $name, $s_id);

  }

//CREATED TRIGGER FOR THESE QUERIES INSTEAD
  // if($stmt->prepare("SELECT `p_id` FROM `Playlists` WHERE `p_name` = ?")) {
  //   $stmt->bind_param("s", $p_name);
  //   $stmt->execute();
  //   $stmt->bind_result($p_id);

  //   while($stmt->fetch()) {
  //     echo("2: " . $p_name);

  //   }

  // }

  // if($stmt->prepare("INSERT INTO `Creates`(`Username`, `p_id`, `p_name`) VALUES (?, ?, ?)")) {
  //   $stmt->bind_param('sss', $user, $p_id, $p_name);
  //   $user = $uName;
  //   $stmt->execute();
  //   //$stmt->bind_result($title, $name, $s_id);
  //   while($stmt->fetch()) {
  //     echo("3: " . $p_name);
  //   }

  // }

  if($stmt->prepare("UPDATE `Creates` SET `Username` = ? WHERE Username = p_id")) {
    $stmt->bind_param('s', $uName);
    $stmt->execute();
    $stmt->bind_result();
  }

}

$p_name = $_GET['p_name'];
addPlaylist($p_name);

if($_SESSION['loggedin'] == 'admin'){
  header('Location: http://plato.cs.virginia.edu/~ams5da/ListenUp/adminPlaylists.html');
}
else{
  header('Location: http://plato.cs.virginia.edu/~ams5da/ListenUp/Home.html');

}

?>