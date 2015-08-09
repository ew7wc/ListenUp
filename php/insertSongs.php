<?php
if(isset($_POST['Submit'])){
  //====================================================================
  //  GET FORM FIELDS
  //====================================================================
  $sTitle = htmlspecialchars($_POST['sTitle']);
  $sProducer = htmlspecialchars($_POST['sProducer']);
  $sLength = htmlspecialchars($_POST['sLength']);
  $aArtist = htmlspecialchars($_POST['aArtist']);
  $alTitle = htmlspecialchars($_POST['alTitle']);
  $alRecordCompany = htmlspecialchars($_POST['alRecordCompany']);
  $alYear = htmlspecialchars($_POST['alYear']);
  $Bio = htmlspecialchars($_POST['Bio']);
  $tID = htmlspecialchars($_POST['tID']);
  $alID = htmlspecialchars($_POST['alID']);
  $aID = htmlspecialchars($_POST['aID']);

  //====================================================================
  //  ESTABLISH DATABASE CONNECTION
  //====================================================================
    $db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5da', 'music', 'cs4750ams5da');
    if (mysqli_connect_errno()) {
      echo "Connection Error!";
      return;
    }

  //==========================================
  //  CHECK IF SONG EXISTS
  //==========================================
    $stmt = $db_connection->stmt_init();
    if($stmt->prepare("SELECT s_id FROM Songs WHERE s_id = ?")) {
      $stmt->bind_param("s", $tID);
      $stmt->execute();
      $stmt->bind_result($value);
      $stmt->fetch();
      if($value != NULL){
        echo "Song already exists<br>";
      }
      else{
        //==========================================
        //  INSERT SONG
        //==========================================
        $stmt = $db_connection->stmt_init();
        if($stmt->prepare("INSERT INTO Songs(s_id, Title, Producer, Length) 
            VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("ssss", $tID, $sTitle, $sProducer, $sLength);
            $stmt->execute();
            echo "Song added into Song Table<br>";
        }
        $stmt = $db_connection->stmt_init();
        if($stmt->prepare("INSERT INTO Part_of(s_id, al_id, Title, al_title) 
            VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("ssss", $tID, $alID, $sTitle, $alTitle);
            $stmt->execute();
            echo "Part_of table updated<br>";
        }
        $stmt = $db_connection->stmt_init();
        if($stmt->prepare("INSERT INTO Performed_by(s_id, a_id, Title, a_Name) 
            VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("ssss", $tID, $aID, $sTitle, $aArtist);
            $stmt->execute();
            echo "Performed_by table updated<br>";
        }
        //==========================================
        //  CHECK IF ALBUM EXISTS
        //==========================================
        if($stmt->prepare("SELECT al_id FROM Album WHERE al_id = ?")) {
          $stmt->bind_param("s", $alID);
          $stmt->execute();
          $stmt->bind_result($value2);
          $stmt->fetch();
          if($value2 != NULL){
            echo "Album already exists<br>";
          }
          else{
            echo "Album does not exist<br>";
            //==========================================
            //  INSERT ALBUM
            //==========================================
            $stmt = $db_connection->stmt_init();
            if($stmt->prepare("INSERT INTO Album(al_id, al_Title, RecordCompany, Year) 
                VALUES (?, ?, ?, ?)")) {
                $stmt->bind_param("ssss", $alID, $alTitle, $alRecordCompany, $alYear);
                $stmt->execute();
                echo "Album added into Album Table<br>";
            }
          }
        }
        //==========================================
        //  CHECK IF ARTIST EXISTS
        //==========================================
        if($stmt->prepare("SELECT a_id FROM Artists WHERE a_id = ?")) {
          $stmt->bind_param("s", $aID);
          $stmt->execute();
          $stmt->bind_result($value3);
          $stmt->fetch();
          if($value3 != NULL){
            return;
            echo "Artist already exists<br>";
          }
          else{
            echo "Artist does not exist<br>";
            //==========================================
            //  INSERT ARTIST
            //==========================================
            $stmt = $db_connection->stmt_init();
            if($stmt->prepare("INSERT INTO Artists(a_id, a_Name, Bio) 
                VALUES (?, ?, ?)")) {
                $stmt->bind_param("sss", $aID, $aArtist, $Bio);
                $stmt->execute();
                echo "Artist added into Artists Table<br>";
            }
            
          }
        }
      }
    }

    $stmt->close();
    $db_connection->close();
}

?>

<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<FORM id="insertForm" NAME ="insertForm" METHOD ="POST" ACTION ="http://plato.cs.virginia.edu/~ams5da/ListenUp/php/insertSongs.php">
        <INPUT TYPE = 'text' Name ='sTitle' maxlength="50" placeholder="Song Title"></INPUT>
        <INPUT TYPE = 'text' Name ='sProducer' maxlength="50" placeholder="Producer"></INPUT>
        <INPUT TYPE = 'text' Name ='sLength' maxlength="50" placeholder="Song Length (00:00:00)"></INPUT>
        <INPUT TYPE = 'text' Name ='aArtist' maxlength="50" placeholder="Artist Name"></INPUT>
        <INPUT TYPE = 'text' Name ='alTitle' maxlength="50" placeholder="Album Title"></INPUT>
        <INPUT TYPE = 'text' Name ='alRecordCompany' maxlength="50" placeholder="Album Record Company"></INPUT>
        <INPUT TYPE = 'text' Name ='alYear' maxlength="50" placeholder="Album Year"></INPUT><br><br>
        <textarea name="Bio" rows="5" cols="30" placeholder="Artist Bio"></textarea>
        <br><br>
        <INPUT TYPE = 'text' Name ='alID' maxlength="50" placeholder="Album Key (a----)"></INPUT>
        <INPUT TYPE = 'text' Name ='tID' maxlength="50" placeholder="Song Key (t----)"></INPUT>
        <INPUT TYPE = 'text' Name ='aID' maxlength="50" placeholder="Artist Key (r----)"></INPUT>
        <INPUT TYPE = "Submit" Name = "Submit"  VALUE = "Submit"></INPUT>
      </FORM>
      <br>
      <h3>Go <a href="http://rdioconsole.appspot.com/#user%3D%26scope%3D%26method%3Dsearch">here</a> and find albumArtistKey, key, and albumKey</h3>
      <br>
      <h3>You don't need to add producer. Only fill out the Album Record Company, Album Year if the album does not exist in the DB and Bio if the artist does not exist in the DB</h3>

</body>
</html>