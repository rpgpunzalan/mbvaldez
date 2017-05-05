<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
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
        Suppliers
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
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
              <a href="addSupplier.php"><i class="fa fa-plus"></i> Add New Supplier</a>
		        </div>
		        <div class="box-body">

		          <table id="supplierListTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Supplier Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Payables</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th>Supplier Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Payables</th>
                </tr>
                </tfoot>
              </table>
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
    $.ajax({
      url: '../gateway/adps.php?op=getSupplierList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        $('#loader').css("display","none");
        $('#supplierListTable tbody').html("");
        for(var i=0;i<data.result.length;i++)
        {
          var supplier = data.result[0];
          $('#supplierListTable tbody').html($('#supplierListTable tbody').html()+
                                            "<tr><td><a href=supplierDetails.php?supplier_id="+supplier.supplier_id+">"+supplier.supplier_name+"</a>"+
                                            "</td><td>"+(supplier.address==null || supplier.address==""  ?"-":supplier.address)+
                                            "</td><td>"+(supplier.contact_number==null || supplier.contact_number==""  ?"-":supplier.contact_number)+
                                            "</td><td>"+parseFloat(supplier.payables[0].payables).toFixed(2)+"</td></tr>");
        }
      $('#supplierListTable').dataTable();
      }
    });
  });

  function _calculateAge(birthday) { // birthday is a date
      var ageDifMs = Date.now() - birthday.getTime();
      var ageDate = new Date(ageDifMs); // miliseconds from epoch
      return Math.abs(ageDate.getUTCFullYear() - 1970);
  }
</script>
</body>
</html>
