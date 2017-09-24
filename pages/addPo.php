<?php
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("New Purchase"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(3); ?>
    <section class="content-header">
      <h1>
        Add Purchase
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addPurchaseOrder'])){
          if($_GET['addPurchaseOrder']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Purchase.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Purchase Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Purchase Details</h3>
		        </div>
		        <div class="box-body">
              <div class="col-md-12">
  		        	<div>
                  <div class="form-group col-md-12">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Supplier
                      </div>
                      <select class="form-control select2" id="supplier_id" style="width: 100%;" readonly>
                        <option selected="selected" value="-1">Select Supplier</option>
                        <?php
                          $db->ddlSuppliers();
                        ?>
                        <!-- <option selected="selected" value="1">Coca Cola</option> -->
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Shipment Number
                      </div>
                      <input type="text" class="form-control" id="shipment_no" value="" />
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Invoice Number
                      </div>
                      <input type="text" class="form-control" id="po_id" value="" />
                    </div>
                  </div>
                </div>
  		        	<div>
  			        	<!-- <div class="form-group col-md-8">
                    <input type="text" class="form-control" id="address" placeholder="Address" readonly>
                  </div> -->
  			        	<div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control pull-right" id="po_date">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <th width="50%">Particulars</th>
                      <th width="10%">Quantity</th>
                      <th width="20%">Amount</th>
                      <th width="20%">Total</th>
                    </thead>
                    <?php
                    for($i=0;$i<50;$i++){
                    ?>
                      <tr>
                        <td><select class="form-control select2 particulars" style="width: 100%;">
                              <option selected="selected" value="-1">Select Item</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control quantity" value="0" placeholder=""></td>
                        <td><input type="text" class="form-control amount" value="0.00" placeholder=""></td>
                        <td><input type="text" class="form-control total" value="0.00" placeholder=""></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </table>
                </div>
                <div class="form-group">
                  <div class="form-group col-md-3">
                    <div class="input-group">
                      <div class="input-group-addon">
                        Discount
                      </div>
                      <input type="text" id="discount" class="form-control" value="0.00" />
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <div class="input-group">
                      <div class="input-group-addon">
                        Total Cases
                      </div>
                      <input type="text" id="totalcases" class="form-control" value="0.00" />
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
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="addPurchase()">Add Purchase</button>
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
    for(let i=0;i<$('.total').length;i++){
      tot = parseFloat($('.total')[i].value) + tot;
    }
    return tot;
  }
  function computeTotalCases(){
    var tot = 0;
    for(let i=0;i<$('.quantity').length;i++){
      tot = parseFloat($('.quantity')[i].value) + tot;
    }
    return tot;
  }
  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getItemBySupplier',
      type: 'post',
      dataType: 'json',
      data: {'supplier_id':$('#supplier_id').val() },
      success: function(data){
        //$('#address').val(data.supplierDetails[0].address);
        $.each(data.result, function(i,item)
        {
          $('.particulars').append("<option value='"+item.item_id+"'>"+item.item_description+"</option>");
        });

      }
    });
    $('#po_date').datepicker({
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
        $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
      }
      $('#total_amount').val(computeTotal()-$('#discount').val());
      $('#totalcases').val(computeTotalCases());
    });
    $('.amount').on("keyup",function(){
      var ind = ($(this)).index('.amount');
      if($('.quantity')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
      }
      $('#total_amount').val(computeTotal()-$('#discount').val());
      $('#totalcases').val(computeTotalCases());
    });
    $('#discount').on("keyup",function(){
      $('#total_amount').val(computeTotal()-$('#discount').val());
      $('#totalcases').val(computeTotalCases());
    });

    $('.particulars').on("change",function(){
      var ind = ($(this)).index('.particulars');
      //ind = (((ind+1)/2)-1);
      if($('.particulars').val()=="-99"){
        $('.amount')[ind].value = "0.00";
        $('.quantity')[ind].value = "0";
        $('.total')[ind].value = "0.00";
        $('#total_amount').value = "0.00";
      }else if($('.particulars').val()=="-1"){
        $('.amount')[ind].value = "0.00";
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
                $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
              }
              $('#total_amount').val(computeTotal()-$('#discount').val());
            }
          });


      }
    });

    $('#supplier_id').on("change",function(){
      $('.particulars').html('<option selected="selected" value="-1">Select Item</option><option value="-99">New Item</option>');
      if($('#supplier_id').val()=="-99"){ //new supplier
        $('#address').val("");
      }else if($('#supplier_id').val()=="-1"){ //select supplier
        $('#address').val("");
      }else{
        // $('.particulars select2').append("<option></option>");
        console.log("A")
        $.ajax({
          url: '../gateway/adps.php?op=getItemBySupplier',
          type: 'post',
          dataType: 'json',
          data: {'supplier_id':$('#supplier_id').val() },
          success: function(data){
            //$('#address').val(data.supplierDetails[0].address);
            $.each(data.result, function(i,item)
            {
              $('.particulars').append("<option value='"+item.item_id+"'>"+item.item_description+"</option>");
            });

          }
        });
      }
    });
  });

  function addPurchase(){

    var itemList = [];
    for(let i=0;i<50;i++){
      if($('.particulars')[i].value != "-1")
        itemList.push([$('.particulars')[i].value,$('.quantity')[i].value,$('.amount')[i].value]);
    }
		$.ajax({
        url: '../gateway/adps.php?op=addPurchaseOrder',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'shipment_no':$('#shipment_no').val(),
        		'supplier_id':$('#supplier_id').val(),
        		'po_id':$('#po_id').val(),
        		'po_date':$('#po_date').val(),
        		'total_amount':$('#total_amount').val(),
            'discount':$('#discount').val(),
            'itemList':itemList
        },
        success: function(data){
          console.log(data);
          if(data.status == "success"){
            window.location.replace("addPo.php?addPurchaseOrder=1");
          }else{
            // window.location.replace("addPo.php?addPurchaseOrder=0");
          }
        }
      });
  }
</script>
</body>
</html>
