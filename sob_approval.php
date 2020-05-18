<?php session_start();

if(empty($_SESSION["crs_username"]) || ($_SESSION['userType'] != 2 && $_SESSION['userType'] != 3)){
  $_SESSION['message'] = 1;
  Header("Location: logout.php"); 

  exit();
}

else {
    include "includes/header.php";
    $getTime = new FinanceList();
    $fromTime = $getTime->get_last_approved_sob_form();

    ?>
      
      <div class="container">  
        <div class="row" style="margin-top:40px;">
          <div class="col-lg-12">
            <h1 class="page-header">Pending Forms</h1>
            <hr>
          </div>
        </div>
          <input type="text" value="<?php echo $getdate ?>" id="getdate" hidden>
            <div class="card sob">
              <div class="card-header">Sparks of Brilliance <p style="float: right;">Affected forms are from: <?php echo $fromTime['fin_date']; ?> to <?php echo $getdate ?></p></div>
              <div class="card-body">  
                <div class="table-responsive">
                  <table class="download table table-bordered table-hover table-refresh" width="100%" cellspacing="0">
                  <?php $machineObj = new FinanceList();
                  $results = $machineObj->get_current_sob(); ?>
                    <thead>
                      <tr>
                        <th>CID No.</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Charging Department</th>
                        <th>Validation Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    $machineLen = sizeof($results);
                    echo "<p class='total_count'>Total forms: ". $machineLen ."</p>";
                    for ($i = 0 ; $i < $machineLen ; $i++){
                    echo "<tr>";
                    echo "<td>". $results[$i]['user_CID_num'] ."</td>";
                    echo "<td>". $results[$i]['associate_name'] ."</td>";
                    echo "<td>". $results[$i]['rec_amount'] ."</td>";
                    echo "<td>". $results[$i]['dept_num'] ."</td>";
                    echo "<td>". $results[$i]['valid_date'] ."</td>";
                    echo "</tr>";
                    }
 
                    ?>

                    </tbody>
                  </table>
                  </div> 
                </div>
              <div class="card-footer">
                <input class="btn btn-success sob_submit "type="submit" name="submit" value="Approved" style="float:right; margin-top:10px;">
              </div> 
            </div>
    
    <?php include "includes/footer.php";
    } ?>



