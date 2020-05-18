<?php
session_start(); 
require_once("model/FinanceList.php");

$sob_object = new FinanceList();
$getdate = $_POST['getdate'];

$sob_object -> update_sob($_SESSION['crs_username'], $getdate);
?>