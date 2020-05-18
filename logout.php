<?php session_start();?>
<?php

    $_SESSION['crs_username'] = null;
	$_SESSION['firstname'] = null;
    $_SESSION['lastname'] = null;
    $_SESSION['userType'] = null;



    header("Location: login.php");


?>
