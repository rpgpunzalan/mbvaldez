<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['expense_id'])){
    $expense_id = $_GET['expense_id'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Expense Details"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="expense_id" value="<?php print $expense_id; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(6); ?>
    <section class="content-header">
      <h1>
        Expense Details - <?php echo $expense_id; ?>
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
                  <div class="col-md-6">
                    Payee: <span id="payee"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Date: <span id="expense_date"></span>
                  </div>
                  <div class="col-md-6">
                    Address: <span id="address"></span>
                  </div>
                  <div class="col-md-3 col-xs-6 col-sm-6">
                    Total Amount: <span id="total_amount"></span>
                  </div>
                  <div class="col-md-12">
                    <table style="margin-top:30px" id="expense_items" class="table">
                      <thead>
                        <th width="80%">Particulars</th>
                        <th width="20%">Amount</th>
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
      url: '../gateway/adps.php?op=getExpenseById',
      type: 'get',
      dataType: 'json',
      data: {
        'expense_id': $('#expense_id').val()
      },
      success: function(data){

        $('#loader').css("display","none");
        $('#expense_items tbody').html("");
        $.each(data.result, function(i,expenseDetail)
        {

          $('#payee').html(expenseDetail.payee);
          $('#expense_date').html(expenseDetail.expense_date);
          $('#address').html(expenseDetail.payee_address);
          $('#total_amount').html(parseFloat(expenseDetail.amount).toFixed(2));
        });

        $.each(data.items, function(i,item)
        {
          $('#expense_items tbody').html($('#expense_items tbody').html()+
                                            "<tr><td>"+item.particulars+
                                            "</td><td>"+parseFloat(item.amount).toFixed(2)+"</td></tr>");
        });
      }
    });
  });
</script>
</body>
</html>
