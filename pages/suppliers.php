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

    <div class="modal fade" id="editSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
              <div class="input-group date">
                <div class="input-group-addon">
                  Supplier Name
                </div>
                <input type="text" class="form-control pull-right" id="new_name" value="0">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Address
                </div>
                <input type="text" class="form-control pull-right" id="new_address" value="0">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  Contact Number
                </div>
                <input type="text" class="form-control pull-right" id="new_contact" value="0">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editSupplier()">Edit</button>
          </div>
        </div>
      </div>
    </div>

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
                  <th>Deposit</th>
                  <th>Action</th>
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
                  <th>Deposit</th>
                  <th>Action</th>
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

var supplier_id;

function editSupplier(){
  $.ajax({
      url: '../gateway/adps.php?op=editSupplier',
      type: 'post',
      dataType: 'json',
      data: {
        'supplier_id': supplier_id,
        'new_name': $('#new_name').val(),
        'new_address': $('#new_address').val(),
        'new_contact': $('#new_contact').val()
      },
      success: function(data){
        location.reload();
      }
    });
}

$(document).on("click", ".showEditSupplier", function () {
      supplier_id = $(this).data('id');
      document.getElementById("new_name").value = $(this).data('name');
      document.getElementById("new_address").value = $(this).data('address');
      document.getElementById("new_contact").value = $(this).data('contact');
    });

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
          var supplier = data.result[i];
          var dep = "0";
          if(supplier.deposit) dep = supplier.deposit;
          $('#supplierListTable tbody').html($('#supplierListTable tbody').html()+
                                            "<tr><td><a href=supplierDetails.php?supplier_id="+supplier.supplier_id+">"+supplier.supplier_name+"</a>"+
                                            "</td><td>"+(supplier.address==null || supplier.address==""  ?"-":supplier.address)+
                                            "</td><td>"+(supplier.contact_number==null || supplier.contact_number==""  ?"-":supplier.contact_number)+
                                            "</td><td>"+parseFloat(supplier.payables[0].payables).toFixed(2)+
                                            "</td><td>"+parseFloat(dep).toFixed(2)+
                                            "</td><td><a href='#' class='btn btn-primary btn-block showEditSupplier' data-toggle='modal' data-target='#editSupplier' data-id='"+supplier.supplier_id+"' data-name='"+supplier.supplier_name+"' data-address='"+supplier.address+"' data-contact='"+supplier.contact_number+"'><b>Edit</b></a></tr>");
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
