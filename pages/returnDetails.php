<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['return_id'])){
    $return_id = $_GET['return_id'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Return Details"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="return_id" value="<?php print $return_id; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(5); ?>
    <section class="content-header">
      <h1>
        Return Details - <?php echo $return_id; ?>
      </h1>
    </section>


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
                  <div class="col-md-12">
                    Customer: <span id="customer"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Date: <span id="po_date"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Total Amount: <span id="total_amount"></span>
                  </div>
                  <div class="col-md-12">
                    <table style="margin-top:30px" id="sale_items" class="table">
                      <thead>
                        <th width="40%">Particulars</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Amount</th>
                        <th width="20%">Total</th>
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

    var returnDate;

    $.ajax({
      url: '../gateway/adps.php?op=getReturnById',
      type: 'get',
      dataType: 'json',
      data: {
        'return_id': $('#return_id').val()
      },
      success: function(data){
        $('#loader').css("display","none");
        $('#sale_items tbody').html("");
        $.each(data.result, function(i,saleDetail)
        {

          returnDate = saleDetail.return_date;
          return_id = saleDetail.return_id;

          $('#customer').html(saleDetail.customer_name);
          $('#po_date').html(saleDetail.return_date);
          $('#total_amount').html(parseFloat(saleDetail.total_amount).toFixed(2));
        });

        console.log(data);

        $.each(data.items, function(i,item)
        {
          console.log(item);
          $('#sale_items tbody').html($('#sale_items tbody').html()+
                                            "<tr><td>"+item.item_description+
                                            "</td><td>"+item.quantity+
                                            "</td><td>"+parseFloat(item.cost).toFixed(2)+
                                            "</td><td>"+(item.quantity*item.cost).toFixed(2)+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showEditReturns' data-toggle='modal' data-target='#editReturns' data-id='"+return_id+"' data-id2='"+item.item_id+"' data-date='"+returnDate+"' data-quantity='"+item.quantity+"' data-cost='"+item.cost+"'><b>Edit</b></a></tr>");
        });
      }
    });
  });
</script>
</body>
</html>
