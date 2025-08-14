<?php
require 'connection.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];


    $updateQuery = "UPDATE tasks_details SET is_completed = 1 WHERE task_id = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param('i', $task_id);

    if ($stmt->execute()) {
        header('Location: view-tasks.php');
        exit();
    } else {
        echo "Error updating task completion status: " . $stmt->error;
    }
} else {
    echo "Task ID not provided.";
}