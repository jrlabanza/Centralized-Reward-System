<?php
session_start(); 
require_once("model/FinanceList.php");

$eq_object = new FinanceList();

$eq_object -> update_fixed_es();
?>