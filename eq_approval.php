<?php session_start();  
if(empty($_SESSION["crs_username"]) || ($_SESSION['userType'] != 2 && $_SESSION['userType'] != 3)){
  $_SESSION['message'] = 1;
  Header("Location: logout.php"); 

  exit();
}

else {
    include "includes/header.php";?>
      <div class="container">  
        <div class="row" style="margin-top:40px;">
          <div class="col-lg-12">
            <h1 class="page-header">Pending Forms</h1>
            <hr>
          </div>
        </div>
            <div class="card sob">
              <div class="card-header">E-Quality</div>
              <div class="card-body">  
                <div class="table-responsive">
                  <table class="download table table-bordered table-hover table-refresh" width="100%" cellspacing="0">
                  <?php $currentEQ = new FinanceList();
                  $results = $currentEQ->get_current_eq(); ?>
                    <thead>
                      <tr>
                        <th>Entry No.</th>
                        <th>CID No.</th>
                        <th>Name</th>
                        <th>Ticket No.</th>
                        <th>Charging Department</th>
                        <th>Amount</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $number = 0;
                    $esLen = sizeof($results);
                    echo "<p class='total_count'>Total forms: ". $esLen ."</p>";
                    for ($i = 0 ; $i < $esLen ; $i++){
                    $number =  $number + 1;
                    echo "<tr>";
                    echo "<td>". $number ."</td>";

                    
                    if ($results[$i]['reportType'] == 1)
                    {
                      echo "<td>". $results[$i]['category'] ."</td>";
                      $assosiate = $currentEQ->associate_data($results[$i]['category']);
                      echo "<td>". $assosiate['firstName'] . " " . $assosiate['lastName'] ."</td>";
                    }
                    else
                    {
                      echo "<td>". $results[$i]['usrCIDNo'] ."</td>";
                      echo "<td>". $results[$i]['associateName'] ."</td>";  
                    }
                    
                    echo "<td>". $results[$i]['ticketNo'] ."</td>";
                    echo "<td> 564-4354 </td>";
                    echo "<td> 200 </td>";
                    echo "</tr>";
                    } ?>
                    </tbody>
                  </table>
                  </div> 
                </div>
              <div class="card-footer">
                <input class="btn btn-success eq_submit "type="submit" name="submit" value="Approved" style="float:right; margin-top:10px;">
              </div> 
            </div>
    
    <?php include "includes/footer.php";
    } ?>