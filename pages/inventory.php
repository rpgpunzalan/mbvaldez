<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $d1 = "";
  $d2 = "";
  if(isset($_GET['d1'])&&isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Inventory"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">

<div class="modal fade" id="editInventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                  Item Description
                </div>
                <input type="text" class="form-control pull-right" id="new_description" value="0">
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="input-group date">
                <div class="input-group-addon">
                  SRP
                </div>
                <input type="text" class="form-control pull-right" id="new_srp" value="0">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editInventory()">Edit</button>
          </div>
        </div>
      </div>
    </div>

<div class="wrapper">

  <?php $ui->showHeader(2); ?>
    <section class="content-header">
      <h1>
        Inventory
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
              <a href="inventoryReport.php"></i> Daily Report</a>
	      	<div class="box box-success">
		        <div class="box-header with-border">
              <a href="addItem.php"><i class="fa fa-plus"></i> Add New Item</a>
		        </div>
		        <div class="box-body">

		          <table id="inventoryTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Particulars</th>
                  <th>SRP</th>
                  <th>Supplier</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th>Particulars</th>
                  <th>SRP</th>
                  <th>Supplier</th>
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
    <section class="content-header">
      <h1>
        Empties
      </h1>
    </section>
    <section class="content">
      <div class="row">
      	<div class="col-md-12">
	      	<div class="box box-success">
		        <div class="box-header with-border">
		        </div>
		        <div class="box-body">

		          <table id="emptiesTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Particulars</th>
                  <th>Empty Bottles</th>
                  <th>Empty Cases</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $db->getEmptiesInventory();
                  ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Particulars</th>
                  <th>Empty Bottles</th>
                  <th>Empty Cases</th>
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
<?php
  $ui->showFooter();
  $ui->externalScripts();
?>
<script>

var item_id;

  function editInventory(){
  $.ajax({
      url: '../gateway/adps.php?op=editInventory',
      type: 'post',
      dataType: 'json',
      data: {
        'item_id': item_id,
        'new_description': $('#new_description').val(),
        'new_srp': $('#new_srp').val()
      },
      success: function(data){
        location.reload();
      }
    });
}

$(document).on("click", ".showEditInventory", function () {
      item_id = $(this).data('id');
      document.getElementById("new_description").value = $(this).data('description');
      document.getElementById("new_srp").value = $(this).data('srp');
    });

  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getInventory',
      type: 'get',
      dataType: 'json',
      data: {
        'd1':$('#d1').val(),
        'd2':$('#d2').val()
      },
      success: function(data){
        console.log(data)
        $('#loader').css("display","none");
        $('#inventoryTable tbody').html("");
        $.each(data.result, function(i,item)
        {
          let qty = item.quantity;
          if(item.quantity==null){
            qty = 0;
          }
          $('#inventoryTable tbody').html($('#inventoryTable tbody').html()+
                                            "<tr><td>"+item.item_description+
                                            "</td><td>"+item.display_srp+
                                            "</td><td><a href=supplierDetails.php?supplier_id="+item.supplier_id+">"+item.supplier_name+"</a>"+
                                           "</td><td><a href='#' class='btn btn-primary btn-block showEditInventory' data-toggle='modal' data-target='#editInventory' data-id='"+item.item_id+"' data-description='"+item.item_description+"' data-srp='"+item.display_srp+"'><b>Edit</b></a></tr>");
        });
      $('#inventoryTable').dataTable();
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
