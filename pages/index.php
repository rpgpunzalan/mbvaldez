<?php
session_start();
  if(!isset($_SESSION['user_id'])){
    header("location: login.php");
  }
  include "../utils/functions.php";
  $ui = new ui_functions();
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
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> Weekly Summary</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="table-bordered">
            <table class="table" id="payablecollectibleTable">
            <thead>
              <tr>
                <th>Payables</th>
                <th>Collectibles</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <tr id="item">
                
              </tr>
              <tr id="cost">
                
              </tr>
              <tr id="date">
               
              </tr>
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

    $.ajax({
      url: '../gateway/adps.php?op=getWeeklyPayableCollectibleReport',
      type: 'get',
      dataType: 'json',
      success: function(data){

        console.log(data);


          var table = document.getElementById("payablecollectibleTable");
          var row = table.insertRow(1);
          var cell1 = row.insertCell(0);
          var cell2 = row.insertCell(1);
          var cell3 = row.insertCell(2);

          cell1.innerHTML = "P " + data.payables; 
          cell2.innerHTML = "P " + data.collectibles; 
          cell3.innerHTML = startDate + " to " + endDate;

      }
    });


  });
</script>
</body>
</html>
