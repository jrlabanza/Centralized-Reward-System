<?php session_start();  
if(empty($_SESSION["crs_username"]) || ($_SESSION['userType'] != 2 && $_SESSION['userType'] != 3)){
  $_SESSION['message'] = 1;
  Header("Location: logout.php"); 

  exit();
} 
else {

  include "includes/header.php";
  $sob_object = new Dashboard();
  $q1 = $sob_object->q1_count_sob();
  $q2 = $sob_object->q2_count_sob();
  $q3 = $sob_object->q3_count_sob();
  $q4 = $sob_object->q4_count_sob();
  $first_month = $sob_object->first_month();
  $second_month = $sob_object->second_month();
  $third_month = $sob_object->third_month();

  $CalendarList = file_get_contents("2019_cal.json");
  $cal = json_decode($CalendarList, true);
  // $findww = $cal[$month];

  $workWeek = 0;

  // foreach($findww as $key => $value){

  //   $tempDays = explode(",", $value);
    
  //   $tempDaysLen = sizeof($tempDays);
  
  //   // for($j=0; $j<$tempDaysLen; $j++){
  //   //   if ($tempDays[$j] == $day){
  //   //     $workWeek = $key;
  //   //     break;
  //   //   }
  //   //   echo $temp
  //   // }

  // }
  
  ?>

  <div class="container">  
    <div class="row" style="margin-top:40px;">
      <div class="col-lg-12">
        <h1>WELCOME</h1>
        <hr>
        <h3>Statistics</h3>
        <table class='table table-bordered'>
          <thead>
            <tr style='background-color:#E6E6FA;'>
              <th></th>
              <th>Q1</th>
              <th>Q2</th>
              <th>Q3</th>
              <th>Q4</th>
              <th>First Month</th>
              <th>Second Month</th>
              <th>Third Month</th>
              <th>WW</th>
              <th>WW</th>
              <th>WW</th>
              <th>WW</th>
            </tr>
          </thead>
          <tbody>
            <tr style='text-align:center;'>
              <td>SOB</td>
              <td><?php echo $q1['q1count'] ?></td>
              <td><?php echo $q2['q2count'] ?></td>
              <td><?php echo $q3['q3count'] ?></td>
              <td><?php echo $q4['q4count'] ?></td>
              <td><?php echo $first_month['firstmonth_count'] ?></td>
              <td><?php echo $second_month['secondmonth_count'] ?></td>
              <td><?php echo $third_month['thirdmonth_count'] ?></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr style='text-align:center;'>
              <td>E-Quality</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <!-- <div class="card mb-3" hidden>
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              DATA CHART</div>
            <div class="card-body">
            
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Sparks of Brilliance</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">E- Safety</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">E-Quality</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><canvas id="ChartSOB" width="100%" height="30" style="margin-top:20px;"></canvas></div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><canvas id="ChartMachine" width="100%" height="30" style="margin-top:20px;"></div>
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><canvas id="ChartWho" width="100%" height="30" style="margin-top:20px;"></div>
            </div>
              
            </div>
        </div> -->
      </div>
    </div>
  </div> <?php   
} 
include "includes/footer.php"; ?>



