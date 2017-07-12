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
  <?php $ui->showHeadHTML("Income Statement");?>
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
      Income Statement
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
            <button type="button" class="btn" onclick="myFunction()">Generate Income Statement</button>
          </div>

          </div>
          <div class="table-bordered">
            <table class="table">
              <tbody style="border-color: black;">
                <?php $sales = $db->getSales($d1,$d2);
                    $cos = $db->getCostOfSales($d1,$d2);
                    $expenses = $db->getExpenses($d1,$d2);
                 ?>
                <tr id="monthyear">
                  <th scope="row">Duration</th>
                  <td><?php echo $d1 . " to " . $d2; ?></td>
                </tr>
                <tr id="netsales">
                  <th scope="row">Sales</th>
                  <td><?php print print number_format($sales,2); ?></td>
                </tr>
                <tr id="cost">
                  <th scope="row">Cost of Sales</th>
                  <td><?php print print number_format($cos,2);; ?></td>
                </tr>
                <tr id="grossprofit">
                  <th scope="row"><u>Gross Profit</u></th>
                  <td><?php print number_format($sales-$cos,2); ?></td>
                </tr>
                <tr id="expenses">
                  <th scope="row">Expenses</th>
                  <td><?php print number_format($expenses,2); ?></td>
                </tr>
                <tr id="net_income">
                  <th scope="row"><u>Net Income/Loss</u></th>
                  <td><?php print number_format(($sales-$cos)-$expenses,2); ?></td>
                </tr>
              </tbody>
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

  function exportAsPDF(){
    var date1 = "<?php print $d1; ?>";
    var date2 = "<?php print $d2; ?>";
    var sales = "<?php print print number_format($sales,2); ?>";
    var cos = "<?php print print number_format($cos,2);; ?>";
    var gp = "<?php print number_format($sales-$cos,2); ?>";
    var expenses = "<?php print number_format($expenses,2); ?>";
    var netincome = "<?php print number_format(($sales-$cos)-$expenses,2); ?>";

    var doc = new jsPDF();
    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(73, 30, 'Income Statement Report');

    doc.setFontSize(16);
    doc.text(20, 60, 'Duration: ');
    doc.setFontSize(14);
    doc.text(70, 60, date1 + ' to ' + date2);

    doc.setFontSize(16);
    doc.text(20, 70, 'Sales: ');
    doc.setFontSize(14);
    doc.text(70, 70, sales);

    doc.setFontSize(16);
    doc.text(20, 80, 'Cost of Sales: ');
    doc.setFontSize(14);
    doc.text(70, 80, cos);

    doc.setFontSize(16);
    doc.text(20, 90, 'Gross Profit: ');
    doc.setFontSize(14);
    doc.text(70, 90, gp);

    doc.setFontSize(16);
    doc.text(20, 100, 'Expenses: ');
    doc.setFontSize(14);
    doc.text(70, 100, expenses);

    doc.setFontSize(16);
    doc.text(20, 110, 'Net Income/Loss: ');
    doc.setFontSize(14);
    doc.text(70, 110, netincome);

    doc.save('IncomeStatement:' + date1 + 'to' + date2 +'.pdf');
  }

  $('#loader').css("display","none");
  var startDate,endDate,dataParam;

  var netsales, cost, grossprofit, expenses, operating_income, net_income;

  function myFunction() {
    $('#loader').css("display","block");
    window.location.href="incomestatement.php?d1="+startDate+"&d2="+endDate;
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
