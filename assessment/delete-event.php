<?php
    require 'connection.php';
    error_reporting(E_ERROR | E_PARSE);
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   $event_id = $_GET['event_id'];

   $deleteQuery = "DELETE FROM events_details WHERE event_id = '$event_id'";
   $result = mysqli_query($connection, $deleteQuery);


if ($result == TRUE) 
      {
         header('location: view-event.php');
         exit();
      }
?>