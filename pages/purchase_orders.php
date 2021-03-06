<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Purchase Invoice Confirmation Slips");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(3);
  ?>
  <section class="content-header">
    <h1>
      Purchase Invoice Confirmation Slips
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
              OCS Number:
              <span id="modal_po_id"></span>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="po_date">
              </div>
            </div>
            <div class="form-group col-md-12">
              <select class="form-control select2" id="payment_method" style="width: 100%;">
                <option selected="selected" value="1">ATM Card</option>
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

        <div class="box box-success">
          <div class="box-header with-border">
            <a href="addPO.php"><i class="fa fa-plus"></i> Add New PICS</a>
          </div>
          <div class="tab-content no-padding">

              <div class="box-body"style="overflow-x:auto;">
                <table id="purchaseOrderTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Shipment Number</th>
                    <th>Invoice Number</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Total Qty</th>
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
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th><span id="totalqty1"></span></th>
                      <th><span id="totalamt"></span></th>
                      <th><span id="totalbal"></span></th>
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
    $.ajax({
      url: '../gateway/adps.php?op=addPayment',
      type: 'post',
      data:{
        'user_id': 1,
        'po_id': $('#modal_po_id').text(),
        'payment_method': $('#payment_method').val(),
        'amount': $('#amount').val(),
        'trans_date': $('#po_date').val(),
        'cc_id': $cc_id,
      },
      dataType: 'json',
      success: function(data){
        if(data.status=="success"){
          window.location.replace("purchase_orders.php?recordPayment=1");
        }else{
          window.location.replace("purchase_orders.php?recordPayment=0");
        }
      }
    });
  }
  $(function () {
    $('#payment_method').on("change",function(){
      if($('#payment_method').val()==3){
        $('#cc').css("display","block");
      }else {
        $('#cc').css("display","none");
      }
    });
    $(document).on("click", ".showRecordPayment", function () {
      var po_id = $(this).data('id');
      $(".modal-body #modal_po_id").html(po_id );
    });

    $.ajax({
      url: '../gateway/adps.php?op=getPurchaseOrderList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        $('#loader').css("display","none");
        $('#purchaseOrderTable tbody').html("");
        $.each(data.result, function(i,po)
        {
          if((po.total_amount-po.amount_paid)>0)
            $('#purchaseOrderTable tbody').html($('#purchaseOrderTable tbody').html()+
                                            "<tr><td>"+ po.shipment_no +"</td>"+
                                            "<td><a href=purchaseOrderDetails.php?po_id="+po.po_id+">"+po.po_id+"</a>"+
                                            "</td><td>"+po.supplier_name+
                                            "</td><td>"+po.po_date+
                                            "</td><td>"+po.total_qty+
                                            "</td><td>"+po.total_amount+
                                            "</td><td>"+(po.total_amount-po.amount_paid).toFixed(2)+
                                            "</td><td>"+po.due_date+
                                            "</td><td>"+po.status_name+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showRecordPayment' data-toggle='modal' data-target='#recordPayment' data-id='"+po.po_id+"'><b>Record Payment</b></a></tr>");

          else {
            $('#purchaseOrderTable tbody').html($('#purchaseOrderTable tbody').html()+
                                              "<tr><td>"+ po.shipment_no +"</td>"+
                                              "<td><a href=purchaseOrderDetails.php?po_id="+po.po_id+">"+po.po_id+"</a>"+
                                              "</td><td>"+po.supplier_name+
                                              "</td><td>"+po.po_date+
                                              "</td><td>"+po.total_qty+
                                              "</td><td>"+po.total_amount+
                                              "</td><td>"+(po.total_amount-po.amount_paid).toFixed(2)+
                                              "</td><td>"+po.due_date+
                                              "</td><td>"+po.status_name+
                                              "</td><td>-</td></tr>");
          }
        });
      $('#purchaseOrderTable').dataTable({
        buttons: [ 'excel' ],
        order: [[ 1, "asc" ]],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            var totalQty = 0;
            var totalamt = 0;
            var totalbal = 0;

            for (var i = 0; i < api.column(4,{page:'current'}).data().length; i++) {

              totalQty += parseInt((api.column(4,{page:'current'}).data()[i]).replace(",",""));
              totalamt += parseFloat((api.column(5,{page:'current'}).data()[i]).replace(",",""));
              totalbal += parseFloat((api.column(6,{page:'current'}).data()[i]).replace(",",""));
            }
            $('#totalqty1').html(totalQty);
            $('#totalamt').html(parseFloat(totalamt).toFixed(2));
            $('#totalbal').html(parseFloat(totalbal).toFixed(2));
           }  
    });
      }
    });
  });
</script>
</body>
</html>
