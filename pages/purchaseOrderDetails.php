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
                        <th width="20%">Amount</th>
                        <th width="20%">Total</th>
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
                                            "</td><td>"+(item.quantity*item.cost).toFixed(2)+"</td></tr>");
        });
      $('#inventoryTable').dataTable();
      }
    });
  });
</script>
</body>
</html>
