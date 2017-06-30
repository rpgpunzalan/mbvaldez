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
      
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Purchase Details</h3>
		        </div>
		        <div class="box-body">
              <div class="col-md-12">
  		        	<div>
                  <input type="hidden" id="supplier_id" value="1" />
                  <!-- <div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Supplier
                      </div>
                      <select class="form-control select2" id="supplier_id" style="width: 100%;" readonly>
                        <!<option selected="selected" value="-1">Select Supplier</option>
                        <option value="-99">New Supplier</option> >
                        <?php
                          //$db->ddlSuppliers();
                        ?>
                        <option selected="selected" value="1">Coca Cola</option>
                      </select>
                    </div>
                  </div> -->
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Shipment Number
                      </div>
                      <input type="text" class="form-control" id="shipment_no" value="" />
                    </div>
                  </div>
                  
                </div>
  		        	   
                  <div id="searchShipment"class="col-md-12">
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="searchShipment()">Search Shipment</button>
                  </div>
                  
                </div>
                <div class="table-bordered">
                    <table class="table" id="shipmentTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Amount Paid</th>
                        <th>Discount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                  </table>
                </div>
                  <div id="addPurchase" class="col-md-12" style="display: none;">
                      <div class="input-group date">
                        <p id="total_invoice"></p>
                      </div>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          Payment Amount
                        </div>
                        <input type="text" class="form-control" id="payment_amount" value="" />
                      </div>
                      <div class="input-group date">
                        <select class="form-control select2" id="payment_method" style="width: 100%;">
                          <option selected="selected" value="1">ATM Card</option>
                          <option value="2">Cash</option>
                          <option value="3">Check</option>
                        </select>
                      </div>
                      <div class="input-group date" style="display:none" id="cc">
                        <div class="input-group-addon">
                          Check Number
                        </div>
                        <input type="text" class="form-control" id="cc_id" value="" />
                      </div>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          Discount
                        </div>
                        <input type="text" class="form-control" id="discount" value="0" />
                      </div>
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="recordPayment()">Record Payment</button>
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

  var total_invoice = 0;
  var po_id = [];
  var total_amount = [];
  var amount_paid = [];

  $(function () {
     $('#payment_method').on("change",function(){
      if($('#payment_method').val()==3){
        $('#cc').css("display","block");
      }else {
        $('#cc').css("display","none");
      }
    });
  });

  function searchShipment(){

    $.ajax({
        url: '../gateway/adps.php?op=searchShipment',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
            'shipment_no':$('#shipment_no').val()
        },
        success: function(data){

          if(data.status == "success"){
            if(data.data.length > 0){
              for(var i = 0; i < data.data.length; i++){
                var table = document.getElementById("shipmentTable");
                var row = table.insertRow(1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
        
                cell1.innerHTML = data.data[i].po_id;
                cell2.innerHTML = "P " + data.data[i].total_amount;
                total_invoice = total_invoice + parseInt(data.data[i].total_amount);
                cell3.innerHTML = "P " + data.data[i].amount_paid;
                cell4.innerHTML = "P " + data.data[i].discount;
                cell5.innerHTML = data.data[i].po_date;
         
                po_id.push(parseInt(data.data[i].po_id));
                total_amount.push(parseInt(data.data[i].total_amount));
                amount_paid.push(parseInt(data.data[i].amount_paid));

        
              }
              document.getElementById("total_invoice").innerHTML= "Total invoice: " + total_invoice;

              document.getElementById("addPurchase").style.display = "block";
            }else{
              $('#shipmentTable tr').not(function(){ return !!$(this).has('th').length; }).remove();
              document.getElementById("addPurchase").style.display = "none";
            }
            //window.location.replace("addPo.php?addPurchaseOrder=1");
          }else{

          }
        }
      });
  }

  function recordPayment(){

    var balance = 0;

    var new_paid = [];

    var payment_amount = parseInt($('#payment_amount').val()) + parseInt($('#discount').val());
    
    balance =  total_invoice - parseInt($('#payment_amount').val()); 

    if(balance <= 0){
        $cc_id = -1;
        if($('#payment_method').val()==3)
          $cc_id = $('#cc_id').val();
        $.ajax({
        url: '../gateway/adps.php?op=updateZeroBalance',
        type: 'post',
        data:{'user_id':1,
            'shipment_no':$('#shipment_no').val()
        },
        dataType: 'json',
        success: function(data){
          if(data.status=="success"){
            console.log("success");
          }else{
           console.log("failed");
          }
        }
      });
    }else{


      for(var i = 0; i < total_amount.length; i++){

        if(payment_amount > 0){
          if((total_amount[i] - amount_paid[i]) <= payment_amount){
              new_paid.push(total_amount[i] - amount_paid[i]);
              payment_amount = payment_amount - (total_amount[i] - amount_paid[i]);
          }else{
              new_paid.push(payment_amount);
              payment_amount = payment_amount - payment_amount;
          }
        }else{
          new_paid.push(payment_amount);
        }
     }

     console.log(po_id);
     console.log(new_paid);

     $.ajax({
        url: '../gateway/adps.php?op=updateBalance',
        type: 'post',
        data:{'po_id':po_id,
            'new_paid':new_paid,
            'shipment_no':$('#shipment_no').val()
        },
        dataType: 'json',
        success: function(data){
          if(data.status=="success"){
            console.log(data);
          }else{
           console.log("failed");
          }
        }
      });
      

    }

  }
</script>
</body>
</html>
