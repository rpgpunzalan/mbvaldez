<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['po_id'])){
    $po_id = $_GET['po_id'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Supplier Details"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="po_id" value="<?php print $po_id; ?>" />


<div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
              OCS Number:
              <span id="modal_po_id"></span>
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
                  Amount
                </div>
                <input type="text" class="form-control pull-right" id="new_amount" value="0" onchange="updateTotal()">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Total Amount
                </div>
                <input type="text" class="form-control pull-right" id="new_totalamount" value="0" readonly>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editPayment()">Edit</button>
          </div>
        </div>
      </div>
    </div>

<div class="wrapper">

  <?php $ui->showHeader(3); ?>
    <section class="content-header">
      <h1>
        OCS Details - <?php echo $po_id; ?>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="sk-folding-cube" id="loader">
        <div class="sk-cube1 sk-cube"></div>
        <div class="sk-cube2 sk-cube"></div>
        <div class="sk-cube4 sk-cube"></div>
        <div class="sk-cube3 sk-cube"></div>
      </div>
        <div class="row">
	        <div class="box-body">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Date: <span id="po_date"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Total Amount: <span id="total_amount"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Amount Paid: <span id="amount_paid"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Balance: <span id="balance"></span>
                  </div>
                  <div class="col-md-12">
                    <table style="margin-top:30px" id="po_items" class="table">
                      <thead>
                        <th width="50%">Particulars</th>
                        <th width="10%">Quantity</th>
                        <th width="15%">Amount</th>
                        <th width="15%">Total</th>
                        <th width="10%">Action</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
          </div>
        </div>
      </section>
</div>
<?php $ui->showFooter(); ?>

<?php
  $ui->externalScripts();
?>
<script>

var po_id2;
var item_id;

function updateTotal(){

  var am = document.getElementById("new_amount").value;
  var quan = document.getElementById("new_quantity").value;

  var totalnew = am*quan;
  //console.log(totalnew);

  document.getElementById("new_totalamount").value = totalnew;
}

function editPayment(){
  $.ajax({
      url: '../gateway/adps.php?op=editPurchaseOrder',
      type: 'post',
      dataType: 'json',
      data: {
        'po_id': $('#po_id').val(),
        'new_amount': $('#new_amount').val(),
        'new_quantity': $('#new_quantity').val(),
        'item_id': item_id
      },
      success: function(data){
        location.reload();
      }
    });
}


$(document).on("click", ".showEditPayment", function () {
      item_id = $(this).data('id');
      document.getElementById("new_amount").value = $(this).data('amount');
      document.getElementById("new_quantity").value = $(this).data('quan');
      document.getElementById("new_totalamount").value = $(this).data('quan') * $(this).data('amount');
      $(".modal-body #modal_po_id").html(po_id2);
    });

  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getPurchaseOrderById',
      type: 'get',
      dataType: 'json',
      data: {
        'po_id': $('#po_id').val()
      },
      success: function(data){
        $('#loader').css("display","none");
        $('#po_items tbody').html("");
        $.each(data.result, function(i,poDetail)
        {
          console.log(poDetail);
          $('#po_date').html(poDetail.po_date);
          $('#total_amount').html(parseFloat(poDetail.total_amount).toFixed(2));
          $('#amount_paid').html(parseFloat(poDetail.amount_paid).toFixed(2));
          $('#balance').html((poDetail.total_amount-poDetail.amount_paid).toFixed(2));
        });

        $.each(data.items, function(i,item)
        {
          $('#po_items tbody').html($('#po_items tbody').html()+
                                            "<tr><td>"+item.item_description+
                                            "</td><td>"+item.quantity+
                                            "</td><td>"+parseFloat(item.cost).toFixed(2)+
                                            "</td><td>"+(item.quantity*item.cost).toFixed(2)+"</td><td><a href='#' class='btn btn-primary btn-block showEditPayment' data-toggle='modal' data-target='#editPayment' data-id='"+item.item_id+"' data-quan='"+item.quantity+"' data-amount='"+item.cost+"'><b>Edit</b></a></tr>");
        });
      $('#inventoryTable').dataTable();
      }
    });
  });
</script>
</body>
</html>
