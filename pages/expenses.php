<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Expenses");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(6);
  ?>
  <section class="content-header">
    <h1>
      Expenses
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

    <div class="modal fade" id="editExpenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                  Payee
                </div>
                <input type="text" class="form-control pull-right" id="new_payee" value="0">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Payee Address
                </div>
                <input type="text" class="form-control pull-right" id="new_payee_address" value="0">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Amount
                </div>
                <input type="text" class="form-control pull-right" id="new_amount" value="0">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editExpenses()">Edit</button>
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
            <a href="addExpense.php"><i class="fa fa-plus"></i> Add New Expense</a>
          </div>
          <div class="tab-content no-padding">

              <div class="box-body"style="overflow-x:auto;">
                <table id="expenseTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Expense No</th>
                    <th>Date</th>
                    <th>Payee</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Expense No</th>
                    <th>Date</th>
                    <th>Payee</th>
                    <th>Category</th>
                    <th>Amount</th>
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

var expense_id;

  function editExpenses(){

  $.ajax({
      url: '../gateway/adps.php?op=editExpenses',
      type: 'post',
      dataType: 'json',
      data: {
        'expense_id': expense_id,
        'new_date': $('#new_date').val(),
        'new_payee': $('#new_payee').val(),
        'new_amount': $('#new_amount').val()
      },
      success: function(data){
        location.reload();
      }
    });
}

$(document).on("click", ".showEditExpenses", function () {
      expense_id = $(this).data('id');
      document.getElementById("new_date").value = $(this).data('date');
      document.getElementById("new_payee").value = $(this).data('payee');
      document.getElementById("new_payee_address").value = $(this).data('address');
      document.getElementById("new_amount").value = $(this).data('amount');
    });

  function recordPayment(){
    $cc_id = -1;
    if($('#payment_method').val()==3)
      $cc_id = $('#cc_id').val();
    $.ajax({
      url: '../gateway/adps.php?op=addPaymentSales',
      type: 'post',
      data:{
        'user_id': 1,
        'expense_id': $('#modal_expense_id').text(),
        'payment_method': $('#payment_method').val(),
        'amount': $('#amount').val(),
        'trans_date': $('#expense_date').val(),
        'cc_id': $cc_id,
      },
      dataType: 'json',
      success: function(data){
        console.log(data)
        if(data.status=="success"){
          window.location.replace("expenses.php?recordPayment=1");
        }else{
          // window.location.replace("expenses.php?recordPayment=0");
        }
      }
    });
  }

  $(document).ready(function(){

      $('#new_date').datepicker({
          format: 'yyyy-mm-dd'
      });

  });

  $(function () {
    $('#payment_method').on("change",function(){
      if($('#payment_method').val()==3){
        $('#cc').css("display","block");
      }else {
        $('#cc').css("display","none");
      }
    });
    $(document).on("click", ".showRecordPayment", function () {
      var expense_id = $(this).data('id');
      $(".modal-body #modal_expense_id").html(expense_id );
    });

    $.ajax({
      url: '../gateway/adps.php?op=getExpenseList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        console.log("data")
        $('#loader').css("display","none");
        $('#expenseTable tbody').html("");
        $.each(data.result, function(i,expense)
        {

            $('#expenseTable tbody').html($('#expenseTable tbody').html()+
                                            "<tr><td><a href=expenseDetails.php?expense_id="+expense.expense_id+">"+expense.expense_id+"</a>"+
                                            "</td><td>"+expense.expense_date+
                                            "</td><td>"+expense.payee+
                                            "</td><td>"+expense.account_name+
                                            "</td><td>"+expense.amount+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showEditExpenses' data-toggle='modal' data-target='#editExpenses' data-id='"+expense.expense_id+"' data-date='"+expense.expense_date+"' data-payee='"+expense.payee+"' data-amount='"+expense.amount+"' data-address='"+expense.payee_address+"'><b>Edit</b></a></tr>");


        });
      $('#expenseTable').dataTable({
        "order": [[ 1, "asc" ]]
    });
      }
    });
  });
</script>
</body>
</html>
