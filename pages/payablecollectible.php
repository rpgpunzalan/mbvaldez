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
  <script type="text/javascript" src="../assets/dist/jspdf.debug.js"></script>
  <script type="text/javascript" src="../assets/dist/jspdf.plugin.autotable"></script>
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
          <table class="table" id="payableTable">
          <thead>
            <tr>
              <th>Supplier</th>
              <th>Due Date</th>
              <th>Amount</th>
            </tr>
          </thead>
            <?php
              $total = $db->allPayables();
            ?>
        </table>
        </div>
          </div>

        </div>
        <!-- /.nav-tabs-custom -->
        <button type="button" class="btn" onclick="exportAsPDF1()">Export PDF</button>
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
          <table class="table" id="collectibleTable">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Due Date</th>
              <th>Amount</th>
            </tr>
          </thead>
            <?php
              $total2 = $db->allCollectibles();
            ?>
        </table>
        </div>
          </div>
        </div>
        <!-- /.nav-tabs-custom -->
        <button type="button" class="btn" onclick="exportAsPDF2()">Export PDF</button>
      </section>
    </div>
  </section>
</div>
<?php
  $ui->showFooter();
  $ui->externalScripts();
?>
<script>

  var payableRows = [];
  var collectibleRows = [];
  var newRow = [];

  function exportAsPDF1(){
    var columns = ["Supplier", "Due Date", "Amount"];
    var tbl = document.getElementById("payableTable");
    var total = "<?php print $total; ?>";

    var numRows = tbl.rows.length;
    console.log(numRows);
    for (var i = 1; i < numRows-1; i++) {
        var ID = tbl.rows[i].id;
        var cells = tbl.rows[i].getElementsByTagName('td');
        for (var ic=0,it=cells.length;ic<it;ic++) {
            // alert the table cell contents
            // you probably do not want to do this, but let's just make
            // it SUPER-obvious  that it works :)
            newRow.push(cells[ic].innerHTML);
        }
        payableRows.push(newRow);
        newRow = [];
    }

    var doc = new jsPDF();
    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(82, 30, 'Payables Report');

    doc.setFontSize(16);
    doc.text(20, 45, 'Total Amount: '+total);

    doc.autoTable(columns, payableRows, {
        margin: {top: 55, left:20},
    });

    doc.save('PayablesReport.pdf');
  }

  function exportAsPDF2(){
    var columns = ["Customer", "Due Date", "Amount"];
    var tbl = document.getElementById("collectibleTable");
    var total = "<?php print $total2; ?>";

    var numRows = tbl.rows.length;
    console.log(numRows);
    for (var i = 1; i < numRows-1; i++) {
        var ID = tbl.rows[i].id;
        var cells = tbl.rows[i].getElementsByTagName('td');
        for (var ic=0,it=cells.length;ic<it;ic++) {
            // alert the table cell contents
            // you probably do not want to do this, but let's just make
            // it SUPER-obvious  that it works :)
            newRow.push(cells[ic].innerHTML);
        }
        collectibleRows.push(newRow);
        newRow = [];
    }

    var doc = new jsPDF();
    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(82, 30, 'Collectibles Report');

    doc.setFontSize(16);
    doc.text(20, 45, 'Total Amount: '+total);

    doc.autoTable(columns, collectibleRows, {
        margin: {top: 55, left:20},
    });

    doc.save('CollectiblesReport.pdf');
  }

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
