<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Customer List"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(4); ?>
    <section class="content-header">
      <h1>
        Customers
      </h1>
    </section>

    <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                  Customer Name
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
            <button type="button" class="btn btn-primary" data-target='#recordPayment' data-toggle="modal" onclick="editCustomer()">Edit</button>
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
              <a href="addCustomer.php"><i class="fa fa-plus"></i> Add New Customer</a>
		        </div>
		        <div class="box-body">

		          <table id="customerList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Customer ID</th>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Area</th>
                  <th>Receivables</th>
                  <th>Deposits</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $db->getCustomerList(); ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Customer ID</th>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Area</th>
                  <th>Receivables</th>
                  <th>Deposits</th>
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

var customer_id;

  function editCustomer(){
  $.ajax({
      url: '../gateway/adps.php?op=editCustomer',
      type: 'post',
      dataType: 'json',
      data: {
        'customer_id': customer_id,
        'new_name': $('#new_name').val(),
        'new_address': $('#new_address').val(),
        'new_contact': $('#new_contact').val()
      },
      success: function(data){
        location.reload();
      }
    });
}

$(document).on("click", ".showEditCustomer", function () {
      customer_id = $(this).data('id');
      document.getElementById("new_name").value = $(this).data('name');
      document.getElementById("new_address").value = $(this).data('address');
      document.getElementById("new_contact").value = $(this).data('contact');
    });
  // $(function () {
  //   $.ajax({
  //     url: '../gateway/adps.php?op=getCustomerList',
  //     type: 'get',
  //     dataType: 'json',
  //     success: function(data){
  //       $('#loader').css("display","none");
  //       $('#customerList tbody').html("");
  //       for(var i=0;i<data.result.length;i++)
  //       {
  //         var customer = data.result[i];
  //         $('#customerList tbody').html($('#customerList tbody').html()+
  //                                           "<tr><td><a href=customerDetails.php?customer_id="+customer.customer_id+">"+customer.customer_name+"</a>"+
  //                                           "</td><td>"+(customer.address==null || customer.address==""  ?"-":customer.address)+
  //                                           "</td><td>"+(customer.contact_no==null || customer.contact_no==""  ?"-":customer.contact_no)+
  //                                           "</td><td>"+(customer.area_name==null || customer.area_name==""  ?"-":customer.area_name)+
  //                                           "</td><td>"+parseFloat(customer.receivables[0].receivables).toFixed(2)+
  //                                           "</td><td>"+parseFloat(customer.receivables[0].receivables).toFixed(2)+"</td></tr>");
  //       }
  //     $('#customerList').dataTable();
  //     }
  //   });
  // });
  $('#loader').css("display","none");
  $('#customerList').dataTable();

  function _calculateAge(birthday) { // birthday is a date
      var ageDifMs = Date.now() - birthday.getTime();
      var ageDate = new Date(ageDifMs); // miliseconds from epoch
      return Math.abs(ageDate.getUTCFullYear() - 1970);
  }
</script>
</body>
</html>
