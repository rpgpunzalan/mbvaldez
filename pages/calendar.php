<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MedRP | Add New Patient</title>
  <?php
    if(isset($_GET['patientId'])){
      $patient_id = $_GET['patientId'];

    }
  ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="../assets/AdminLTE-Master/plugins/fullcalendar/fullcalendar.print.css" media="print">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<input type="hidden" id="patientId" value="<?php print $patient_id; ?>" />
<div class="wrapper">

  <?php $ui->showHeader(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Calendar</li>
      </ol>
    </section>
    <br />
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title">Draggable Events</h4>
            </div>
            <div class="box-body">
              <!-- the events -->

              <p>
                <img src="../assets/images/trashcan.png" id="trash" alt="">
              </p>
              <div id="external-events">
                <!--div class='draggable external-event bg-green' data-event='{"title":"Appointment","backgroundColor":"#00A65A"}' >Appointment</div-->
                <!--div class="checkbox">
                  <label for="drop-remove">
                    <input type="checkbox" id="drop-remove">
                    remove after drop
                  </label>
                </div-->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Create Event</h3>
            </div>
            <div class="box-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                <ul class="fc-color-picker" id="color-chooser">
                  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                </ul>
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                <div class="input-group-btn">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                </div>
                <!-- /btn-group -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2017 <a href="http://rpgpunzalan.com">medRP</a>.</strong> All rights
    reserved.
  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../assets/AdminLTE-Master/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../assets/AdminLTE-Master/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../assets/AdminLTE-Master/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="../assets/AdminLTE-Master/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../assets/AdminLTE-Master/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../assets/AdminLTE-Master/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../assets/AdminLTE-Master/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="../assets/AdminLTE-Master/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../assets/AdminLTE-Master/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../assets/AdminLTE-Master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../assets/AdminLTE-Master/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../assets/AdminLTE-Master/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../assets/AdminLTE-Master/dist/js/app.min.js"></script>
<script src="../assets/AdminLTE-Master/plugins/fullcalendar/fullcalendar.min.js"></script>

<script>
    var zone = "05:30";  //Change this to your timezone
$(document).ready(function() {



    /* initialize the external events
    -----------------------------------------------------------------*/

    $('#external-events .fc-event').each(function() {

      // store data so the calendar knows to render an event upon drop
      $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
      });

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      });

    });
    });
  var currentMousePos = {
      x: -1,
      y: -1
  };
    jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });
  function getFreshEvents(){
    $.ajax({
      url: '../gateway/calendar_gateway.php',
          type: 'POST', // Send post data
          data: 'type=fetch',
          async: false,
          success: function(s){
            freshevents = s;
          }
    });
    $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
  }

    function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }



  $(function () {

     Date.prototype.addHours = function(h) {
       this.setTime(this.getTime() + (h*60*60*1000));
       return this;
    }
      $.ajax({
        url: '../gateway/calendar_gateway.php',
            type: 'POST', // Send post data
            data: 'type=fetch',
            async: false,
            success: function(s){
              json_events = s;
            }
      });
    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }



    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      dayClick: function(date, jsEvent, view) {
          if (view.name === "month") {
              $('#calendar').fullCalendar('gotoDate', date);
              $('#calendar').fullCalendar('changeView', 'agendaDay');
          }
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      eventReceive: function(event){
        var title = event.title;
        var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
        var backgroundColor = (event.backgroundColor);
        console.log(backgroundColor)
        $.ajax({
            url: '../gateway/calendar_gateway.php',
            data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone+'&backgroundColor='+backgroundColor,
            type: 'POST',
            dataType: 'json',
            success: function(response){
              event.id = response.eventid;
              $('#calendar').fullCalendar('updateEvent',event);
            },
            error: function(e){
              console.log(e.responseText);

            }
          });
        $('#calendar').fullCalendar('updateEvent',event);
        console.log(event);
      },
      eventDrop: function(event, delta, revertFunc) {
        var title = event.title;
        var start = event.start.format();
        var end = (event.end == null) ? start: event.end.format();

        /*if(event.end==null){
          var end = (new Date(start).getHours())
        }else{
          var end = event.end.format();
        }*/
        end = (new Date(end).addHours(-6))
        if((new Date(start).getHours()==8) && new Date(end).getHours()==2){
          var allDay = 'true';
        }else{
          var allDay = 'false';
        }
        $.ajax({
          url: '../gateway/calendar_gateway.php',
          data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id+'&allDay='+allDay,
          type: 'POST',
          dataType: 'json',
          success: function(response){
             console.log(response.status)
            if(response.status != 'success')
              revertFunc();
          },
          error: function(e){
            revertFunc();
            alert('Error processing your request: '+e.responseText);
          }
        });

      },
      eventClick: function(event, jsEvent, view) {
        /*console.log(event.id);
        var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
        if (title){
          event.title = title;
          console.log('type=changetitle&title='+title+'&eventid='+event.id);
          $.ajax({
            url: '../gateway/calendar_gateway.php',
            data: 'type=changetitle&title='+title+'&eventid='+event.id,
            type: 'POST',
            dataType: 'json',
            success: function(response){
              if(response.status == 'success')
                      $('#calendar').fullCalendar('updateEvent',event);
            },
            error: function(e){
              alert('Error processing your request: '+e.responseText);
            }
          });
        }*/
      },
      eventResize: function(event, delta, revertFunc) {
        console.log(event);
        var title = event.title;
        var end = event.end.format();
        var start = event.start.format();
        if(start==end)
          var allDay='true';
        else
          var allDay='false';
        $.ajax({
          url: '../gateway/calendar_gateway.php',
          data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id+'&allDay='+allDay,
          type: 'POST',
          dataType: 'json',
          success: function(response){
            if(response.status != 'success')
            revertFunc();
          },
          error: function(e){
            revertFunc();
            alert('Error processing your request: '+e.responseText);
          }
        });
      },
      eventDragStop: function (event, jsEvent, ui, view) {
          console.log("A")
          if (isElemOverDiv()) {
            var con = confirm('Are you sure to delete this event permanently?');
            if(con == true) {
            $.ajax({
                url: '../gateway/calendar_gateway.php',
                data: 'type=remove&eventid='+event.id,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                  console.log(response);
                  if(response.status == 'success'){
                    $('#calendar').fullCalendar('removeEvents');
                        getFreshEvents();
                      }
                },
                error: function(e){
                  alert('Error processing your request: '+e.responseText);
                }
              });
          }
        }
      },
      //Random default events
      events: JSON.parse(json_events),
      editable: true,
      droppable: true,/* // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }*/
      drop: function(date,allDay){
        console.log($(this))
        $(this).remove();
      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }
      /*<div class='draggable external-event bg-green' data-event='{"title":"Appointment"}' >Appointment</div>*/
      //Create events
      var event = $("<div class='draggable external-event' data-event='{\"title\":\""+val+"\", \"backgroundColor\":\""+currColor+"\"}' >"+val+"</div>");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      //event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });

</script>
</body>
</html>
