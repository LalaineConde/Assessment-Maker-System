<?php
$page_title = 'ADD EVENT';
include ('includes/dashboard.html');
require 'connection.php';
error_reporting(E_ERROR | E_PARSE);
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


$errors = array();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addEvent'])) {
    
    $event_title = mysqli_real_escape_string($connection, $_POST['eventName']);
    $event_date = mysqli_real_escape_string($connection, $_POST['eventDate']);
    $event_time = mysqli_real_escape_string($connection, $_POST['eventTime']);
    $start_time = mysqli_real_escape_string($connection, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($connection, $_POST['end_time']);
 
    if (empty($event_title)) {
        $errors['event_title'] = "Event title is required";
    }
    if (empty($event_date)) {
        $errors['event_date'] = "Event date is required";
    }
    if (empty($event_time)) {
        $errors['event_time'] = "Event time is required";
    }


    if (count($errors) == 0) {
        $insertQuery = "INSERT INTO events_details (event_title, event_date, event_time, start_time, end_time) VALUES (?, ?, ?, ?, ?)";

        $stmt = $connection->prepare($insertQuery);


        $stmt->bind_param('sssss', $event_title, $event_date, $event_time, $start_time, $end_time);

        if ($stmt->execute()) {
                $eventId = $stmt->insert_id;
                $calculateTimeQuery = "UPDATE events_details SET total_time_spent = TIMESTAMPDIFF(SECOND, start_time, end_time) WHERE event_id = ?";
                $calculateTimeStmt = $connection->prepare($calculateTimeQuery);
                $calculateTimeStmt->bind_param('i', $eventId);
                $calculateTimeStmt->execute();

            header('Location:view-event.php');
            exit();
        } else {
            $errors['db_error'] = "Database error: failed to create. " . $stmt->error;
        }

        $stmt->close();
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Schedule Event / Appointment</title>
<style>

        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            

        }
        .main_title {
            font-size: 72px;
            margin-top: 120px; 
            padding: 0 90px; 
            color: #E8BA40;
            -webkit-text-stroke: 1.5px black; 
            text-stroke: 1.5px black;
        }

        .form_container {
            box-shadow: 5px -5px 0px #000;
            border: 3px solid #000000;
            background-color: #C7395F;
            margin: 0 50px; 
            padding: 20px 20px; 
            border-radius: 38px;
        }

/*        .eventid_container{
            color: #FDEAF1;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        label.event_id{
            -webkit-text-stroke: 0.8px black; 
            text-stroke: 0.8px black;
            font-size: 32px;
            margin: 0px 20px;
        }

        #event_id{
            background-color: #FDEAF1;
            color: #000000;
            border: 1.5px solid #000000;
            width: 50%;
            max-width: 500px;
            width: calc(100% - 20px); 
            height: 50px;
            border-radius: 10px;
            font-size: 24px;
            padding: 10px 10px;
            margin: 0 20px; 
        }
*/
      

        .eventName_container{
            color: #FDEAF1;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
       
        label.eventName {
            -webkit-text-stroke: 0.8px black; 
            text-stroke: 0.8px black;
            font-size: 32px;
            margin: 0px 20px;
        }

        #eventName {
            background-color: #FDEAF1;
            color: #000000;
            border: 1.5px solid #000000;
            width: 50%;
            max-width: 500px;
            width: calc(100% - 20px); 
            height: 50px;
            border-radius: 10px;
            font-size: 24px;
            padding: 10px 10px;
            margin: 0 20px; 
        }

          .event_datetime{
            display: flex;
            gap: 20px; 
        }

        .eventDate_container{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: #FDEAF1;
            width: 50%;
        }

        label.eventDate{
            -webkit-text-stroke: 0.8px black; 
            text-stroke: 0.8px black;
            font-size: 32px;
            margin: 0 20px; 
        }

        #eventDate {
            background-color: #FDEAF1;
            color: #000000;
            border: 1.5px solid #000000;
            width: 100%;
            max-width:  1000px; 
            width: calc(100% - 20px); 
            height: 50px;
            border-radius: 10px;
            font-size: 20px;
            padding: 10px 10px;
            margin: 0 20px; 
        }


    ::-webkit-calendar-picker-indicator {
            background-color: transparent;
            border-radius: 5px;
            margin: 0 10px; 
    }

        .eventTime_container{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: #FDEAF1;
            width: 50%;
        }

        label.eventTime{
            -webkit-text-stroke: 0.8px black; 
            text-stroke: 0.8px black;
            font-size: 32px;
            margin: 0 20px; 
        }

        #eventTime {
            background-color: #FDEAF1;
            color: #000000;
            border: 1.5px solid #000000;
            width: 100%;
            max-width:  1000px; 
            width: calc(100% - 20px); 
            height: 50px;
            border-radius: 10px;
            font-size: 20px;
            padding: 10px 10px;
            margin: 0 20px; 
        }

        .task_time_container{
            display: flex;
            gap: 20px; 
        }

        .task_starttime_container,
        .task_endtime_container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: #FDEAF1;
            width: 50%;
        }

        label.start_time,
        label.end_time {
            -webkit-text-stroke: 0.8px black; 
            text-stroke: 0.8px black;
            font-size: 32px;
            margin: 0 20px; 
        }

        #start_time,
        #end_time {
            background-color: #FDEAF1;
            color: #000000;
            border: 1.5px solid #000000;
            width: 100%;
            max-width:  1000px; 
            width: calc(100% - 20px); 
            height: 50px;
            border-radius: 10px;
            font-size: 20px;
            padding: 10px 10px;
            margin: 0 20px; 
        }

        .task_submit_container {
            text-align: right;
            margin: 20px 70px; 
        }

        .submit {
            width: 100%;
            max-width: 200px;
            height: 50px;
            font-size: 22px;
            color: #000000;
            background-color: #E8BA40;
            border: 2px solid #000000;
            border-radius: 10px;
            box-shadow: 2.5px -2.5px 0px #000000;
        }


</style>
</head>
<body>


<h1 class="main_title">Schedule an Event</h1>
  <div class="form_container">
    <form action="create-event.php" method="POST">

        <?php if (count($errors) > 0): ?>
        <div>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>

<!--     <div class="eventid_container">
        <label for="event_id" class="event_id">Event ID</label>
        <input type="text" id="event_id" name="event_id" value="<?php echo $row['event_id']; ?>" readonly><br><br>
</div> -->

    <div class="eventName_container">
        <label for="eventName" class="eventName">Event/Appointment Name:</label>
        <input type="text" id="eventName" name="eventName" required><br>
        <br>
</div>

<div class="event_datetime">
    <div class="eventDate_container">
        <label for="eventDate" class="eventDate">Event/Appointment Date:</label>
        <input type="date" id="eventDate" name="eventDate" required><br>
        <br>
</div>

    <div class="eventTime_container">
        <label for="eventTime" class="eventTime">Event/Appointment Time:</label>
        <input type="time" id="eventTime" name="eventTime" required><br>
        <br>

</div>
</div> 

 <div class="task_time_container">
    <div class="task_starttime_container">
        <label for="start_time" class="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required><br>
        <br>
</div> 

    <div class="task_endtime_container">
        <label for="end_time" class="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br>
        <br>
    </div>
</div> 

</div>
       <div class="task_submit_container">
        <button type="submit" name="addEvent" class="submit">ADD EVENT</button>
</div> 

    </form>


    

</body>
</html>