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
  <?php $ui->showHeadHTML("Expenses");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(7);
  ?>
  <section class="content-header">
    <h1>
      Cash Flow
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
    <div class="modal fade" id="recordPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Record Payment</h4>
          </div>
          <div class="modal-body">
            <div class="form-group col-md-12">
              Sale Number:
              <span id="modal_expense_id"></span>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="expense_date">
              </div>
            </div>
            <div class="form-group col-md-12">
              <select class="form-control select2" id="payment_method" style="width: 100%;">
                <option value="2">Cash</option>
                <option value="3">Check</option>
              </select>
            </div>
            <div class="form-group col-md-12" style="display:none" id="cc">
              <div class="input-group date">
                <div class="input-group-addon">
                  Check Number
                </div>
                <input type="text" class="form-control pull-right" id="cc_id">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Amount
                </div>
                <input type="text" class="form-control pull-right" id="amount">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="recordPayment()">Record Payment</button>
          </div>
        </div>
      </div>
    </div>
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
          </div>
          <div class="tab-content no-padding">

              <div class="box-body"style="overflow-x:auto;">
                <table id="cashflowTable" class="table ">
                  <thead>
                  <tr>
                    <th>Date</th>
                    <th>Inflow</th>
                    <th>Outflow</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
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

  $(document).ready(function(){
    var startDate,endDate,dataParam;

    if(typeof $('#startDate').val() !="undefined"){
      dataParam = {"d1":$('#startDate').val(),"d2":$('#endDate').val()};
    }
    $.ajax({
      url: '../gateway/adps.php?op=getCashflow',
      type: 'get',
      dataType: 'json',
      data:dataParam,
      success: function(data){

        $('#loader').css("display","none");
        $('#cashflowTable tbody').html("");
        if(data.result=="empty"){
          $('#cashflowTable tbody').html("NO DATA TO SHOW");
        }else{
          for(var i=0;i<data.dateList.length;i++)
          {
            var inflow = data.inflow[i];
            var outflow = data.outflow[i];
            var dateList = data.dateList[i];
            $('#cashflowTable tbody').html($('#cashflowTable tbody').html()+
                                              "<tr><td><a href=cashflowItem.php?cf_date="+dateList+">"+dateList+"</a>"+
                                              "</td><td>"+parseFloat(inflow).toFixed(2)+
                                              "</td><td>"+parseFloat(outflow).toFixed(2)+"</td></tr>");
          }
        }

      }
    });
    if(typeof $('#startDate').val() != "undefined" && typeof $('#endDate').val()!="undefined"){

      $('#dateRange').daterangepicker({format: 'MM/DD/YYYY',startDate: new Date($('#startDate').val()),endDate: new Date($('#endDate').val())},
      function(start, end) {
         startDate = start.format('YYYY-MM-DD');
         endDate = end.format('YYYY-MM-DD');
         window.location.replace("cashflow.php?d1="+startDate+"&d2="+endDate);
      });
    }else {
      $('#dateRange').daterangepicker({format: 'MM/DD/YYYY'},
      function(start, end) {
         startDate = start.format('YYYY-MM-DD');
         endDate = end.format('YYYY-MM-DD');
         window.location.replace("cashflow.php?d1="+startDate+"&d2="+endDate);
      });
    }


  });
</script>
</body>
</html>
