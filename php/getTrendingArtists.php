<?php

function getTrendingArtists() {
  $artist = array();

  $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
  if (mysqli_connect_errno()) {
    echo "Connection Error!";
    return;
  }

  $file = "http://plato.cs.virginia.edu/~ams5da/ListenUp/text/trendingArtists.txt"; 
  $lines = file($file);

  foreach($lines as $line){
    $array = explode("\n", $line);
    array_push($artist, trim($array[0]));
  }

  $stmt = $db_connection->stmt_init();
  $stmt->prepare("SELECT * FROM Artists");
  $stmt->execute();
  $stmt->bind_result($a_id, $a_Name, $top_songs_key, $bio);

   while($stmt->fetch()){
      if(in_array($a_id, $artist)){
          echo('<a id="' . $top_songs_key . '" class="list-group-item"><button onclick="display(this,\'' . $a_Name . '\', \'' . $a_id . '\', \'' . $bio . '\')" id="playSong" class ="btn btn-mini"><i class="fa fa-play"></i></button>' . $a_Name . '</a>');

      }
   }

  $stmt->close();

}

getTrendingArtists();


?>