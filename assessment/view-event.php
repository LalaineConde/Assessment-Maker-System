<?php
    $page_title = 'VIEW EVENTS';
    include ('includes/dashboard.html');
    require 'connection.php';


    $display_all = "SELECT * FROM events_details";

    $query = mysqli_query($connection, $display_all);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Events</title>

    <style>

       body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin: 0 50px;

        }

        .main_title {
            font-size: 72px;
            margin-top: 120px; 
            padding: 0 90px; 
            color: #E8BA40;
            -webkit-text-stroke: 1.5px black; /* For Safari/Chrome */
            text-stroke: 1.5px black;


        }   

         table {
            border-collapse: collapse;
            border: 2px solid #000000;
            width: 100%;
            border-radius: 30px; /* Adjust the border-radius for rounded corners */
            overflow: hidden;
            border-color: #000000;
            margin-top: 20px; /* Added margin-top for spacing */
            box-shadow: 10px 10px 4px #000;
            margin-bottom: 50px;
        }

        th, td {
            border: 1px solid #ffffff;
            padding: 10px;
            text-align: center;

        }

        th {
            background-color: #C7395F;
            color: #ffffff;
            border: 2px solid #000000;
        }

        td {
    background-color: #FDEAF1;
    color: #000000;
    border: 2px solid #000000;   
        }

        tr:hover td {
    background-color: #C7395F;
    color: #ffffff; /* Set the text color to white for the hover state */
}
tr:hover td a {
    color: #ffffff; /* Set the text color to white for the links in the hover state */
}

        a{
            color: #000000;
            text-decoration: none;

        }

    </style>

</head>
<body>
    
    <center><h1 class="main_title">EVENT SCHEDULE</h1></center>
    <table>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Time Spent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($rows = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td><?php echo $rows['event_id']; ?></td>
                    <td><?php echo $rows['event_title']; ?></td>
                    <td><?php echo $rows['event_date']; ?></td>
                    <td><?php echo $rows['event_time']; ?></td>
                    <td><?php echo $rows['start_time']; ?></td>
                    <td><?php echo $rows['end_time']; ?></td>
                    <td><?php echo formatTime($rows['total_time_spent']); ?></td>
                    <td>
                        <a href="delete-event.php?event_id=<?php echo $rows['event_id']; ?>">Remove</a><br>
                        <br>
                        <a href="edit-event.php?event_id=<?php echo $rows['event_id']; ?>">Edit</a><br>
                        <br>


                    </td>
                </tr>
            <?php } ?>
        </tbody>

        <?php
function formatTime($totalTimeInSeconds) {
    $hours = floor(abs($totalTimeInSeconds) / 3600);
    $minutes = floor((abs($totalTimeInSeconds) % 3600) / 60);
    $seconds = abs($totalTimeInSeconds) % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
?>
    </table>

</body>
</html>