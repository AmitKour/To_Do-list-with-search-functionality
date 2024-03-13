
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        .task {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>To-Do List</h1>
    <form action="action.php" method="post">
        <input type="text" name="task_name" placeholder="Enter task">
        <button type="submit" name="add_task">Add Task</button>
    </form>
    <form action="search.php" method="get">
        <input type="text" name="search_query" placeholder="Search tasks">
        <button type="submit" name="search">Search</button>
    </form>
    <h2>Tasks:</h2>
    <ul>
        <?php
            // Display tasks from MongoDB
            require_once 'action.php';
            $tasks = getTasks();
            foreach ($tasks as $task) {
                echo "<li class='task'>" . $task['name'] . " <a href='action.php?delete_task=" . $task['_id'] . "'>Delete</a></li>";
            }
        ?>
    </ul>
</body>
</html>



