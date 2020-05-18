<?php
    
    require_once("Connection.php");
    
    class FinanceList extends SOB_Connection
    {

        public function __construct(){
            parent::__construct();
        }
        public function get_user_data($crs_username){
            $userConnObj = new user_Connection();

            $query = "SELECT * from employeeinfos WHERE ffId='". $crs_username ."'";
            $result = $userConnObj->conn->query($query);
            
            return $userConnObj->get_Array($result);

        }

        public function associate_data($crs_username){
            $userConnObj = new user_Connection();

            $query = "SELECT * from employeeinfos WHERE cidNum='". $crs_username ."'";
            $result = $userConnObj->conn->query($query);
            
            return $userConnObj->get_Array($result);

        }
        
        public function get_priv_data($crs_type){
            

            $query = "SELECT * from usertype WHERE ffId='". $crs_type ."'";
            $result = $this->conn->query($query);
            
            return $this->get_assocArray($result);

        }

        public function get_current_sob(){
                        
            $query = "SELECT * from formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE (status = '3') AND isDeleted = 0 ORDER BY app_date DESC";
            $result = $this->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function get_current_fixed_es(){
            $esConnObj = new ES_Connection();

            $query = "SELECT * from report_incidents WHERE isRewarded = 0 AND (situationStatus = 2 OR situationStatus = 4 OR situationStatus = 5) AND canReward = 0 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $esConnObj->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function get_current_es(){
            $esConnObj = new ES_Connection();

            $query = "SELECT * from report_incidents WHERE isRewarded = 0  AND canReward = 1 AND isRewarded = 0 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $esConnObj->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function get_current_fixed_eq(){ //temporary fix (reportType =1)
            $eqConnObj = new EQ_Connection();

            $query = "SELECT * from report_incidents WHERE isRewarded = 0 AND (situationStatus = 2 OR situationStatus = 4 OR situationStatus = 5) AND canReward = 0 AND isDeleted = 0 AND category != 'N/A' ORDER BY dateEntry DESC";
            $result = $eqConnObj->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function get_current_eq(){ //temporary fix (reportType =1)
            $eqConnObj = new EQ_Connection();

            $query = "SELECT * from report_incidents WHERE isRewarded = 0  AND canReward = 1 AND isRewarded = 0 AND isDeleted = 0 AND category != 'N/A' ORDER BY dateEntry DESC";
            $result = $eqConnObj->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function get_last_approved_sob_form(){
            $query = "SELECT * FROM formfill_infov2 WHERE status = 4 ORDER BY fin_date DESC LIMIT 1";
            $result = $this->conn->query($query);
            return $this->get_Array($result);

        }

        public function data_extract_sob(){
            $query = "SELECT * from formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE  isDeleted = 0 ORDER BY rec_date DESC";
            $result = $this->conn-> query($query);
            return $this->get_assocArray($result);
        }

        public function update_sob($update_sob, $datelimit){
            $userConnObj = new user_Connection();

            $user = "SELECT * FROM employeeinfos WHERE ffId='". $update_sob ."'"; 
            $userres = $userConnObj->conn->query($user);
            $u = $this->get_Array($userres);
           
            $showallrec_query ="SELECT * from formfill_infov2 WHERE status = 3 ORDER BY app_date DESC";
            $result = $this->conn->query($showallrec_query);
            $f = $this->get_assocArray($result);
            
            $sql = "SELECT * FROM formfill_infov2 WHERE status = 4 AND isDeleted = 0 ORDER BY rec_date DESC LIMIT 1";
            $result = $this->conn-> query($sql);
            $user = $this->get_Array($result);
            $batch_no = $user['batch_no'] + 1;
            
            $total = sizeof($f);

            $userConnObj = new user_Connection();
            
            for ($i = 0 ; $i < $total; $i++){

                

                $emailquery = "SELECT * FROM employeeinfos WHERE cidNum ='". $f[$i]['rec_CID']. "'";
                $resultmail = $userConnObj->conn->query($emailquery);
                $m = $this->get_Array($resultmail);
               
                            
                $finalstatus = "UPDATE formfill_infov2 SET status = 4, fin_by ='". $u['lastName'] . " " . $u['firstName'] ."', fin_date = CURRENT_TIMESTAMP, batch_no = '$batch_no' WHERE id =". $f[$i]['id'] ." AND valid_date <= '$datelimit'";
                $finalstat = $this->conn->query($finalstatus);

                $mail_to = $m['email'];
                $mail_title = "Sparks of Brilliance";
                $mail_from = "apps.donotreply@onsemi.com";
                $mail_subject = "E-SOB : FINANCE CLOSED";
                $mail_body = "<p><b>TICKET #:". $f[$i]['ticket_no'] ."</b> Your current Sparks of Brilliance Form has been finalized by the HR and finance and has completed transaction via ATM Deposit. <br/> <br/>";
                $mail_body .= "<table style='border: 1px solid black;'>
                                    <thead>
                                        <th style='border: 1px solid black; padding: 5px;'>Associate Name</th>
                                        <th style='border: 1px solid black; padding: 5px;'>CID Num</th>
                                        <th style='border: 1px solid black; padding: 5px;'>Amount</th>   
                                    <thead>
                                    <tbody>";
                                    $associate_query = "SELECT * FROM associate_info WHERE sobFormID = ". $f[$i]['id'];
                                    $associate_result = $this->conn->query($associate_query);
                                    $associate_array = $this->get_assocArray($associate_result);
                                    $associate_len = sizeof($associate_array);
                                    for ($assoc = 0; $assoc < $associate_len ; $assoc++){
                                        $mail_body .= "<tr>";
                                        $mail_body .= "<td style='border: 1px solid black; padding: 5px;'>". $associate_array[$assoc]['associate_name'] ."</td>";
                                        $mail_body .= "<td style='border: 1px solid black; padding: 5px;'>". $associate_array[$assoc]['user_CID_num'] ."</td>";
                                        $mail_body .= "<td style='border: 1px solid black; padding: 5px;'>". $associate_array[$assoc]['rec_amount'] ."</td>";
                                        $mail_body .= "</tr>";
                                    } 
                $mail_body .="                   
                                    </tbody>
                                </table>";
                $mail_body .= "Please see status on your form form.</p> <p>Please use Google Chrome or Mozilla FireFox <a>http://phsm01ws014.ad.onsemi.com/sob/view-form.php?id=". $f[$i]['id'] ."</a></p>";
                $mail_body .= "<br> <br> <br/><br/><b style='color:red'>Please do not reply.</b> <br/><br/>Applications Engineering <br/> SPARKS OF BRILLIANCE";

                // echo $finalstat . "<br/>";
                $this->sendEmailNotif_uft8($mail_to, $mail_title, $mail_from, $mail_subject, $mail_body);
                // echo $mail_to, $mail_title, $mail_from, $mail_subject, $mail_body;
                
            }    
   
        }

        public function update_es($update_es){
            $userConnObj = new user_Connection();
            $esConnObj = new ES_Connection();

            $user = "SELECT * FROM employeeinfos WHERE ffId='". $update_es ."'"; 
            $userres = $userConnObj->conn->query($user);
            $u = $this->get_Array($userres);
           
            $showallrec_query ="SELECT * from report_incidents WHERE isRewarded = 0 AND canReward = 1 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $esConnObj->conn->query($showallrec_query);
            $f = $this->get_assocArray($result);
            
            $sql = "SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC LIMIT 1";
            $result = $esConnObj->conn-> query($sql);
            $user = $this->get_Array($result);
            $batch_no = $user['batch_no'] + 1;
            
            $total = sizeof($f);
            
            for ($i = 0 ; $i < $total; $i++){

                            
                $finalstatus = "UPDATE report_incidents SET isRewarded = 1, finDate = CURRENT_TIMESTAMP, batch_no = '$batch_no' WHERE id =". $f[$i]['id'] ."";
                $finalstat = $esConnObj->conn->query($finalstatus);
      
            }    
   
        }

        public function update_fixed_es(){
            $userConnObj = new user_Connection();
            $esConnObj = new ES_Connection();
           
            $showallrec_query ="SELECT * from report_incidents WHERE isRewarded = 0 AND (situationStatus = 2 OR situationStatus = 4 OR situationStatus = 5) AND canReward = 0 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $esConnObj->conn->query($showallrec_query);
            $f = $this->get_assocArray($result);
            
            $sql = "SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC LIMIT 1";
            $result = $esConnObj->conn-> query($sql);
            $user = $this->get_Array($result);
            $batch_no = $user['batch_no'] + 1;
            
            $total = sizeof($f);
            
            for ($i = 0 ; $i < $total; $i++){

                            
                $finalstatus = "UPDATE report_incidents SET canReward = 1 WHERE id =". $f[$i]['id'] ."";
                $finalstat = $esConnObj->conn->query($finalstatus);
      
            }    
   
        }
       
        public function update_eq($update_eq){
            $userConnObj = new user_Connection();
            $eqConnObj = new EQ_Connection();

            $user = "SELECT * FROM employeeinfos WHERE ffId='". $update_es ."'"; 
            $userres = $userConnObj->conn->query($user);
            $u = $this->get_Array($userres);
           
            $showallrec_query ="SELECT * from report_incidents WHERE isRewarded = 0 AND canReward = 1 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $eqConnObj->conn->query($showallrec_query);
            $f = $this->get_assocArray($result);
            
            $sql = "SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC LIMIT 1";
            $result = $eqConnObj->conn-> query($sql);
            $user = $this->get_Array($result);
            $batch_no = $user['batch_no'] + 1;
            
            $total = sizeof($f);
            
            for ($i = 0 ; $i < $total; $i++){

                            
                $finalstatus = "UPDATE report_incidents SET isRewarded = 1, finDate = CURRENT_TIMESTAMP, batch_no = '$batch_no' WHERE id =". $f[$i]['id'] ."";
                $finalstat = $eqConnObj->conn->query($finalstatus);
      
            }
            $combimail = "Joe.Labanza@onsemi.com,Marilou.Tinio@onsemi.com,HaroldCarlo.Rebuldela@onsemi.com";
            $this->sendEmailNotif_uft8("Gary.Santiago@onsemi.com", "E-Quality", "apps.donotreply@onsemi.com", "The forms has been approved by the Finance, You can now proceed to accept new forms", $combimail);    
   
        }

        public function update_fixed_eq(){
            $userConnObj = new user_Connection();
            $eqConnObj = new EQ_Connection();
           
            $showallrec_query ="SELECT * from report_incidents WHERE isRewarded = 0 AND (situationStatus = 2 OR situationStatus = 4 OR situationStatus = 5) AND canReward = 0 AND isDeleted = 0 ORDER BY dateEntry DESC";
            $result = $eqConnObj->conn->query($showallrec_query);
            $f = $this->get_assocArray($result);
            
            $sql = "SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC LIMIT 1";
            $result = $eqConnObj->conn-> query($sql);
            $user = $this->get_Array($result);
            $batch_no = $user['batch_no'] + 1;
            
            $total = sizeof($f);
            
            for ($i = 0 ; $i < $total; $i++){

                            
                $finalstatus = "UPDATE report_incidents SET canReward = 1 WHERE id =". $f[$i]['id'] ."";
                $finalstat = $eqConnObj->conn->query($finalstatus);
      
            }    
   
        }

        public function show_sob_stat(){
            
            $sql ="SELECT status, COUNT(status) As countStatus FROM  formfill_infov2 WHERE isDeleted=0 GROUP BY status ORDER BY countStatus DESC LIMIT 10";
            $result = $this->conn->query($sql);
            $statusCount = $this->get_assocArray($result);

            $labels = array();
            $data = array();

            $statusCountSize = sizeof($statusCount);

            for($i=0; $i<$statusCountSize; $i++){
                array_push($labels, $statusCount[$i]['status']);
                array_push($data, $statusCount[$i]['countStatus']);
            }


            $statusCountArr = array("labels" => $labels, "data" => $data);
         
            echo json_encode($statusCountArr);


        }

        public function show_sob_log(){

            if (isset($_POST['startDate']) == "" && isset($_POST['endDate']) == "" ){     
         
                $query_filed ="SELECT * FROM formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE (status = 4) AND isDeleted = 0 ORDER BY fin_date DESC";
                $filedforms = $this->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }

            else{
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $query_filed ="SELECT * FROM formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE ((DATE(fin_date) BETWEEN '$startDate' and '$endDate') AND status = 4) AND isDeleted = 0 ORDER BY DATE(fin_date) DESC";
                $filedforms = $this->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }


        }

        public function show_es_log(){

            if (isset($_POST['startDate']) == "" && isset($_POST['endDate']) == "" ){
                
                $esConnObj = new ES_Connection();
                         
                $query_filed ="SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC";
                $filedforms = $esConnObj->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }

            else{
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $query_filed ="SELECT * FROM formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE ((DATE(fin_date) BETWEEN '$startDate' and '$endDate') AND status = 4) AND isDeleted = 0 ORDER BY DATE(fin_date) DESC";
                $filedforms = $this->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }


        }

        public function show_eq_log(){

            $eqConnObj = new EQ_Connection();

            if (isset($_POST['startDate']) == "" && isset($_POST['endDate']) == "" ){     
         
                $query_filed ="SELECT * FROM report_incidents WHERE isRewarded = 1 AND isDeleted = 0 ORDER BY finDate DESC";
                $filedforms = $eqConnObj->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }

            else{
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $query_filed ="SELECT * FROM formfill_infov2 INNER JOIN associate_info ON formfill_infov2.id = associate_info.sobFormID WHERE ((DATE(fin_date) BETWEEN '$startDate' and '$endDate') AND status = 4) AND isDeleted = 0 ORDER BY DATE(fin_date) DESC";
                $filedforms = $this->conn->query($query_filed);
                return $this->get_assocArray($filedforms);
            }


        }

        
        
    }

    class Dashboard extends SOB_Connection
    {
        public function q1_count_sob()
        {
            //echo 'First day : '. date("Y-m-01", strtotime($dt)).' - Last day : '. date("Y-m-t", strtotime($dt)); 
            $january = date("Y-01-d H:i:s");
            $march = date("Y-03-d H:i:s");
            $startDateJan = date("Y-m-01", strtotime($january));
            $endDateMarch = date("Y-m-t", strtotime($march));

            $sql = "SELECT count(*) as q1count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$startDateJan' AND '$endDateMarch') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }
        public function q2_count_sob()
        {

            $april = date("Y-04-d H:i:s");
            $june = date("Y-06-d H:i:s");
            $startDateApril = date("Y-m-01", strtotime($april));
            $endDateJune = date("Y-m-t", strtotime($june));

            $sql = "SELECT count(*) as q2count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$startDateApril' AND '$endDateJune') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }
        public function q3_count_sob()
        {

            $july = date("Y-07-d H:i:s");
            $september = date("Y-09-d H:i:s");
            $startDateJuly = date("Y-m-01", strtotime($july));
            $endDateSeptember = date("Y-m-t", strtotime($september));

            $sql = "SELECT count(*) as q3count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$startDateJuly' AND '$endDateSeptember') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }
        public function q4_count_sob()
        {

            $october = date("Y-10-d H:i:s");
            $december = date("Y-12-d H:i:s");
            $startDateOctober = date("Y-m-01", strtotime($october));
            $endDateDecember = date("Y-m-t", strtotime($december));

            $sql = "SELECT count(*) as q4count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$startDateOctober' AND '$endDateDecember') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }

        public function first_month()
        {
            $getdate = date("Y-m-d H:i:s");
            
            $date = new DateTime($getdate);
            $month = $date->format("n");
            if ($month == 1 || $month == 2 || $month == 3)
            {   
                $target_month = date("Y-01-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 4 || $month == 5 || $month == 6)
            {
                $target_month = date("Y-04-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 7 || $month == 8 || $month == 9)
            {
                $target_month = date("Y-07-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 10 || $month == 11 || $month == 12)
            {
                $target_month = date("Y-10-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            $sql = "SELECT count(*) as firstmonth_count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$month_first' AND '$month_last') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }

        public function second_month()
        {
            $getdate = date("Y-m-d H:i:s");
            
            $date = new DateTime($getdate);
            $month = $date->format("n");
            if ($month == 1 || $month == 2 || $month == 3)
            {   
                $target_month = date("Y-02-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 4 || $month == 5 || $month == 6)
            {
                $target_month = date("Y-05-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 7 || $month == 8 || $month == 9)
            {
                $target_month = date("Y-08-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 10 || $month == 11 || $month == 12)
            {
                $target_month = date("Y-11-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            $sql = "SELECT count(*) as secondmonth_count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$month_first' AND '$month_last') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }

        public function third_month()
        {
            $getdate = date("Y-m-d H:i:s");
            
            $date = new DateTime($getdate);
            $month = $date->format("n");
            if ($month == 1 || $month == 2 || $month == 3)
            {   
                $target_month = date("Y-03-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 4 || $month == 5 || $month == 6)
            {
                $target_month = date("Y-06-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 7 || $month == 8 || $month == 9)
            {
                $target_month = date("Y-09-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }
            else if ($month == 10 || $month == 11 || $month == 12)
            {
                $target_month = date("Y-12-d H:i:s");
                $month_first = date("Y-m-01", strtotime($target_month));
                $month_last = date("Y-m-t", strtotime($target_month));
            }

            $sql = "SELECT count(*) as thirdmonth_count FROM formfill_infov2 WHERE (DATE(fin_date) BETWEEN '$month_first' AND '$month_last') AND status = 4 AND isDeleted= 0";
            $result = $this->conn->query($sql);
            return $this->get_Array($result);

        }

        public function first_workweek()
        {

            

        }

    }
?>