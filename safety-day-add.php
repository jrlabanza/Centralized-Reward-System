<?php
//connects php to mysql//
$connection = mysqli_connect('phsm01ws012', 'root','ee_expertdb','portal');
//$connection = mysqli_connect('localhost', 'root','','sob_db');
if(!$connection){
die ('DATABASE NOT CONNECTED');
}

//Mail FUnction
function sendmail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '', $cc=""){
    $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
    $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

    $headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";

    if ($cc != ""){
        $headers .= "CC: ". $cc ." \r\n";
    }

    return mail($to, $subject, $message, $headers);
}
//Get data row in SQL
function get_data_array($result){

$data = array();

if (is_object($result) && !empty($result->num_rows)) {
    while ($row = $result->fetch_assoc()) {
        foreach($row as $col => $value){
            $data[$col] = $value;
        }
    }
    $result->free();
}

return $data;

}



$sql = "UPDATE safety_days SET current_record = current_record + 1,previous_record = IF(current_record > previous_record, previous_record + 1, previous_record + 0) Limit 1;
";
// $result = $connection->query($sql);

$getsql = "SELECT current_record, previous_record FROM safety_days LIMIT 1;";
$result = $connection->query($getsql);
$statone = get_assocArray($result);

$statusLen = sizeof($statone);

 for ($one = 0 ; $one < $statusLen ; $one++){
	 sendmail_utf8("Joe.Labanza@onsemi.com",
	 "SAFETY DAYS",
	 "apps.donotreply@onsemi.com",
	 "SAFETY DAYS STATUS", 
	 "<p> This company has worked</p><p><b>". $statone[$one]["current_record"] ."</b><a href='http://phsm01ws014.ad.onsemi.com:2000'>VIEW SITE</a></p> <br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> SPARKS OF BRILLIANCE");
	 
 }






?>
