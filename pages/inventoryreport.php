<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

  if(isset($_GET['d1']) && isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }else {
    $d1 = '2017-01-01';
    $d2 = date( 'Y-m-d', strtotime( 'today' ) );
  }
  $db = new adps_functions();
?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Inventory Report");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(7);
  ?>
  <section class="content-header">
    <h1>
      Inventory Report
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
      <section class="col-md-12">
        <?php

        if(isset($_GET['d1'])&&isset($_GET['d2'])){

        ?>
          <input type="hidden" value="2017-01-01" id="startDate" />
          <input type="hidden" value="<?php echo $d2; ?>" id="endDate" />
        <?php
        }
        ?>
        <div class="box box-success">
          <div class="box-header with-border">
            <div class="form-group">
              <label>Until Date:</label>

              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="date" class="form-control pull-right" id="untilDate">
              </div>
              <!-- /.input group -->
            </div>
            <button type="button" class="btn" onclick="myFunction()">Generate Inventory Report</button>
          </div>

          </div>
          <div class="table-bordered">
            <table class="table" id="inventoryTable">
            <thead>
              <tr>
                <th>Item</th>
                <th>In</th>
                <th>Out</th>
                <th>Total</th>
              </tr>
            </thead>
              <?php $db->getInventoryReport($d1,$d2); ?>
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
  $('#loader').css("display","none");
  var startDate,endDate,dataParam;

    function myFunction() {
      // console.log();
      $('#loader').css("display","block");
    dataParam = {"d1":startDate,"d2":endDate};
    window.location.href = "inventoryreport.php?d1=2017-01-01&d2="+$('#untilDate').val();
    //console.log(dataParam);
      //  $.ajax({
      //     url: '../gateway/adps.php?op=getInventoryReport',
      //     type: 'get',
      //     dataType: 'json',
      //     data:dataParam,
      //     success: function(data){
       //
      //       /*console.log(data.res[0].item_description);*/
      //       //console.log(data.items[0].item_description);
       //
      //       $('#inventoryTable tr').not(function(){ return !!$(this).has('th').length; }).remove();
       //
      //       console.log("hello");
       //
      //       for(var i = data.res.length-1; i >= 0; i--){
      //         var table = document.getElementById("inventoryTable");
      //         var row = table.insertRow(1);
      //         var cell1 = row.insertCell(0);
      //         var cell2 = row.insertCell(1);
      //         var cell3 = row.insertCell(2);
      //         var cell4 = row.insertCell(3);
      //         var cell5 = row.insertCell(4);
      //
      //
      //         for(var j = 0; j < data.items.length; j++){
      //           if(data.res[i].item_id == data.items[j].item_id){
      //             cell1.innerHTML = data.items[j].item_description;
      //           }
      //         }
      //         cell2.innerHTML = data.res[i].cost;
      //         cell3.innerHTML = data.res[i].quantity;
      //         cell4.innerHTML = "P " + data.res[i].quantity * data.res[i].cost;
      //         cell5.innerHTML = data.res[i].trans_date;
       //
      //
      //       }
       //
      //     }
      //   });
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
