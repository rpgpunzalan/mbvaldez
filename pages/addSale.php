<?php
session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("New Sale"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(4); ?>
    <section class="content-header">
      <h1>
        Add Sale
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
      <?php
        if(isset($_GET['addSaleOrder'])){
          if($_GET['addSaleOrder']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Sale (SALE # <?php print $_GET['sale_id'];?>).
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Sale Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Sale Details</h3>
		        </div>
		        <div class="box-body">
              <div class="col-md-12">
  		        	<div>
                  <!-- <input type="hidden" id="customer_id" value="1" /> -->
                  <div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Customer
                      </div>
                      <select class="form-control select2" id="customer_id" style="width: 100%;" readonly>
                        <option selected="selected" value="-1">Select Customer</option>
                        <!-- <option value="-99">New Customer</option> -->
                        <?php
                          $db->ddlCustomers();
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
  		        	<div>
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Sale Number
                      </div>
                      <input type="text" class="form-control" id="sale_id" readonly value="<?php echo $db->getMax('sales'); ?>" />
                    </div>
                  </div>

  			        	<div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Address
                      </div>
                      <input type="text" class="form-control" readonly id="customer_address" value="" />
                    </div>
                  </div>
  			        	<div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="sale_date">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <th width="1%"></th>
                      <th width="50%">Particulars</th>
                      <th width="10%">Quantity</th>
                      <th width="15%">Amount</th>
                      <th width="10%">Promo</th>
                      <th width="20%">Total</th>
                    </thead>
                    <?php
                    for($i=0;$i<50;$i++){
                    ?>
                      <tr>
                        <td><span onclick="refreshParticulars(<?php echo $i ?>);"><i class="fa fa-refresh" /></span></td>
                        <td><select class="form-control select2 particulars" style="width: 100%;">
                              <option selected="selected" value="-1">Select Item</option>
                              <?php
                                $db->ddlAllItems();
                              ?>
                            </select>
                        </td>
                        <td><input type="text" class="form-control quantity" value="0" placeholder=""></td>
                        <td><input type="text" class="form-control amount" value="0.00" placeholder="" readonly></td>
                        <td><input type="text" class="form-control promo" value="0.00" placeholder=""></td>
                        <td><input type="text" class="form-control total" value="0.00" placeholder="" readonly></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </table>
                </div>
                <div class="form-group">
                  <div class="form-group col-md-6">
                    <div class="input-group">
                      <div class="input-group-addon">
                        Discount
                      </div>
                      <input type="text" id="discount" class="form-control" value="0.00" />
                    </div>
                  </div>

                    <div class="form-group col-md-6">
                      <div class="input-group">
                        <div class="input-group-addon">
                          Total Amount
                        </div>
                        <input type="text" id="total_amount" readonly class="form-control" value="0.00" />
                      </div>
                    </div>
                  <div class="col-md-12">
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="addSale()">Add Sale</button>
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
  function refreshParticulars(xx){
    $($('.particulars')[xx]).empty();
   $.ajax({
        url: '../gateway/adps.php?op=getItems',
        type: 'post',
        dataType: 'json',
        success: function(data){
          console.log(data);
              $($('.particulars')[xx]).append("<option selected=\"selected\" value=\"-1\">Select Item</option>");
           $.each(data.result, function(i,item)
            {
              $($('.particulars')[xx]).append("<option value='"+item.item_id+"'>"+item.item_description+"</option>");
            });
        }
      });
  }
  function computeTotal(){
    var tot = 0;
    for(let i=0;i<$('.total').length;i++){
      console.log(tot);
      tot = parseFloat($('.total')[i].value) + tot;
    }
    return tot;
  }
  $(function () {
    $('#loader').css("display","none");
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

    $('.quantity').on("keyup",function(){
      var ind = ($(this)).index('.quantity');
      if($('.amount')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*($('.amount')[ind].value)-($('.promo')[ind].value*$('.quantity')[ind].value)).toFixed(2);
      }
      $('#total_amount').val(computeTotal()-$('#discount').val());
    });
    $('.promo').on("keyup",function(){
      var ind = ($(this)).index('.promo');
      if($('.promo')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*($('.amount')[ind].value)-($('.promo')[ind].value*$('.quantity')[ind].value)).toFixed(2);
      }else{
        $('.total')[ind].value = ($('.quantity')[ind].value*($('.amount')[ind].value)-($('.promo')[ind].value*$('.quantity')[ind].value)).toFixed(2);
      }
      $('#total_amount').val(computeTotal()-$('#discount').val());
    });
    $('.amount').on("keyup",function(){
      var ind = ($(this)).index('.amount');
      if($('.quantity')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*($('.amount')[ind].value)-($('.promo')[ind].value*$('.quantity')[ind].value)).toFixed(2);
      }
      $('#total_amount').val(computeTotal()-$('#discount').val());
    });
    $('#discount').on("keyup",function(){
      $('#total_amount').val(computeTotal()-$('#discount').val());
    });

    $('.particulars').on("change",function(){

      var ind = ($(this)).index('.particulars');
      //ind = (((ind+1)/2)-1);
      if($('.particulars').val()=="-99"){
        $('.amount')[ind].value = "0.00";
        $('.promo')[ind].value = "0.00";
        $('.quantity')[ind].value = "0";
        $('.total')[ind].value = "0.00";
        $('#total_amount').value = "0.00";
      }else if($('.particulars').val()=="-1"){
        $('.amount')[ind].value = "0.00";
        $('.promo')[ind].value = "0.00";
        $('.quantity')[ind].value = "0";
        $('.total')[ind].value = "0.00";
        $('#total_amount').value = "0.00";
      }else{

        $.ajax({
            url: '../gateway/adps.php?op=getItemById',
            type: 'post',
            dataType: 'json',
            data: {'item_id':$('.particulars')[ind].value},
            success: function(data){
              $.each(data.result, function(i,item)
              {
                $('.amount')[ind].value = item.display_srp;
                $('.quantity')[ind].value = 1;
                $('.total')[ind].value = item.display_srp;
              });
              if($('.amount')[ind].value != ""){
                $('.total')[ind].value = ($('.quantity')[ind].value*($('.amount')[ind].value)-($('.promo')[ind].value*$('.quantity')[ind].value)).toFixed(2);
              }
              $('#total_amount').val(computeTotal()-$('#discount').val());
            }
          });




      }
    });

    $('#customer_id').on("change",function(){
      if($('#customer_id').val()=="-99"){ //new customer
        $('#address').val("");
      }else if($('#customer_id').val()=="-1"){ //select customer
        $('#address').val("");
      }else{

        $.ajax({
          url: '../gateway/adps.php?op=getCustomerByID',
          type: 'post',
          dataType: 'json',
          data: {'customer_id':$('#customer_id').val() },
          success: function(data){
            //$('#address').val(data.customerDetails[0].address);
            $.each(data.result, function(i,customer)
            {
              $('#customer_address').val(customer.address);
            });

          }
        });
        // $('.particulars select2').append("<option></option>");
      }
    });
  });

  function addSale(){
    $('#loader').css("display","block");
    var itemList = [];
    for(let i=0;i<50;i++){
      if($('.particulars')[i].value != "-1")
        itemList.push([$('.particulars')[i].value,$('.quantity')[i].value,($('.amount')[i].value-($('.promo')[i].value))]);
    }
		$.ajax({
        url: '../gateway/adps.php?op=addSale',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'sale_id':$('#sale_id').val(),
        		'sale_date':$('#sale_date').val(),
        		'customer_id':$('#customer_id').val(),
        		'total_amount':$('#total_amount').val(),
            'discount':$('#discount').val(),
            'itemList':itemList
        },
        success: function(data){
          console.log(data);
          if(data.status == "success"){
            window.location.replace("addSale.php?addSaleOrder=1&sale_id="+data.sale_id);
          }else{
            window.location.replace("addSale.php?addSaleOrder=0");
          }
        }
      });
  }
</script>
</body>
</html>
