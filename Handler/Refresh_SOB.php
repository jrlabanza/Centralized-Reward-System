<?php 
require_once("model/FinanceList.php");

$sob_object = new FinanceList();

$sob_object -> get_current_sob();
?>