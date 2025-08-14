<?php
    $page_title = 'CALENDAR';
    require 'connection.php';
    include ('includes/dashboard.html');

    error_reporting(E_ERROR | E_PARSE);
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    $taskQuery = mysqli_query($connection, "SELECT * FROM tasks_details");

    $tasks = array();

while ($taskRow = mysqli_fetch_array($taskQuery)) {
    $dueDate = new DateTime($taskRow['due_date']);
    $startTime = new DateTime($taskRow['start_time']);

    // Combine due_date and start_time into a valid datetime format
    $combinedDateTime = $dueDate->format('Y-m-d') . ' ' . $startTime->format('H:i:s');

    $tasks[] = array(
        'title' => $taskRow['task_title'],
        'start' => $combinedDateTime,
        'color' => '#000000',
        'textColor' => '#000000',
        'type' => 'task',
    );
}
    $eventQuery = mysqli_query($connection, "SELECT * FROM events_details");

    $events = array();

    while ($eventRow = mysqli_fetch_array($eventQuery)) {
    $events[] = array(
        'title' => $eventRow['event_title'],
        'start' => $eventRow['event_date'] . ' ' . $eventRow['event_time'], // Combine event_date and event_time for events
        'color' => '#000000',
        'textColor' => '#000000',
        'type' => 'event',
    );
}

$connection->close();
?>
<!DOCTYPE html>
<html>
<head></head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendar View</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


  <style>

    .main_title {
    font-size: 72px;
    margin-top: 120px;
    margin-bottom: 30px;
    color: #E8BA40;
    -webkit-text-stroke: 1.5px black; /* For Safari/Chrome */
    text-stroke: 1.5px black; /* For other browsers */
}

.fc-day-content {
    position: relative;

}

.event, .task {
    background-color: #4285f4;
    color: white;
    padding: 2px 4px;
    margin-top: 2px;
    cursor: pointer;
    font-size: 12px;
    border-radius: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

}

.event:hover, .task:hover {
    background-color: #333;
}

.grouped {
    margin-top: 150px;
}

.calendar {
    box-shadow: 10px 10px 4px #000;
    border: 8px solid #FDEAF1;
    background-color: #DED4E8;
    color: #C7395F;
    padding: 30px 50px;
    margin: 50px 100px;
    border-radius: 10px;
}

.calendar h2 {
        -webkit-text-stroke: 0.5px black; /* For Safari/Chrome */
    text-stroke: 0.5px black;
    font-size: 32px;
    color: #C7395F; /* Updated color */
}

#calendar {
    color: #C7395F;
}

.calendar button {
    background-color: #C7395F;
    color: #000000;
    text-shadow: none;
    margin: 0 10px;
    border: none;
    padding: 0 20px;
    cursor: pointer;
    border-radius: 5px;
    opacity: 100%;

}

.calendar table {
    width: 100%;
    border-collapse: collapse;
}

.calendar th {
    background-color: #C7395F;
        border: 2px solid #000000;
    color: #ffffff;
    padding: 10px;
}

.calendar td {
        border: 2px solid #000000;
    background-color: #FDEAF1; 
    color: #000000;
}

</style>
</head>
<body>

<div class="grouped">
    <center><h1 class="main_title">CALENDAR</h1></center>
    <div class="calendar">
        <h2>Calendar</h2>
        <div id="calendar"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },

            displayEventTime: true, // Make sure this option is set to true
            allDaySlot: false,
            events: <?php echo json_encode(array_merge($tasks, $events)); ?>,
        eventRender: function (event, element) {
            if (event.type === 'event') {
                element.css('background-color', '#C7395F');
            } else if (event.type === 'task') {
                element.css('background-color', '#E8BA40');
            }
        },
        eventClick: function (event) {
            var details = 'Title: ' + event.title + '\n';

            if (event.type === 'event') {
                details += 'Event Date: ' + moment(event.start).format('YYYY-MM-DD') + '\n';
                details += 'Event Time: ' + moment(event.start).format('HH:mm');
            } else if (event.type === 'task') {
                details += 'Due Date: ' + moment(event.start).format('YYYY-MM-DD') + '\n';
                details += 'Due Time: ' + moment(event.start).format('HH:mm:ss');
            }

            alert(details);
            },
            // dayRender: function (date, cell) {
            //     var dayEvents = getEventsForDate(date);
            //     var dayTasks = getTasksForDate(date);

            //     if (dayEvents.length > 0 || dayTasks.length > 0) {
            //         var content = '<div class="hover-content">';
                    
            //         if (dayEvents.length > 0) {
            //         content += '<div class="event-container">';
            //         dayEvents.forEach(function (event) {
            //             content += '<div class="event" title="' + event.title + ' - Date: ' + event.date + ' Time: ' + event.time + '">' + event.title + '</div>';
            //         });
            //         content += '</div>';
            //     }

            //     if (dayTasks.length > 0) {
            //         content += '<div class="task-container">';
            //         dayTasks.forEach(function (task) {
            //             content += '<div class="task" title="' + task.title + ' - Due Date: ' + task.start + ' Due Time: ' + task.starttime + '">' + task.title + '</div>';
            //         });
            //         content += '</div>';
            //     }


            //         content += '</div>';
            //         cell.append(content);
            //     }
            // }
        });

        function getEventsForDate(date) {
            var events = <?php echo json_encode($events); ?>;
            return events.filter(function (event) {
                return moment(event.start).isSame(date, 'day');
            });
        }

        function getTasksForDate(date) {
            var tasks = <?php echo json_encode($tasks); ?>;
            return tasks.filter(function (task) {
                return moment(task.start).isSame(date, 'day');
            });
        }
    });
</script>
    
</body>
</html>