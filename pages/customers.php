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
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Area</th>
                  <th>Receivables</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Area</th>
                  <th>Receivables</th>
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
      url: '../gateway/adps.php?op=getCustomerList',
      type: 'get',
      dataType: 'json',
      success: function(data){
        $('#loader').css("display","none");
        $('#customerList tbody').html("");
        for(var i=0;i<data.result.length;i++)
        {
          var customer = data.result[i];
          $('#customerList tbody').html($('#customerList tbody').html()+
                                            "<tr><td><a href=customerDetails.php?customer_id="+customer.customer_id+">"+customer.customer_name+"</a>"+
                                            "</td><td>"+(customer.address==null || customer.address==""  ?"-":customer.address)+
                                            "</td><td>"+(customer.contact_no==null || customer.contact_no==""  ?"-":customer.contact_no)+
                                            "</td><td>"+(customer.area_name==null || customer.area_name==""  ?"-":customer.area_name)+
                                            "</td><td>"+parseFloat(customer.receivables[0].receivables).toFixed(2)+"</td></tr>");
        }
      $('#customerList').dataTable();
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
