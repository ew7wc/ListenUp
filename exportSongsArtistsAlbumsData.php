<?php

exportPlaylists();

function exportPlaylists() {

	$db_connection = new mysqli('stardock.cs.virginia.edu', 'cs4750ams5daa', 'music', 'cs4750ams5da');
	if (mysqli_connect_errno()) {
		echo "Connection Error!";
		return;
	}

  /*	header('Content-type: text/xml');       
	$data = '<?xml version="1.0" encoding="utf-8"?>';      
	$data .= "<ReturnType><Data>Here is some data</Data></ReturnType>";       
	echo "$data"; */
	$var = array();
	$sql = "SELECT * FROM song_artist_album";
	$result = mysqli_query($db_connection, $sql);

	while($obj = mysqli_fetch_object($result)) {
		$var[] = $obj;
	}
	header('Content-Type: application/json; charset=utf-8');

	$jsonStr = json_encode($var);
	echo '{"Songs,Artists,Albums":'. prettyPrint($jsonStr) .'}';
	//echo $jsonStr;
}

function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }

    return $result;
}

?>