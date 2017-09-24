<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Add Customer"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(4); ?>
    <section class="content-header">
      <h1>
        Add Customer
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addCustomer'])){
          if($_GET['addCustomer']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Customer.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Customer Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Customer Details</h3>
		        </div>
		        <div class="box-body">
		        	<div class="col-md-12">
			        	<div class="form-group">
		                  <label for="customer_name">Name</label>
		                  <input type="text" class="form-control" id="customer_name" placeholder="" required>
		                </div>
			        	<div class="form-group">
		                  <label for="address">Address</label>
		                  <input type="text" class="form-control" id="address" placeholder="" required>
		                </div>
			        	<div class="form-group">
		                  <label for="contact_number">Contact Number</label>
		                  <input type="text" class="form-control" id="contact_no" placeholder="">
		                </div>
                <div class="form-group">
                  <label for="address">Area</label>
                  <select class="form-control select2" id="area" style="width: 100%;">
                    <?php
                      echo $db->ddlArea();
                    ?>
                  </select>
                </div><div class="form-group">
                  <label for="address">Pre Seller</label>
                  <select class="form-control select2" id="preseller" style="width: 100%;">
                    <?php
                      echo $db->ddlPresellers();
                    ?>
                  </select>
                </div>

		                <div class="form-group">
		                  <button class="btn btn-lg btn-primary col-md-12" onclick="addnewcustomer()">Add Customer</button>
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
  $(function () {
    $(".select2").select2();
  });

  function addnewcustomer(){

		$.ajax({
        url: '../gateway/adps.php?op=addCustomer',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'customer_name':$('#customer_name').val(),
        		'address':$('#address').val(),
        		'contact_no':$('#contact_no').val(),
            'area':$('#area').val(),
            'preseller':$('#preseller').val()
        },
        success: function(data){
          console.log(data)
          if(data.status == "success"){
            window.location.replace("addCustomer.php?addCustomer=1");
          }else{
            // window.location.replace("addCustomer.php?addCustomer=0");
          }
        }
      });
  }
</script>
</body>
</html>
