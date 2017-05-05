<?php
session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("New Expense"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(6); ?>
    <section class="content-header">
      <h1>
        Add Expense
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addExpense'])){
          if($_GET['addExpense']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Expense.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Expense Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Expense Details</h3>
		        </div>
		        <div class="box-body">
              <div class="col-md-12">
  		        	<div>
                  <!-- <input type="hidden" id="customer_id" value="1" /> -->
                  <div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Payee
                      </div>
                      <input type="text" class="form form-control" id="payee" />
                    </div>
                  </div>
                </div>
  		        	<div>
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Expense Number
                      </div>
                      <input type="text" class="form-control" id="expense_id" readonly value="<?php echo $db->getMax('expenses'); ?>" />
                    </div>
                  </div>

  			        	<div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Address
                      </div>
                      <input type="text" class="form-control" id="address" value="" />
                    </div>
                  </div>
  			        	<div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="expense_date">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <th width="80%">Particulars</th>
                      <th width="20%">Amount</th>
                    </thead>
                    <?php
                    for($i=0;$i<5;$i++){
                    ?>
                      <tr>
                        <td><input type="text" class="form-control particulars" style="width: 100%;" /></td>
                        <td><input type="text" class="form-control amount" value="0.00" placeholder=""></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </table>
                </div>
                <div class="form-group">
                    <div class="form-group col-md-12">
                      <div class="input-group">
                        <div class="input-group-addon">
                          Total Amount
                        </div>
                        <input type="text" id="total_amount" readonly class="form-control" value="0.00" />
                      </div>
                    </div>
                        <div class="form-group col-md-12">
                          <div class="input-group">
                            <div class="input-group-addon">
                              Account Title
                            </div>
                            <select class="form-control select2" id="account_title" style="width: 100%;" readonly>
                              <?php
                                $db->ddlAccountTitles();
                              ?>
                            </select>
                          </div>
                        </div>
                  <div class="col-md-12">
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="addExpense()">Add Expense</button>
                  </div>
                </div>
              </div>
	        	</div>
	        <!-- /.box-body -->
	      	</div>
      	</div>
      </div>
      <!-- /.row (main row) -->

    </section>
</div>
<?php $ui->showFooter(); ?>

<?php
  $ui->externalScripts();
?>

<script>

  function computeTotal(){
    var tot = 0;
    for(let i=0;i<$('.amount').length;i++){
      console.log(tot);
      tot = parseFloat($('.amount')[i].value) + tot;
    }
    return tot;
  }
  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getItemByCustomer',
      type: 'post',
      dataType: 'json',
      data: {'customer_id':$('#customer_id').val() },
      success: function(data){
        //$('#address').val(data.customerDetails[0].address);
        $.each(data.result, function(i,item)
        {
          $('.particulars').append("<option value='"+item.item_id+"'>"+item.item_description+"</option>");
        });

      }
    });
    $('#sale_date').datepicker({
      autoclose: true
    });
    $('#check_date').datepicker({
      autoclose: true
    });
    $(".select2").select2();
    $('#terms').on("change",function(){
      if($('#terms').val()==2)
        $('#checkDetails').css("display","block");
      else {
        $('#checkDetails').css("display","none");
      }
    });

    $('.amount').on("keyup",function(){
      var ind = ($(this)).index('.amount');
      $('#total_amount').val(computeTotal());
    });
  });

  function addExpense(){
    var itemList = [];
    for(let i=0;i<5;i++){
      if($('.particulars')[i].value != "")
        itemList.push([$('.particulars')[i].value,$('.amount')[i].value]);
    }
		$.ajax({
        url: '../gateway/adps.php?op=addExpense',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'expense_id':$('#expense_id').val(),
        		'expense_date':$('#expense_date').val(),
        		'payee':$('#payee').val(),
        		'total_amount':$('#total_amount').val(),
            'address':$('#address').val(),
            'itemList':itemList,
            'account_title':$('#account_title').val()
        },
        success: function(data){
          console.log(data);
          if(data.status == "success"){
            window.location.replace("addExpense.php?addExpense=1");
          }else{
            // window.location.replace("addExpense.php?addExpense=0");
          }
        }
      });
  }
</script>
</body>
</html>
