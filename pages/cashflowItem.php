<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  if(isset($_GET['cf_date'])){
    $cf_date = $_GET['cf_date'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php $ui->showHeadHTML("Cashflow"); ?>
  <script type="text/javascript" src="../assets/dist/jspdf.debug.js"></script>
  <script type="text/javascript" src="../assets/dist/jspdf.plugin.autotable"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<input type="hidden" id="cf_date" value="<?php print $cf_date; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(7); ?>
    <section class="content-header">
      <h1>
        Cashflow Details - <?php echo $cf_date; ?>
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
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                INFLOW
              </div>
              <div class="box-body box-profile">
                <div class="col-md-3 col-xs-6 col-sm-6">
                  Date: <span id="cf_date"><?php print $cf_date; ?></span>
                </div>
                <div class="col-md-3 col-xs-6 col-sm-6">
                  Total Amount: <span id="total_amount"></span>
                </div>
                <div class="col-md-12">
                  <table style="margin-top:30px" id="cf_items" class="table">
                    <thead>
                      <th width="50%">Particulars</th>
                      <th width="20%">Amount</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="box-body">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                OUTFLOW
              </div>
              <div class="box-body box-profile">
                <div class="col-md-3 col-xs-6 col-sm-6">
                  Date: <span id="cf_date"><?php print $cf_date; ?></span>
                </div>
                <div class="col-md-3 col-xs-6 col-sm-6">
                  Total Amount: <span id="outflowTotal"></span>
                </div>
                <div class="col-md-12">
                  <table style="margin-top:30px" id="outflowTable" class="table">
                    <thead>
                      <th width="50%">Particulars</th>
                      <th width="20%">Amount</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <button type="button" class="btn" onclick="exportAsPDF()">Export PDF</button>
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

  var inflowTotal = 0;
  var outflowTotal = 0;

  
  var columns = ["Particulars", "Amount"];
  var inflowRows = [];
  var outflowRows = [];
  var newParticular = [];

  function exportAsPDF(){
    var date = "<?php print $cf_date; ?>";

    var doc = new jsPDF();
    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(65, 30, 'Cashflow Report - '+date);

    doc.setFontSize(16);
    doc.text(20, 50, 'INFLOW');

    doc.setFontSize(14);
    doc.text(20, 60, 'Total Amount: '+inflowTotal);

    doc.autoTable(columns, inflowRows, {
        margin: {top: 65, left:20},
    });

    doc.addPage();

    doc.setFontSize(22);
    doc.text(70, 20, 'MBValdez Distribution');
    doc.setFontSize(18);
    doc.text(65, 30, 'Cashflow Report - '+date);

    doc.setFontSize(16);
    doc.text(20, 50, 'OUTFLOW');

    doc.setFontSize(14);
    doc.text(20, 60, 'Total Amount: '+outflowTotal);

    doc.autoTable(columns, outflowRows, {
        margin: {top: 65, left:20},
    });

    doc.save('Cashflow:'+date+'.pdf');
  }
  $(function () {
    $.ajax({
      url: '../gateway/adps.php?op=getCashflowListByDate',
      type: 'get',
      dataType: 'json',
      data: {
        'cf_date': $('#cf_date').val()
      },
      success: function(data){
        console.log(data)
        var totamt = 0;
        var outflowTotal = 0;
        $('#loader').css("display","none");
        $('#cf_items tbody').html("");
        $.each(data.result, function(i,cfDetails)
        {
          if(cfDetails.category==2)
          totamt += parseFloat(cfDetails.amount);
          else outflowTotal += parseFloat(cfDetails.amount);
        });
        $('#total_amount').html(parseFloat(totamt).toFixed(2));
        inflowTotal = parseFloat(totamt).toFixed(2);
        $('#outflowTotal').html(parseFloat(outflowTotal).toFixed(2));
        outflowTotal = parseFloat(outflowTotal).toFixed(2);
        $.each(data.result, function(i,item)
        {
          if(item.category==2){
            $('#cf_items tbody').html($('#cf_items tbody').html()+
                                              "<tr><td>"+item.particulars+
                                              "</td><td>"+parseFloat(item.amount).toFixed(2)+"</td></tr>");
            newParticular.push(item.particulars);
            newParticular.push(parseFloat(item.amount).toFixed(2));
            inflowRows.push(newParticular);
          }else{
            $('#outflowTable tbody').html($('#outflowTable tbody').html()+
                                              "<tr><td>"+item.particulars+
                                              "</td><td>"+parseFloat(item.amount).toFixed(2)+"</td></tr>");
            newParticular.push(item.particulars);
            newParticular.push(parseFloat(item.amount).toFixed(2));
            outflowRows.push(newParticular);
          }

        });
      }
    });
  });
</script>
</body>
</html>
