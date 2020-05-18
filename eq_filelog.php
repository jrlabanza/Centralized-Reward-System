<?php session_start();  
if(empty($_SESSION["crs_username"]) || ($_SESSION['userType'] != 2 && $_SESSION['userType'] != 3)){
  $_SESSION['message'] = 1;
  Header("Location: logout.php"); 

  exit();
  } 
  
else {

  include "includes/header.php"; ?>
      <form method="post">
      <!-- Trigger the modal with a button -->

      <!-- Modal -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content text-center">
            <div class="modal-header">
              <h4 class="modal-title text-center">DATE FILTER</h4>
            </div>
            <div class="modal-body">
              <h5><p>From:</p></h5>
              <input type="date" class="form-control" style="width:60%; margin:auto;" name="startDate">
              <h5><p>To:</p></h5>
              <input type="date" class="form-control" style="width:60%; margin:auto;" name="endDate">
            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary mr-auto" name="search" value="SEARCH DATE">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      </form>
        
    <div class="container">  
      <div class="row" style="margin-top:40px;">
        <div class="col-lg-12">
          <h1 class="page-header">File Log</h1>
          
          <hr>
        </div>
      </div>
    
        
          <div class="card sob">
            <div class="card-header">E-Quality
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">Filter Record</button></div>
            <div class="card-body">  
              <div class="table-responsive">
                <table class="download table table-bordered table-hover" width="100%" cellspacing="0">
                  <?php $machineObj = new FinanceList();
                  $sob_results = $machineObj->show_eq_log(); ?>
                  <thead>
                    <tr>
                      <th>Batch No.</th>
                      <th>Recorded Date</th>
                      <th>CID No.</th>
                      <th>Name</th>
                      <th>Amount</th>
                      <!-- <th>Charging Department</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  
                  $machineLen = sizeof($sob_results);
                  echo "<p>Total forms: ". $machineLen ."</p>";
                  for ($i = 0 ; $i < $machineLen ; $i++){
                  echo "<tr>";
                  echo "<td>BATCH# ". $sob_results[$i]['batch_no'] ."</td>";
                  echo "<td>". $sob_results[$i]['finDate'] ."</td>";
                  echo "<td>". $sob_results[$i]['usrCIDNo'] ."</td>";
                  echo "<td>". $sob_results[$i]['associateName'] ."</td>";
                  echo "<td> 200 </td>";
                  // echo "<td>". $sob_results[$i]['dept_num'] ."</td>";
                  echo "</tr>";
                  }
                  ?>
                  
                  </tbody>
                </table>
                </div> 
              </div>
            <div class="card-footer">
            
            </div> 
          </div>

  
<?php include "includes/footer.php"; 
}
?> 
  




