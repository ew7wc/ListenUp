<?php
session_start();
if(isset($_SESSION['loggedin'])){
	if($_SESSION['loggedin'] != 'admin'){
		echo "Login is User";
	}
	else{
		echo "Login is Admin";
	}
}
else{
	 echo "Not Logged In";	
}

?>