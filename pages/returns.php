<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Returns");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(5);
  ?>
  <section class="content-header">
    <h1>
      Returns
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

    <div class="modal fade" id="editReturns" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit</h4>
          </div>
          <div class="modal-body">
            <div class="form-group col-md-12">
              <label>Date</label>

              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="new_date">
              </div>
              <!-- /.input group -->
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Quantity
                </div>
                <input type="text" class="form-control pull-right" id="new_quantity" value="0" onchange="updateTotal()">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Cost
                </div>
                <input type="text" class="form-control pull-right" id="new_cost" value="0" onchange="updateTotal()">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editReturns()">Edit</button>
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
            <a href="addReturn.php"><i class="fa fa-plus"></i> Add New Return</a>
          </div>
          <div class="tab-content no-padding">

              <div class="box-body"style="overflow-x:auto;">
                <table id="returnTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Return No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Area</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Return No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Area</th>
                    <th>Total Amount</th>
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
var return_id;
var item_id;

function updateTotal(){

  var am = document.getElementById("new_cost").value;
  var quan = document.getElementById("new_quantity").value;

  var totalnew = am*quan;
  //console.log(totalnew);

  //document.getElementById("new_totalamount").value = totalnew;
}

function editReturns(){

  //console.log(return_id + " ----------- " + item_id + " ----------- " + $('#new_quantity').val() + " ----------- " + $('#new_cost').val())

  $.ajax({
      url: '../gateway/adps.php?op=editReturnItems',
      type: 'post',
      dataType: 'json',
      data: {
        'return_id': return_id,
        'item_id': item_id,
        'new_quantity': $('#new_quantity').val(),
        'new_cost': $('#new_cost').val()
      },
      success: function(data){
        $.ajax({
          url: '../gateway/adps.php?op=editReturns',
          type: 'post',
          dataType: 'json',
          data: {
            'return_id': return_id,
            'new_date': $('#new_date').val()
          },
          success: function(data){
            location.reload();
          }
        });
      }
    });

    
}


  $(document).ready(function(){

      $('#new_date').datepicker({
          format: 'yyyy-mm-dd'
      });

  });

$(document).on("click", ".showEditReturns", function () {
      return_id = $(this).data('id');
      item_id = $(this).data('id2');
      document.getElementById("new_date").value = $(this).data('date');
      document.getElementById("new_cost").value = $(this).data('cost');
      document.getElementById("new_quantity").value = $(this).data('quantity');
    });

  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getReturnList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        console.log(data);
        $('#loader').css("display","none");
        $('#returnTable tbody').html("");
        $.each(data.result, function(i,sale)
        {
          $('#returnTable tbody').html($('#returnTable tbody').html()+
                                            "<tr><td><a href=returnDetails.php?return_id="+sale.return_id+">"+sale.return_id+"</a>"+
                                            "</td><td>"+sale.return_date+
                                            "</td><td>"+sale.customer_name+
                                            "</td><td>"+sale.area_name+
                                            "</td><td>"+sale.total_amount+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showEditReturns' data-toggle='modal' data-target='#editReturns' data-id='"+sale.return_id+"' data-id2='"+sale.item_id+"' data-date='"+sale.return_date+"' data-quantity='"+sale.quantity+"' data-cost='"+sale.cost+"'><b>Edit</b></a></tr>");

        });
      $('#returnTable').dataTable();
      }
    });
  });
</script>
</body>
</html>
