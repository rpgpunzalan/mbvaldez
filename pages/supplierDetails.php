<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['supplier_id'])){
    $supplier_id = $_GET['supplier_id'];
  }
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Supplier Details"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="supplier_id" value="<?php print $supplier_id; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(3); ?>
    <section class="content-header">
      <h1>
        Supplier Details
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
	        <div class="box-body">
            <div class="col-md-3">
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <!-- <img class="profile-user-img img-responsive img-circle" id="profpic" src=""> -->

                  <h3 class="profile-username text-center" id="fullname"></h3>
                  <p class="text-muted text-center" id="address_display">Address</p>
                  <p class="text-muted text-center" id="contact_number_display">Contact Number</p>

                  <ul class="list-group list-group-unbordered" id="latestVitals1">

                  </ul>

                  <!-- <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#vitalsModal"><b>New PO</b></a>
                  <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#complaintsModal"><b>New Payment</b></a> -->
                </div>
                <!-- /.box-body -->
              </div>

            </div>
              <div class="col-md-9">

                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h6 class="box-title">Payables</h6>

                  </div>
                  <div class="box-body" id="vitalsHistory">
                    <table class="table table-bordered">
                      <thead>
                        <th>Date</th>
                        <th>Due Date</th>
                      </thead>
                      <?php $db->getSupplierPayables($supplier_id); ?>
                    </table>
                  </div>
                </div>

                <!-- <div class="box box-primary">
                  <div class="box-header with-border">
                    <h6 class="box-title">Transaction History</h6>

                  </div>
                </div> -->


              </div>
            </div>
          </div>
      </section>
</div>
<?php $ui->showFooter(); ?>

<?php
  $ui->externalScripts();
?>
<script>
  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getSupplierByID',
      type: 'post',
      dataType: 'json',
      data: {'supplier_id':$('#supplier_id').val()},
      success: function(data){
        $('#loader').css("display","none");
        $('#supplierListTable tbody').html("");
        $.each(data.result, function(i,supplier)
        {
          $('#fullname').html(supplier.supplier_name);
          $('#address_display').html(supplier.address);
          $('#contact_number_display').html(supplier.contact_number);
        });
      }
    });
  });
</script>
</body>
</html>
