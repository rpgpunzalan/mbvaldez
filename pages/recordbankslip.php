<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();

  if(isset($_GET['d1']) && isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }
?>
<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Record Bank Slip");?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php
    $ui->showHeader(7);
  ?>
  <section class="content-header">
    <h1>
      Record Bank Slip
    </h1>
  </section>
  <!-- CONTENT HERE -->
  <!-- Main content -->
  <section class="content">
    <!-- <div class="sk-folding-cube" id="loader">
      <div class="sk-cube1 sk-cube"></div>
      <div class="sk-cube2 sk-cube"></div>
      <div class="sk-cube4 sk-cube"></div>
      <div class="sk-cube3 sk-cube"></div>
    </div> -->
    <?php
      if(isset($_GET['recordPayment'])){
        if($_GET['recordPayment']==1){
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      Successfully recorded a payment.
    </div>
    <?php }else{?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
      Recording Payment Failed.
    </div>
    <?php }}?>
    <!-- Main row -->
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Type
      <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#" onclick="showWithdraw()">Withdraw</a></li>
        <li><a href="#" onclick="showDeposit()">Deposit</a></li>
      </ul>
    </div>

    <div class="row" id="deposit">
      <section class="content-header">
        <h3>
          Record Deposit
        </h3>
      </section>
      <form>
        <div class="form-group"> <!-- Date input -->
          <label class="control-label" for="dateDeposit">Date</label>
          <input class="form-control" id="dateDeposit" name="date" placeholder="MM/DD/YYY" type="text"/>
        </div>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Type
          <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="showCheck()">Check</a></li>
            <li><a href="#" onclick="hideCheck()">Cash</a></li>
          </ul>
        </div>
        <div id="checkForm" style="display: none;">
          <div class="form-group">
            <label for="checknumber">Check number:</label>
            <input type="text" class="form-control" id="checknumber">
          </div>
          <div class="form-group"> <!-- Date input -->
            <label class="control-label" for="checkdate">Check Date:</label>
            <input class="form-control" id="checkdate" name="date" placeholder="MM/DD/YYY" type="text"/>
          </div>
        </div>
        <div class="form-group">
          <label for="bankacctDeposit">Bank Account Number:</label>
          <input type="text" class="form-control" id="bankacctDeposit">
        </div>
        <div class="form-group">
          <label for="amountDeposit">Amount:</label>
          <input type="text" class="form-control" id="amountDeposit">
        </div>
        <button class="btn btn-default" onclick="recordDeposit()">Submit</button>
      </form>
    </div>

    <div class="row" id="withdraw" style="display: none;">
      <section class="content-header">
        <h3>
          Record Withdraw
        </h3>
      </section>
      <form>
        <div class="form-group"> <!-- Date input -->
          <label class="control-label" for="dateWithdraw">Date</label>
          <input class="form-control" id="dateWithdraw" name="date" placeholder="MM/DD/YYY" type="text"/>
        </div>
        <div class="form-group">
          <label for="bankacctWithdraw">Bank Account Number:</label>
          <input type="text" class="form-control" id="bankacctWithdraw">
        </div>
        <div class="form-group">
          <label for="amountWithdraw">Amount:</label>
          <input type="text" class="form-control" id="amountWithdraw">
        </div>
        <input type="button" class="btn btn-primary btnSeccion" id="submitWithdraw" value="Submit" onclick="recordWithdraw()"/>
      </form>
    </div>
        <!-- /.nav-tabs-custom -->

      <!-- /.Left col -->
    <!-- /.row (main row) -->
  </section>
</div>
<?php
  $ui->showFooter();
  $ui->externalScripts();
?>
<script>

  function recordDeposit() {
    if($('#checkForm').css('display') == 'block')
    {
        //do something
    }
    else
    {
         dataParam = {"d1":$("#dateDeposit").val(),"d2":$("#bankacctDeposit").val().trim(),"d3":$("#amountDeposit").val().trim()};
        console.log(dataParam);
        $.ajax({
          url: '../gateway/adps.php?op=recordDeposit',
          type: 'get',
          dataType: 'json',
          data:dataParam,
          success: function(data){

            /*console.log(data.res[0].item_description);*/
            //console.log(data.items[0].item_description);

            console.log("Success");

          }
        });
    }
    
  }

  function recordWithdraw() {
     dataParam = {"d1":$("#dateWithdraw").val(),"d2":$("#bankacctWithdraw").val().trim(),"d3":$("#amountWithdraw").val().trim()};
    console.log(dataParam);
       $.ajax({
          url: '../gateway/adps.php?op=recordWithdraw',
          type: 'get',
          dataType: 'json',
          data:dataParam,
          success: function(data){

            /*console.log(data.res[0].item_description);*/
            //console.log(data.items[0].item_description);

            console.log("Success");

          }
        });
  }

  function hideCheck() {
    var x = document.getElementById('checkForm');
    x.style.display = 'none';
  }

  function showCheck() {
    var x = document.getElementById('checkForm');
    x.style.display = 'block';
  }

  function showWithdraw() {
    var x = document.getElementById('withdraw');
    x.style.display = 'block';

    var y = document.getElementById('deposit');
    y.style.display = 'none';
  }

  function showDeposit() {
    var x = document.getElementById('deposit');
    x.style.display = 'block';

    var y = document.getElementById('withdraw');
    y.style.display = 'none';
  }
  $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'mm/dd/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
</body>
</html>
