<?php
   require 'connection.php';
    error_reporting(E_ERROR | E_PARSE);
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   $task_id = $_GET['task_id'];

   $deleteQuery = "DELETE FROM tasks_details WHERE task_id = '$task_id'";
   $result = mysqli_query($connection, $deleteQuery);


if ($result == TRUE) 
      {
         header('location: view-tasks.php');
         exit();
      }
?>