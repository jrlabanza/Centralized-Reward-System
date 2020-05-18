<?php
session_start(); 
require_once("model/FinanceList.php");

$es_object = new FinanceList();

$es_object -> update_es($_SESSION['crs_username']);
?>