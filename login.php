<?php session_start();?>
<?php 
if (isset($_SESSION['crs_username'])){
    
    header ('Location: index.php');
    exit();
}
?>
<!--?php include "database/db.php";?>-->
<?php include "includes/header.php"; ?>

 
                
    <div class="mx-auto">                  
        <form class="form" action="ldap_connect.php" method="post">
            <div class="card" style="width:300px; margin-top: 50%;">
                <div class="card-header"><b>Login</b></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username" class="text-info">Username:</label><br>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off">
                    </div>
                <div class="form-group">
                    <label for="password" class="text-info">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                </div>
                </div>
            </div>
            <?php
        
        if (isset($_SESSION['message']) == 1){ ?>
            
            <div class="card text-center" style="width:300px; height:70px; margin-top:10px;">
                    <div class="card-body">
                            <label class="text-center"><font color="red">Username or Password Incorrect! / Not Authorized! Please Try Again!</font></label><br>
                    </div>
            </div>
        <?php
            
            $_SESSION['message'] = null;                           
    } ?>     
        
        </form>
    </div>                  
                

   






<?php include "includes/footer.php" ?>
