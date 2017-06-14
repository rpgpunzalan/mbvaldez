<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

  if(isset($_GET['d1']) && isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }
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
    <!-- <div class="sk-folding-cube" id="loader">
      <div class="sk-cube1 sk-cube"></div>
      <div class="sk-cube2 sk-cube"></div>
      <div class="sk-cube4 sk-cube"></div>
      <div class="sk-cube3 sk-cube"></div>
    </div> -->
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
      <section class="col-md-12">
        <?php

        if(isset($_GET['d1'])&&isset($_GET['d2'])){

        ?>
          <input type="hidden" value="<?php echo $d1; ?>" id="startDate" />
          <input type="hidden" value="<?php echo $d2; ?>" id="endDate" />
        <?php
        }
        ?>
        <div class="box box-success">
          <div class="box-header with-border">
            <div class="form-group">
              <label>Date range:</label>

              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="dateRange">
              </div>
              <!-- /.input group -->
            </div>
            <button type="button" class="btn" onclick="myFunction()">Generate Payable and Collectible Report</button>
          </div>

          </div>
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
        <!-- /.nav-tabs-custom -->

      <!-- /.Left col -->
    <!-- /.row (main row) -->
  </section>
</div>
<?php
  $ui->showFooter();
  $ui->externalScripts();
?>
<script>

  var startDate,endDate,dataParam;

    function myFunction() {

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

              cell1.innerHTML = "P " + data.payables; 
              cell2.innerHTML = "P " + data.collectibles; 
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
