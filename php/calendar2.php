<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../js/fullcalendar-3.10.0/fullcalendar.min.css' rel='stylesheet' />
<link href='../js/fullcalendar-3.10.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='../js/fullcalendar-3.10.0/lib/moment.min.js'></script>
<script src='../js/fullcalendar-3.10.0/lib/jquery.min.js'></script>
<script src='../js/fullcalendar-3.10.0/fullcalendar.min.js'></script>
<!-- <script src='../js/fullcalendar-3.10.0/scheduler.min.js'></script> -->


<script src='../js/fullcalendar-3.6.2/lang/th.js'></script>
<script>
$(function() {

  $('#calendar').fullCalendar({
          header: {
        left: 'prev,next today',
        center: 'title',
        right: 'agendaDay,listDay,listWeek,month'
      },
    defaultView: 'agendaDay',
    resourceRender: function(resourceObj, $th) {
      $th.append(
        $('<strong>(?)</strong>').popover({
          title: resourceObj.title,
          content: 'test!',
          trigger: 'hover',
          placement: 'bottom',
          container: 'body'
        })
      );
    },
    resources: [
      { id: 'a', title: 'Auditorium A' },
      { id: 'b', title: 'Auditorium B' },
      { id: 'c', title: 'Auditorium C' }
    ],
          views: {
        listDay: { buttonText: 'list day' },
        listWeek: { buttonText: 'list week' }
      },

      defaultView: 'month',
      //defaultDate: '2019-01-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: {
            url: 'data_events.php?gData=1',
            error: function() {

            }
        }
  });

});

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>
