<?php
session_start();
  if(!isset($_SESSION['user_id'])){
    header("location: login.php");
  }
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Dashboard"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(1); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Payables for this week</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="table-bordered">
            <table class="table" id="payablecollectibleTable">
            <thead>
              <tr>
                <th>Supplier</th>
                <th>Amount</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // $db->weeklyPayables(date( 'Y-m-d', strtotime( 'monday this week' ) ),date( 'Y-m-d', strtotime( 'sunday this week' ) ));
              $db->weeklyPayables(date( "2017-01-01" ),date( 'Y-m-d', strtotime( 'sunday this week' ) ));
              ?>
            </tbody>
          </table>
          </div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

        </section>
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Collectibles for this week</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="table-bordered">
            <table class="table" id="payablecollectibleTable">
            <thead>
              <tr>
                <th>Customer</th>
                <th>Amount</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // $db->weeklyCollectibles(date( 'Y-m-d', strtotime( 'monday this week' ) ),date( 'Y-m-d', strtotime( 'sunday this week' ) ));
              $db->weeklyCollectibles(date( "2017-01-01" ),date( 'Y-m-d', strtotime( 'sunday this week' ) ));
              ?>
            </tbody>
          </table>
          </div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

        </section>

      </div>
      <!-- /.row (main row) -->
    </section>
        <!-- right col -->
</div>
  <?php $ui->showFooter(); ?>

  <?php
    $ui->externalScripts();
  ?>
<script>

  var startDate,endDate,dataParam;

  $(document).ready(function(){

    // $.ajax({
    //   url: '../gateway/adps.php?op=getWeeklyPayableCollectibleReport',
    //   type: 'get',
    //   dataType: 'json',
    //   success: function(data){
    //
    //     console.log(data);
    //
    //
    //       var table = document.getElementById("payablecollectibleTable");
    //       var row = table.insertRow(1);
    //       var cell1 = row.insertCell(0);
    //       var cell2 = row.insertCell(1);
    //       var cell3 = row.insertCell(2);
    //
    //       if(data.payables == null){
    //         cell1.innerHTML = "P 0";
    //       }else{
    //         cell1.innerHTML = "P " + data.payables;
    //       }
    //
    //       if(data.collectibles == null){
    //         cell2.innerHTML = "P 0";
    //       }else{
    //         cell2.innerHTML = "P " + data.collectibles;
    //       }
    //       cell3.innerHTML = data.startDate + " to " + data.endDate;
    //
    //   }
    // });


  });
</script>
</body>
</html>
