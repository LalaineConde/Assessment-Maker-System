<?php
require 'connection.php';

 $task_id = $_GET['task_id'];
    
    $query = "SELECT * FROM tasks_details WHERE task_id='$task_id'";
    $sql = mysqli_query($connection, $query);

if (isset($_POST['updateTask'])) {
    $task_id = $_POST['task_id'];
    $task_title = $_POST['task_title'];
    $task_description = $_POST['task_description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $start_time = $_POST['start_time']; 
    $end_time = $_POST['end_time']; 

$new_total_time_spent = strtotime($end_time) - strtotime($start_time);
    $updateQuery = "UPDATE tasks_details SET task_title = '$task_title', task_description = '$task_description', due_date = '$due_date', priority = '$priority', start_time = '$start_time', end_time = '$end_time', total_time_spent = '$new_total_time_spent'  WHERE task_id = '$task_id'";
    

    if (mysqli_query($connection, $updateQuery)) {
            header('location: view-tasks.php');  
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
<style>
    body {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background: #DED4E8;
        background-attachment: fixed;
        margin: 0;
        overflow-x: hidden; 
        

    }

    .main_title {
        font-size: 72px;
        margin-top: 70px; 
        padding: 0 90px; 
        color: #E8BA40;
        -webkit-text-stroke: 1.5px black; 
        text-stroke: 1.5px black;
        margin-bottom: 10px;
    }

    .form_container {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        box-shadow: 5px -5px 0px #000;
        border: 3px solid #000000;
        background-color: #C7395F;
        margin: 0 50px; 
        padding: 20px 20px; 
        border-radius: 38px;
    }

    .task_number_container{
        color: #ffffff;
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
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
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

    .task_title_container {
        color: #ffffff;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label.task_title {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black; 
        font-size: 32px;
        margin: 0px 20px;
    }

    #task_title {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
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
        color: #ffffff;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    label.task_description {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black; 
        font-size: 32px;
        margin: 0 20px; 
    }

    #task_description {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        width: calc(100% - 80px); 
        height: 300px;
        border-radius: 10px;
        font-size: 24px;
        padding: 10px 20px;
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
        color: #ffffff;
        width: 50%;
    }

    label.duedate,
    label.priority {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black; 
        font-size: 32px;
        margin: 0 20px; 
    }

    #due_date{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        max-width:  1000px; 
        width: calc(100% - 40px); 
        height: 50px;
        border-radius: 10px;
        font-size: 20px;
        padding: 10px 10px;
        margin: 0 20px; 

    }
    #priority {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        max-width:  1000px; 
        width: calc(100% - 20px); 
        height:70px;
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
        color: #ffffff;
        width: 50%;
    }

    label.start_time,
    label.end_time {
        -webkit-text-stroke: 0.8px black; 
        text-stroke: 0.8px black; 
        font-size: 32px;
        margin: 0 20px; 
    }

    #start_time{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        max-width:  1000px; 
        width: calc(100% - 40px); 
        height: 50px;
        border-radius: 10px;
        font-size: 20px;
        padding: 10px 10px;
        margin: 0 20px; 

    }

    #end_time{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        background-color: #FDEAF1;
        color: #000000;
        border: 1.5px solid #000000;
        width: 100%;
        max-width:  1000px; 
        width: calc(100% - 40px); 
        height: 50px;
        border-radius: 10px;
        font-size: 20px;
        padding: 10px 10px;
        margin: 0 20px; 

    }



    ::-webkit-calendar-picker-indicator {
        background-color: #ffffff;
        border-radius: 5px;
        margin: 0 10px; 
    }

    .task_submit_container {
        text-align: right;
        margin: 30px 70px; 
    }

    .submit{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
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
        label.task_title,
        label.task_description,
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

        #start_time,
        #end_time{
            min-width: 120px;
        }

        #task_description,
        #task_time_container{
             width: calc(100% - 40px);
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
        label.task_title,
        label.task_description,
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
    <h1 class="main_title">Edit Task</h1>
     <div class="form_container">
    <form action="edit-tasks.php" method="POST">

        <?php while($row = mysqli_fetch_array($sql)){ ?>

        <div class="task_number_container">   
            <label for="task_id" class="task_id">Task No.:</label>
            <input type="text" id="task_id" name="task_id" value="<?php echo $row['task_id']; ?>" readonly><br><br>
</div>

        <div class="task_title_container"> 
            <label for="task_title" class="task_title">Task Name:</label>
            <input type="text" id="task_title" name="task_title" value="<?php echo $row['task_title']; ?>" ><br><br>
</div>

        <div class="task_description_container">
            <label for="task_description" class="task_description">Task Description:</label><br><br>
</div>

        <div class="task_description_container">
            <textarea id="task_description" name="task_description" rows="7" cols="100"><?php echo $row['task_description']; ?></textarea><br><br>
</div>

        <div class="date_priority">
            <div class="task_duedate_container"> 
            <label for="due_date" class="duedate">Due Date:</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo $row['due_date']; ?>"><br><br>
</div>

        <div class="task_priority_container">
        <label for="priority" class="priority">Priority:</label>
            <select id="priority" name="priority">
                <option value="1" <?php echo ($row['priority'] == 1) ? 'selected' : ''; ?>>Low</option>
                <option value="2" <?php echo ($row['priority'] == 2) ? 'selected' : ''; ?>>Medium</option>
                <option value="3" <?php echo ($row['priority'] == 3) ? 'selected' : ''; ?>>High</option>
            </select><br><br>
 </div>
</div> 

<div class="task_time_container">
    <div class="task_starttime_container">
        <label for="start_time" class="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" value="<?php echo $row['start_time']; ?>" required><br>
        <br>
</div> 

    <div class="task_endtime_container">
        <label for="end_time" class="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" value="<?php echo $row['end_time']; ?>" required><br>
        <br>
    </div>
</div>

</div>

        <div class="task_submit_container">
            <button type="submit" name="updateTask" class="submit">UPDATE TASK</button>
</div>          
        <?php } ?>
    </form>
</body>

</html>