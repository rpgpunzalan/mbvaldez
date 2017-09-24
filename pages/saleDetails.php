<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['sale_id'])){
    $sale_id = $_GET['sale_id'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Sale Details"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="sale_id" value="<?php print $sale_id; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(4); ?>
    <section class="content-header">
      <h1>
        Sale Details - <?php echo $sale_id; ?>
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
                  <div class="col-md-12" style="text-align:'center';">
                    <h1>MB VALDEZ DISTRIBUTION, INC.</h1>
                    <h4>1257 Blk. 10 Lot 2 Pearl St., Ramar Village, San Agustin, City of San Fernando, Pampanga</h4>
                  </div>
                  <br />
                  <div class="col-md-12">
                    Invoice Number: <?php echo $sale_id; ?>
                  </div>
                  <div class="col-md-12">
                    Customer: <span id="customer"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Date: <span id="po_date"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Total Amount: <span id="total_amount"></span>
                  </div>
                  <!--div class="col-md-3 col-xs-6 col-sm-6">
                    Amount Paid: <span id="amount_paid"></span>
                  </div-->
                  <!--div class="col-md-3 col-xs-6 col-sm-6">
                    Balance: <span id="balance"></span>
                  </div-->
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
                      <tfoot>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>Total Sales (VAT Inclusive)</td>
                          <td><span id="vatinclusive"></span></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>Less VAT</td>
                          <td><span id="lessvat"></span></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>Amount Net of VAT</td>
                          <td><span id="netvat"></span></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>Amount Due</td>
                          <td><strong><span id="amountdue"></span></strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <br />
                <br />
                <br />
                <div class="col-md-8 col-xs-8 col-sm-8"></div>
                <div class="col-md-3 col-xs-3 col-sm-3">Received by: _________________</div>
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
      url: '../gateway/adps.php?op=getSaleById',
      type: 'get',
      dataType: 'json',
      data: {
        'sale_id': $('#sale_id').val()
      },
      success: function(data){
        $('#loader').css("display","none");
        $('#sale_items tbody').html("");
        $.each(data.result, function(i,saleDetail)
        {

          $('#customer').html(saleDetail.customer_name);
          $('#po_date').html(saleDetail.sale_date);
          $('#total_amount').html(parseFloat(saleDetail.total_amount).toFixed(2));
          $('#amount_paid').html(parseFloat(saleDetail.amount_paid).toFixed(2));
          $('#balance').html((saleDetail.total_amount-saleDetail.amount_paid).toFixed(2));

          $('#vatinclusive').html(parseFloat(saleDetail.total_amount).toFixed(2));
          $('#lessvat').html(parseFloat((saleDetail.total_amount/1.12)*.12).toFixed(2));
          $('#netvat').html(parseFloat(saleDetail.total_amount-(saleDetail.total_amount/1.12)*.12).toFixed(2));
          $('#amountdue').html(parseFloat(saleDetail.total_amount).toFixed(2));





        });

        $.each(data.items, function(i,item)
        {
          console.log(item);
          $('#sale_items tbody').html($('#sale_items tbody').html()+
                                            "<tr><td>"+item.item_description+
                                            "</td><td>"+item.quantity+
                                            "</td><td>"+parseFloat(item.amount).toFixed(2)+
                                            "</td><td>"+(item.quantity*item.amount).toFixed(2)+"</td></tr>");
        });
      }
    });
  });
</script>
</body>
</html>
