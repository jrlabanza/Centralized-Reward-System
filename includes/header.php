<?php 

  date_default_timezone_set('Asia/Manila');
  $getdate = date("Y-m-d H:i:s");

  require_once("Handler/model/FinanceList.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.min.css"/>
    <link href="node_modules/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="node_modules/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/fixedColumns.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/fixedHeader.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="css/css.css" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Centralized Reward System </title>

   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

<a class="navbar-brand mr-1" href="index.php">Centralized Rewards System</a>



<!-- Navbar -->
<ul class="navbar-nav d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php isset($_SESSION["crs_username"]) ? $isHidden = "" : $isHidden = "hidden"; echo $isHidden; ?>>
      <?php
        if (isset($_SESSION["crs_username"])){ 
            echo "WELCOME ";
            echo $_SESSION["firstname"];
        } 
       ?> 
      <i class="fas fa-cog fa-fw"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#"hidden>Settings</a>
      <a class="dropdown-item" href="#" hidden>Activity Log</a>
      <div class="dropdown-divider" hidden></div>
      <a class="dropdown-item" href="logout.php">Logout</a>
    </div>
  </li>
</ul>
</nav>
<div id="wrapper">    
         <!-- Sidebar -->
         <ul class="sidebar navbar-nav">
            <div class="nav-item active dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; margin-right: 30px;" >
                    <i class="fas fa-fw fa-star"></i>
                    <span>Sparks of Brilliance</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="sob_approval.php"><i class="fas fa-thumbs-up mr-1"></i>For Approval</a>
                  <a class="dropdown-item" href="sob_filelog.php"><i class="fas fa-history mr-1"></i>History Log</a>
                  <a class="dropdown-item" href="data-extract.php"><i class="fas fa-history mr-1"></i>Data Extraction</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; margin-right: 30px;" >
                    <i class="fas fa-fw fa-exclamation"></i>
                    <span>E-Safety</span> 
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="es_fixed_approval.php"><i class="fas fa-thumbs-up mr-1"></i>Pending Confirm</a>
                    <a class="dropdown-item" href="es_approval.php"><i class="fas fa-thumbs-up mr-1"></i>Finance Approval</a>
                    <a class="dropdown-item" href="es_filelog.php"><i class="fas fa-history mr-1"></i>History Log [FN]</a>
                  
                </div>
            </div>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white; margin-right: 30px;" >
                    <i class="fas fa-fw fa-table"></i>
                    <span>E-Quality</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="eq_fixed_approval.php"><i class="fas fa-thumbs-up mr-1"></i>Pending Confirm</a>
                    <a class="dropdown-item" href="eq_approval.php"><i class="fas fa-thumbs-up mr-1"></i>Finance Approval</a>
                    <a class="dropdown-item" href="eq_filelog.php"><i class="fas fa-history mr-1"></i>History Log [FN]</a>
                </div>
            </div>

        </ul>
             
</head>
<body>