<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
 $db = new adps_functions();
?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Sales");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(4);
  ?>
  <section class="content-header">
    <h1>
      Sales
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
              <span id="modal_sale_id"></span>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="sale_date">
              </div>
            </div>
            <div class="form-group col-md-12">
              <select class="form-control select2" id="payment_method" style="width: 100%;">
                <option value="2">Cash</option>
                <option value="3">Check</option>
              </select>
            </div>
            <div class="form-group col-md-12" style="display:none" id="bankid">
              <div class="input-group date">
                <div class="input-group-addon">
                  Bank
                </div>
                <select class="form-control select2" id="bank_id" style="width: 100%;">
                  <?php $db->ddlBanks(); ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-12" style="display:none" id="cc">
              <div class="input-group date">
                <div class="input-group-addon">
                  Check Number
                </div>
                <input type="text" class="form-control pull-right" id="cc_id">
              </div>
            </div>
            <div class="form-group col-md-12" style="display:none" id="check_date1">
              <div class="input-group date">
                <div class="input-group-addon">
                  Check Date
                </div>
                <input type="date" class="form-control pull-right" id="check_date">
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

        <div class="box box-success">
          <div class="box-header with-border">
            <a href="addSale.php"><i class="fa fa-plus"></i> Add New Sale</a>
          </div>
          <div class="tab-content no-padding">

              <div class="box-body"style="overflow-x:auto;">
                <table id="saleOrderTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sale No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Area</th>
                    <th>Total Amount</th>
                    <th>Balance</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sale No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Area</th>
                    <th>Total Amount</th>
                    <th>Balance</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
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
  function recordPayment(){
    $cc_id = -1;
    if($('#payment_method').val()==3)
      $cc_id = $('#cc_id').val();
      $bank_id = $('#bank_id').val();
      $check_date = $('#check_date').val();
    $.ajax({
      url: '../gateway/adps.php?op=addPaymentSales',
      type: 'post',
      data:{
        'user_id': 1,
        'sale_id': $('#modal_sale_id').text(),
        'payment_method': $('#payment_method').val(),
        'amount': $('#amount').val(),
        'trans_date': $('#sale_date').val(),
        'cc_id': $cc_id,
        'bank_id': $bank_id,
        'check_date': $bank_id
      },
      dataType: 'json',
      success: function(data){
        console.log(data)
        if(data.status=="success"){
          window.location.replace("sales.php?recordPayment=1");
        }else{
          // window.location.replace("sales.php?recordPayment=0");
        }
      }
    });
  }
  $(function () {
    $('#payment_method').on("change",function(){
      if($('#payment_method').val()==3){
        $('#cc').css("display","block");
        $('#bankid').css("display","block");
        $('#check_date1').css("display","block");
      }else {
        $('#cc').css("display","none");
        $('#bankid').css("display","none");
        $('#check_date1').css("display","none");
      }
    });
    $(document).on("click", ".showRecordPayment", function () {
      var sale_id = $(this).data('id');
      $(".modal-body #modal_sale_id").html(sale_id );
    });

    $.ajax({
      url: '../gateway/adps.php?op=getSaleOrderList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        $('#loader').css("display","none");
        $('#saleOrderTable tbody').html("");
        $.each(data.result, function(i,sale)
        {
          if((sale.total_amount-sale.amount_paid)>0)
            $('#saleOrderTable tbody').html($('#saleOrderTable tbody').html()+
                                            "<tr><td><a href=saleDetails.php?sale_id="+sale.sale_id+">"+sale.sale_id+"</a>"+
                                            "</td><td>"+sale.sale_date+
                                            "</td><td>"+sale.customer_name+
                                            "</td><td>"+sale.area_name+
                                            "</td><td>"+sale.total_amount+
                                            "</td><td>"+(sale.total_amount-sale.amount_paid)+
                                            "</td><td>"+sale.due_date+
                                            "</td><td>"+sale.status_name+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showRecordPayment' data-toggle='modal' data-target='#recordPayment' data-id='"+sale.sale_id+"'><b>Record Collection</b></a></tr>");

          else {
            $('#saleOrderTable tbody').html($('#saleOrderTable tbody').html()+
                                              "<tr><td><a href=saleDetails.php?sale_id="+sale.sale_id+">"+sale.sale_id+"</a>"+
                                              "</td><td>"+sale.sale_date+
                                              "</td><td>"+sale.customer_name+
                                              "</td><td>"+sale.area_name+
                                              "</td><td>"+sale.total_amount+
                                              "</td><td>"+(sale.total_amount-sale.amount_paid)+
                                              "</td><td>"+sale.due_date+
                                              "</td><td>"+sale.status_name+
                                              "</td><td>-</td></tr>");
          }
        });
      $('#saleOrderTable').dataTable({
          "order": [[ 1, "asc" ]]
      });
      }
    });
  });
</script>
</body>
</html>
