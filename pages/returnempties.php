<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $db = new adps_functions();
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Return Empty"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

  <?php $ui->showHeader(5); ?>
    <section class="content-header">
      <h1>
        Return Empty
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_GET['addReturn'])){
          if($_GET['addReturn']==1){
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Successfully added a new Return.
      </div>
      <?php }else{?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        Adding a new Return Failed.
      </div>
      <?php }}?>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Return Details</h3>
            </div>
            <div class="box-body">
              <div class="col-md-12">
                <div>
                  <!-- <input type="hidden" id="customer_id" value="1" /> -->
                  <div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Customer
                      </div>
                      <select class="form-control select2" id="customer_id" style="width: 100%;" readonly>
                        <option selected="selected" value="-1">Select Customer</option>
                        <option value="-99">New Customer</option>
                        <?php
                          $db->ddlCustomers();
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div>
                  <!-- <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Return Number
                      </div>
                      <input type="text" class="form-control" id="return_id" readonly value="<?php echo $db->getMax('return_empty'); ?>" />
                    </div>
                  </div> -->

                  <div class="form-group col-md-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        Address
                      </div>
                      <input type="text" class="form-control" readonly id="customer_address" value="" />
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="<?php echo date('Y-m-d'); ?>" class="form-control pull-right" id="return_date">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <th width="50%">Particulars</th>
                      <th width="25%"># of Bottle</th>
                      <th width="25%"># of Case</th>
                    </thead>
                    <?php
                    for($i=0;$i<10;$i++){
                    ?>
                      <tr>
                        <td><select class="form-control select2 particulars" style="width: 100%;">
                              <option selected="selected" value="-1">Select Item</option>
                              <?php
                                $db->ddlAllItems();
                              ?>
                            </select>
                        </td>
                        <td><input type="text" id="num_bottle" class="form-control num_bottle" value="0" placeholder=""></td>
                        <td><input type="text" id="num_case" class="form-control num_case" value="0" placeholder=""></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </table>
                </div>
                <div class="form-group">
                  <div class="form-group col-md-6">

                  </div>

                  <div class="col-md-12">
                      <button class="btn btn-lg btn-primary col-md-12 col-sm-12 col-xs-12" onclick="addReturnEmpty()">Return Empty</button>
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

  function computeTotal(){
    var tot = 0;
    for(let i=0;i<$('.total').length;i++){
      tot = parseFloat($('.total')[i].value) + tot;
    }
    return tot;
  }
  $(function () {
    $('#sale_date').datepicker({
      autoclose: true
    });
    $('#check_date').datepicker({
      autoclose: true
    });
    $(".select2").select2();
    $('#terms').on("change",function(){
      if($('#terms').val()==2)
        $('#checkDetails').css("display","block");
      else {
        $('#checkDetails').css("display","none");
      }
    });

    $('.quantity').on("keyup",function(){
      var ind = ($(this)).index('.quantity');
      if($('.amount')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
      }
      $('#total_amount').val(computeTotal().toFixed(2));
    });
    $('.amount').on("keyup",function(){
      var ind = ($(this)).index('.amount');
      if($('.quantity')[ind].value != ""){
        $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
      }
      $('#total_amount').val(computeTotal().toFixed(2));
    });
    $('#discount').on("keyup",function(){
      $('#total_amount').val(computeTotal().toFixed(2));
    });

    $('.particulars').on("change",function(){

      var ind = ($(this)).index('.particulars');
      //ind = (((ind+1)/2)-1);
      if($('.particulars').val()=="-99"){
        $('.amount')[ind].value = "0.00";
        $('.quantity')[ind].value = "0";
        $('.total')[ind].value = "0.00";
        $('#total_amount').value = "0.00";
      }else if($('.particulars').val()=="-1"){
        $('.amount')[ind].value = "0.00";
        $('.quantity')[ind].value = "0";
        $('.total')[ind].value = "0.00";
        $('#total_amount').value = "0.00";
      }else{

        $.ajax({
            url: '../gateway/adps.php?op=getItemById',
            type: 'post',
            dataType: 'json',
            data: {'item_id':$('.particulars')[ind].value},
            success: function(data){
              $.each(data.result, function(i,item)
              {
                $('.amount')[ind].value = item.display_srp;
                $('.quantity')[ind].value = 1;
                $('.total')[ind].value = item.display_srp;
              });
              if($('.amount')[ind].value != ""){
                $('.total')[ind].value = ($('.quantity')[ind].value*$('.amount')[ind].value).toFixed(2);
              }
              $('#total_amount').val(computeTotal().toFixed(2));
            }
          });




      }
    });

    $('#customer_id').on("change",function(){
      if($('#customer_id').val()=="-99"){ //new customer
        $('#address').val("");
      }else if($('#customer_id').val()=="-1"){ //select customer
        $('#address').val("");
      }else{

        $.ajax({
          url: '../gateway/adps.php?op=getCustomerByID',
          type: 'post',
          dataType: 'json',
          data: {'customer_id':$('#customer_id').val() },
          success: function(data){
            //$('#address').val(data.customerDetails[0].address);
            $.each(data.result, function(i,customer)
            {
              $('#customer_address').val(customer.address);
            });

          }
        });
        // $('.particulars select2').append("<option></option>");
      }
    });
  });

  function addReturnEmpty(){
    var itemList = [];
    var bottleList = [];
    var caseList = [];

    for(let i=0;i<10;i++){
      if($('.particulars')[i].value != "-1")
        itemList.push([$('.particulars')[i].value,$('.num_bottle')[i].value,$('.num_case')[i].value]);
    }

    /*console.log($('#return_id').val());
    console.log($('#return_date').val());
    console.log($('#customer_id').val());
    console.log(itemList);*/

    $.ajax({
        url: '../gateway/adps.php?op=addReturnEmpty',
        type: 'post',
        data: {'user_id':1,
            'return_date':$('#return_date').val(),
            'customer_id':$('#customer_id').val(),
            'itemList':itemList
        },
        success: function(data){
          window.location.replace("returnempties.php?addReturnEmpty=1");
        }
      });

  }
</script>
</body>
</html>
