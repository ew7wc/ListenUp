<?php
//
// Destroy sessions, head back to the index page
//
 session_start();
 session_destroy();
 header("Location:http://plato.cs.virginia.edu/~ams5da/ListenUp/index.html");
?>