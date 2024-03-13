<?php

require_once 'vendor/autoload.php';

use MongoDB\Client as MongoDBClient;

$mongoClient = new MongoDBClient("mongodb://localhost:27017");
$collection = $mongoClient->todoapp->tasks;

function getTasks($filter = []) {
    global $collection;
    return iterator_to_array($collection->find($filter));
}

// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchQuery = $_GET['search_query'];
    if (!empty($searchQuery)) {
        // Create a filter to search tasks by name
       // $filter = ['name' => new MongoDB\BSON\Regex($searchQuery, 'i')]; //partial match case insensitive
       $filter = ['name' => $searchQuery]; //For an exact match search (case-sensitive)
       // $filter = ['name' => ['$eq' => $searchQuery]]; //For an exact match search (case-insensitive)
      
        

        

        $tasks = getTasks($filter);
    } else {
        // If search query is empty, retrieve all tasks
        $tasks = getTasks();
    }
} else {
    // If no search query, retrieve all tasks
    $tasks = getTasks();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Search Results</title>
</head>
<body>
    <h1>To-Do List - Search Results</h1>
    <form action="action.php" method="post">
        <input type="text" name="task_name" placeholder="Enter task">
        <button type="submit" name="add_task">Add Task</button>
    </form>
    <form action="search.php" method="get">
        <input type="text" name="search_query" placeholder="Search tasks">
        <button type="submit" name="search">Search</button>
    </form>
    <h2>Search Results:</h2>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?php echo $task['name']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>






