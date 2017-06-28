<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

  if(isset($_GET['d1']) && isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }
  $db = new adps_functions();
?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Payable and Collectible Report");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(7);
  ?>
  <section class="content-header">
    <h1>
      Payable and Collectible Report
    </h1>
  </section>
  <!-- CONTENT HERE -->
  <!-- Main content -->
  <section class="content">
    <div class="sk-folding-cube" id="loader">
      <div class="sk-cube1 sk-cube"></div>
      <div class="sk-cube2 sk-cube"></div>
      <div class="sk-cube4 sk-cube"></div>
      <div class="sk-cube3 sk-cube"></div>
    </div>
    <?php
      if(isset($_GET['recordPayment'])){
        if($_GET['recordPayment']==1){
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      Successfully recorded a payment.
    </div>
    <?php }else{?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
      Recording Payment Failed.
    </div>
    <?php }}?>
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <section class="col-lg-6 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom">
          <!-- Tabs within a box -->
          <ul class="nav nav-tabs pull-right">
            <li class="pull-left header"><i class="fa fa-inbox"></i> Payables</li>
          </ul>
          <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <div class="table-bordered">
          <table class="table" id="payablecollectibleTable">
          <thead>
            <tr>
              <th>Supplier</th>
              <th>Due Date</th>
              <th>Amount</th>
            </tr>
          </thead>
            <?php
              $db->allPayables();
            ?>
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
            <li class="pull-left header"><i class="fa fa-inbox"></i> Collectibles</li>
          </ul>
          <div class="tab-content no-padding">
            <!-- Morris chart - Sales -->
            <div class="table-bordered">
          <table class="table" id="payablecollectibleTable">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Due Date</th>
              <th>Amount</th>
            </tr>
          </thead>
            <?php
              $db->allCollectibles();
            ?>
        </table>
        </div>
          </div>
        </div>
        <!-- /.nav-tabs-custom -->

      </section>
    </div>
  </section>
</div>
<?php
  $ui->showFooter();
  $ui->externalScripts();
?>
<script>
  $('#loader').css("display","none");
  var startDate,endDate,dataParam;

    function myFunction() {
      $('#loader').css("display","block");
    dataParam = {"d1":startDate,"d2":endDate};
    console.log(dataParam);
       $.ajax({
          url: '../gateway/adps.php?op=getPayableCollectibleReport',
          type: 'get',
          dataType: 'json',
          data:dataParam,
          success: function(data){

            console.log(data);

            var table = document.getElementById("payablecollectibleTable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            if(data.payables == null){
              cell1.innerHTML = "P 0";
            }else{
              cell1.innerHTML = "P " + data.payables;
            }

            if(data.collectibles == null){
              cell2.innerHTML = "P 0";
            }else{
              cell2.innerHTML = "P " + data.collectibles;
            }

            cell3.innerHTML = startDate + " to " + endDate;
          }
        });
  }

  $(document).ready(function(){

    if(typeof $('#startDate').val() != "undefined" && typeof $('#endDate').val()!="undefined"){

      $('#dateRange').daterangepicker({format: 'MM/DD/YYYY',startDate: new Date($('#startDate').val()),endDate: new Date($('#endDate').val())},
      function(start, end) {
         startDate = start.format('YYYY-MM-DD');
         endDate = end.format('YYYY-MM-DD');
      });
    }else {
      $('#dateRange').daterangepicker({format: 'MM/DD/YYYY'},
      function(start, end) {
         startDate = start.format('YYYY-MM-DD');
         endDate = end.format('YYYY-MM-DD');
         /*console.log(startDate);*/
      });
    }


  });
</script>
</body>
</html>
