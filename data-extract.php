<?php session_start();  
if(empty($_SESSION["crs_username"]) || ($_SESSION['userType'] == 1)){
  
  $_SESSION['message'] = 1;
  Header("Location: logout.php"); 

  exit();
}

else {
    include "includes/header.php";

    $machineObj = new FinanceList();
    $results = $machineObj->data_extract_sob(); ?>
      
      <div class="container">  
        <div class="row" style="margin-top:40px;">
          <div class="col-lg-12">
            <h1 class="page-header">Data Extraction</h1>
            <hr>
          </div>
        </div>
     
          
          <div class="card sob">
            <div class="card-header">Sparks of Brilliance</div>
            <div class="card-body">  
              <div class="table-responsive">
                <table class="download table table-bordered table-hover" width="100%" cellspacing="0" style="font-size:10px;">
                  <thead>
                    <tr>
                      <th>WW</th>
                      <th>Ticket No.</th>
                      <th>Sub-Ticket No.</th>
                      <th>Recommended Date</th>
                      <th>Recommended By</th>
                      <th>Recorded Date</th>
                      <th>Charging Department</th>
                      <th>Name of Associate</th>
                      <th>CID No</th>
                      <th>Key Strategy</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php

                  $deptList = file_get_contents("depts.json");
                  $dept = json_decode($deptList, true);
                  $machineLen = sizeof($results);
                 
                  $CalendarList = file_get_contents("2018_cal.json");
                  $cal = json_decode($CalendarList, true);

                  echo "<p>Total forms: ". $machineLen ."</p>";
                  for ($i = 0 ; $i < $machineLen ; $i++){
                    
                    $ddate = $results[$i]['rec_date'];
                    $date = new DateTime($ddate);
                    $month = $date->format("n");
                    $day = $date->format("j");
                    $year = $date->format("y");
                  
                    if($year == 18){
                      $wwyear = '2018';
                      $yeardesc = "'18";  
                    }

                    else if($year == 19){
                      $wwyear = '2019';
                      $yeardesc = "'19";
                    }

                    else if($year == 20){
                      $wwyear = '2020';
                      $yeardesc = "'20";
                    }

                    $CalendarList = file_get_contents($wwyear."_cal.json");
                    $cal = json_decode($CalendarList, true);
                    $findww = $cal[$month];

                    $workWeek = 0;

                    foreach($findww as $key => $value){

                      $tempDays = explode(",", $value);
                      
                      $tempDaysLen = sizeof($tempDays);
                    
                      for($j=0; $j<$tempDaysLen; $j++){
                        if ($tempDays[$j] == $day){
                          $workWeek = $key;
                          break;
                        }
                      }

                    }

                    echo "<tr>";
                    echo "<td>" . $workWeek.$yeardesc."</td>";
                    echo "<td>". $results[$i]['ticket_no'] ."</td>";
                    echo "<td>". $results[$i]['subticket_no'] ."</td>";
                    echo "<td>". $results[$i]['rec_date'] ."</td>";
                    echo "<td>". $results[$i]['rec_by'] ."</td>";
                    echo "<td>". $results[$i]['fin_date'] ."</td>";
                    
                    echo "<td>". $dept[0][$results[$i]['dept_num']] ."</td>";
                    echo "<td>". $results[$i]['associate_name'] ."</td>";
                    echo "<td>". $results[$i]['user_CID_num'] ."</td>";
                    echo "<td>". $results[$i]['key_strat'] ."</td>";
                    if ($results[$i]["status"] == "1"){
                        $showstat = "FOR MANAGER PENDING";
                    }
                    else if ($results[$i]["status"] == "2"){
                        $showstat = "FOR HR PENDING";
                    }
                    else if ($results[$i]["status"] == "3"){
                        $showstat = "APPROVED";
                    }
                    else if ($results[$i]["status"] == "0"){
                        $showstat = "DECLINED";
                    }
                    else if ($results[$i]["status"] == "4"){
                                $showstat = "FINANCE CLOSED";
                            }
                    else if ($results[$i]["status"] == "5"){
                                $showstat = "ACTION NEEDED SEE FORM";
                            } 
                    else{
                        $showstat = "-";
                    }
                    echo "<td>". $showstat ."</td>";
                    echo "</tr>";
                  }
                  ?>
                  
                  </tbody>
                </table>
                </div> 
              </div>
              <div class="card-footer">
              <!-- <input class="btn btn-success sob_submit "type="submit" name="submit" value="Approved" style="float:right; margin-top:10px;"> -->
              </div> 
          </div>
    
    <?php include "includes/footer.php";
    } ?>



