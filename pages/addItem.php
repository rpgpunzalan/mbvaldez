<?php
session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("New Item"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(2); ?>
    <section class="content-header">
      <h1>
        Add Item
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addItem'])){
          if($_GET['addItem']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Item.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Item Failed.
      </div>
      <?php }}?>
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		          <h3 class="box-title">Item Details</h3>
		        </div>
		        <div class="box-body">
              <div class="col-md-12">
  		        	<div>
                  <input type="hidden" id="supplier_id" value="1" />
                </div>
  		        	<div>
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <th width="50%">Item Description</th>
                      <th width="10%">Cost</th>
                      <th width="20%">SRP</th>
                    </thead>
                    <tr>
                      <td><input type="text" class="form-control" id="item_description" placeholder=""></td>
                      <td><input type="text" class="form-control" id="cost" value="0.00" placeholder=""></td>
                      <td><input type="text" class="form-control" id="srp" value="0.00" placeholder=""></td>
                    </tr>
                  </table>
                </div>
                <div class="form-group">
                  <div class="col-md-12">
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="addItem()">Add Item</button>
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
  function addItem(){
		$.ajax({
        url: '../gateway/adps.php?op=addItem',
        type: 'post',
        dataType: 'json',
        data: {'user_id':1,
        		'supplier_id':$('#supplier_id').val(),
        		'item_description':$('#item_description').val(),
        		'cost':$('#cost').val(),
        		'srp':$('#srp').val()
        },
        success: function(data){
          console.log(data);
          if(data.status == "success"){
            window.location.replace("addItem.php?addItem=1");
          }else{
            // window.location.replace("addItem.php?addItem=0");
          }
        }
      });
  }
</script>
</body>
</html>
