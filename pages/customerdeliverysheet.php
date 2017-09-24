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
  <?php $ui->showHeadHTML("Customer Delivery Sheet");?>
  <script type="text/javascript" src="../assets/dist/jspdf.debug.js"></script>
  <script type="text/javascript" src="../assets/dist/jspdf.plugin.autotable"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(4);
  ?>
  <section class="content-header">
    <h1>
      Customer Delivery Sheet
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
            <button type="button" class="btn" onclick="myFunction()">Generate</button>
          </div>

          </div>
          <div class="table-bordered">
            <table class="table" id="cds" style="line-height: 8px;">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Pre=seller</th>
                  <th>Area</th>
                  <th>Sale ID</th>
                  <th>Quantity</th>
                  <th>Amount</th>
                  <th>Return Item</th>
                  <th>Return Amount</th>
                  <th>Amount Paid</th>
                  <th>Amount Unpaid</th>
                </tr>
              </thead>
                <?php
                  $db->cds($d1,$d2);
                ?>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th><span id="totalqty1"></span></th>
                  <th><span id="totalamt"></span></th>
                  <th><span id="totalret"></span></th>
                  <th><span id="totalretamt"></span></th>
                  <th><span id="totalamtpaid"></span></th>
                  <th><span id="totalamtunpaid"></span></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <button type="button" class="btn" onclick="exportAsPDF()">Export PDF</button>
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
   $('#cds').dataTable({
          "order": [[ 1, "asc" ]],
          "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            var totalQty = 0;
            var totalamt = 0;
            var totalret = 0;
            var totalretamt = 0;
            var totalamtpaid = 0;
            var totalamtunpaid = 0;

            console.log(api.column(8,{page:'current'}).data())
            for (var i = 0; i < api.column(3,{page:'current'}).data().length; i++) {

              totalQty += parseInt((api.column(4,{page:'current'}).data()[i]).replace(",",""));
              totalamt += parseFloat((api.column(5,{page:'current'}).data()[i]).replace(",",""));
              totalret += parseInt((api.column(6,{page:'current'}).data()[i]).replace(",",""));
              totalretamt += parseFloat((api.column(7,{page:'current'}).data()[i]).replace(",",""));
              totalamtpaid += parseFloat((api.column(8,{page:'current'}).data()[i]).replace(",",""));
              totalamtunpaid += parseFloat((api.column(9,{page:'current'}).data()[i]).replace(",",""));
            }
            console.log(totalamtunpaid)
            $('#totalqty1').html(totalQty);
            $('#totalamt').html(parseFloat(totalamt).toFixed(2));
            $('#totalret').html(totalret);
            $('#totalretamt').html(parseFloat(totalretamt).toFixed(2));
            $('#totalamtpaid').html(parseFloat(totalamtpaid).toFixed(2));
            $('#totalamtunpaid').html(parseFloat(totalamtunpaid).toFixed(2));
           }

      });
  var cdsRows = [];
  var newRow = [];


  function exportAsPDF(){
    var date1 = "<?php print $d1; ?>";
    var date2 = "<?php print $d2; ?>";

    var columns = ["Customer", "Date", "Quantity", "Amount", "Return Item", "Return Amount"];
    var tbl = document.getElementById("cds");

    var numRows = tbl.rows.length;
    console.log(numRows);
    for (var i = 1; i < numRows; i++) {
        //var ID = tbl.rows[i].id;
        var cells = tbl.rows[i].getElementsByTagName('td');
        for (var ic=0,it=cells.length;ic<it;ic++) {
            // alert the table cell contents
            // you probably do not want to do this, but let's just make
            // it SUPER-obvious  that it works :)
            newRow.push(cells[ic].innerHTML);
        }
        cdsRows.push(newRow);
        newRow = [];
    }

    var doc = new jsPDF();
    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(73, 30, 'Customer Deliver Sheet');

    doc.autoTable(columns, cdsRows, {
        margin: {top: 55, left:20},
    });

    doc.save('CDS:' + date1 + 'to' + date2 +'.pdf');
  }

  $('#loader').css("display","none");
  var startDate,endDate,dataParam;

  var netsales, cost, grossprofit, expenses, operating_income, net_income;

  function myFunction() {
    $('#loader').css("display","block");
    window.location.href="customerdeliverysheet.php?d1="+startDate+"&d2="+endDate;
  }
  //
  //   dataParam = {"d1":startDate,"d2":endDate};
  //
  //   $.ajax({
  //     url: '../gateway/adps.php?op=getIncomeStatement',
  //     type: 'get',
  //     dataType: 'json',
  //     data:dataParam,
  //     success: function(data){
  //
  //       if(data.netsales == null){
  //         netsales = 0;
  //       }else{
  //         netsales = data.netsales;
  //       }
  //
  //       if(data.cost == null){
  //         cost = 0;
  //       }else{
  //         cost = data.cost;
  //       }
  //
  //       if(data.expenses == null){
  //         expenses = 0;
  //       }else{
  //         expenses = data.expenses;
  //       }
  //
  //       grossprofit = netsales - cost;
  //       net_income = grossprofit - expenses;
  //
  //       var row = document.getElementById("monthyear");
  //       var x = row.insertCell(1);
  //       x.innerHTML = startDate + " to " + endDate;
  //
  //       var row = document.getElementById("netsales");
  //       var x = row.insertCell(1);
  //       x.innerHTML = "P " + netsales;
  //
  //       var row = document.getElementById("cost");
  //       var x = row.insertCell(1);
  //       x.innerHTML = "P " + cost;
  //
  //       var row = document.getElementById("grossprofit");
  //       var x = row.insertCell(1);
  //       x.innerHTML = "P " + grossprofit;
  //
  //       var row = document.getElementById("expenses");
  //       var x = row.insertCell(1);
  //       x.innerHTML = "P " + expenses;
  //
  //       var row = document.getElementById("net_income");
  //       var x = row.insertCell(1);
  //       x.innerHTML = "P " + net_income;
  //
  //     }
  //   });

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
