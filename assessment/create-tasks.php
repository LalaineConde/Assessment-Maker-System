<?php
    $page_title = 'ADD TASK';
    include ('includes/dashboard.html');
    require 'connection.php';
    error_reporting(E_ERROR | E_PARSE);
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    $errors = array();

    if (isset($_POST['addTask'])) {
        $task_title = $_POST['task_title'];
        $task_description = $_POST['task_description'];
        $due_date = $_POST['due_date'];
        $priority = $_POST['priority']; 
        $start_time = $_POST['start_time']; 
        $end_time = $_POST['end_time']; 

        if (empty($task_title)) {
            $errors['task_title'] = "Task title is required";
        }
        if (empty($due_date)) {
            $errors['due_date'] = "Due date is required";
        }

        if (count($errors) == 0) {
            $insertQuery = "INSERT INTO tasks_details (task_title, task_description, due_date, priority, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $connection->prepare($insertQuery);
            $stmt->bind_param('sssiss', $task_title, $task_description, $due_date, $priority, $start_time, $end_time);

            if ($stmt->execute()) {
                $taskId = $stmt->insert_id;
                $calculateTimeQuery = "UPDATE tasks_details SET total_time_spent = TIMESTAMPDIFF(SECOND, start_time, end_time) WHERE task_id = ?";
                $calculateTimeStmt = $connection->prepare($calculateTimeQuery);
                $calculateTimeStmt->bind_param('i', $taskId);
                $calculateTimeStmt->execute();

                header('Location: view-tasks.php');
                exit();
            } else {
                $errors['db_error'] = "Database error: failed to create. " . $stmt->error;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Task</title>
<style>
    body {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background: #DED4E8;
        background-attachment: fixed;
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

/*    .task_number_container{
        color: #FDEAF1;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label.task_id{
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black;
        font-size: 32px;
        margin: 0px 20px;
    }

    #task_id{
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
    }*/

    .task_title_container {
        color: #FDEAF1;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label.title {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black;
        font-size: 32px;
        margin: 0px 20px;
    }

    #task_title {
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

    .task_description_container {
        color: #FDEAF1;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label.description {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black;
        font-size: 32px;
        margin: 0 20px; 
    }

    #task_description {
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        width: calc(100% - 40px); 
        height: 300px;
        border-radius: 10px;
        font-size: 24px;
        padding: 10px 10px;
        margin: 0 20px; 
    }

    .date_priority {
        display: flex;
        gap: 20px; 
    }

    .task_duedate_container,
    .task_priority_container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        color: #FDEAF1;
        width: 50%;
    }

    label.duedate,
    label.priority {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black;
        font-size: 32px;
        margin: 0 20px; 
    }

    #due_date,
    #priority {
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

    select, option{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        color: #000000;
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

    ::-webkit-calendar-picker-indicator {
        background-color: transparent;
        border-radius: 5px;
        margin: 0 10px; 
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

    @media(max-width: 768px) {

        .form_container{
            padding-right: 50px;
            
        }
        label.task_id,
        label.title,
        label.description,
        label.duedate,
        label.priority,
        label.start_time,
        label.end_time {
            padding-right: 50px;
            margin: 0 20px;
        }

        #task_id,
        #task_title,
        #task_description,
         {
            min-width: 80px;
            
        }
        #due_date,
        #priority,
        #start_time,
        #end_time{
            min-width: 150px;
            margin: 0;
        }

        #task_description{
             width: calc(100% - 10px);
        }

        .date_priority,
        .task_time_container {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

    
    }

    @media(max-width:420px){

        .form_container{
            padding-right: 50px;
            padding-left: 20px;
        }
        .main_title{
            font-size: 24px;
        }
        
        label.task_id,
        label.title,
        label.description,
        label.duedate,
        label.priority,
        label.start_time,
        label.end_time {
            font-size: 24px;
            padding-right: 50px;

            margin: 0;
        }

        #task_id,
        #task_title,
        #task_description,
         {

            font-size: 16px;
        }
        #due_date,
        #priority,
        #start_time,
        #end_time{
            font-size: 16px;
        }

      

    }
</style>
</head>
<body>
<h1 class="main_title">Create Task</h1>
 <div class="form_container">
    <form action="create-tasks.php" method="POST">

        <?php if (count($errors) > 0): ?>
        <div>
        <?php foreach ($errors as $error): ?>
        <li><?php echo $error; ?></li>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>

<!--         <div class="task_number_container">   
        <label for="task_id" class="task_id">Task No.:</label>
            <input type="text" id="task_id" name="task_id" value="<?php echo $row['task_id']; ?>" readonly><br><br>
 </div> -->

        <div class="task_title_container">       
        <label for="task_title" class="title">Task Name</label>
        <input type="text" id="task_title" name="task_title" required><br>
        <br>
 </div>

 <div class="task_description_container">
        <label for="task_description" class="description">Task Description:</label><br>
        <br>
        <textarea id="task_description" name="task_description" rows="7" cols="100"></textarea><br>
        <br>
  </div>
<div class="date_priority">
   <div class="task_duedate_container">
        <label for="due_date" class="duedate">Due Date</label>
        <input type="date" id="due_date" name="due_date" required><br>
        <br>
  </div>

   <div class="task_priority_container">
        <label for="priority" class="priority">Priority:</label>
        <select id="priority" name="priority">
             <option value="1">Low</option>
             <option value="2">Medium</option>
             <option value="3">High</option>
        </select>
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
        <button type="submit" name="addTask" class="submit">ADD TASK</button>
</div>
    </form>
</body>
</html>