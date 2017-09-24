<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Supplier List"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(3); ?>
    <section class="content-header">
      <h1>
        Add Supplier
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addSupplier'])){
          if($_GET['addSupplier']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Supplier.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Supplier Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Supplier Details</h3>
		        </div>
		        <div class="box-body">
		        	<div class="col-md-12">
			        	<div class="form-group">
		                  <label for="supplier_name">Name</label>
		                  <input type="text" class="form-control" id="supplier_name" placeholder="" required>
		                </div>
			        	<div class="form-group">
		                  <label for="address">Address</label>
		                  <input type="text" class="form-control" id="address" placeholder="" required>
		                </div>
			        	<div class="form-group">
		                  <label for="contact_number">Contact Number</label>
		                  <input type="text" class="form-control" id="contact_number" placeholder="">
		                </div>

		                <div class="form-group">
		                  <button class="btn btn-lg btn-primary col-md-12" onclick="addnewsupplier()">Add Supplier</button>
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

  });

  function addnewsupplier(){

		$.ajax({
        url: '../gateway/adps.php?op=addSupplier',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'supplier_name':$('#supplier_name').val(),
        		'address':$('#address').val(),
        		'contact_no':$('#contact_number').val()
        },
        success: function(data){
          console.log(data)
          if(data.status == "success"){
            window.location.replace("addSupplier.php?addSupplier=1");
          }else{
            window.location.replace("addSupplier.php?addSupplier=0");
          }
        }
      });
  }
</script>
</body>
</html>
