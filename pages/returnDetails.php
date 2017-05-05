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

          $('#customer').html(saleDetail.customer_name);
          $('#po_date').html(saleDetail.return_date);
          $('#total_amount').html(parseFloat(saleDetail.total_amount).toFixed(2));
        });

        $.each(data.items, function(i,item)
        {
          console.log(item);
          $('#sale_items tbody').html($('#sale_items tbody').html()+
                                            "<tr><td>"+item.item_description+
                                            "</td><td>"+item.quantity+
                                            "</td><td>"+parseFloat(item.cost).toFixed(2)+
                                            "</td><td>"+(item.quantity*item.cost).toFixed(2)+"</td></tr>");
        });
      }
    });
  });
</script>
</body>
</html>
