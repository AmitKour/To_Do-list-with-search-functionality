<?php

require_once 'vendor/autoload.php';
use MongoDB\Client as MongoDBClient;

$mongoClient = new MongoDBClient("mongodb://localhost:27017");
$collection = $mongoClient->todoapp->tasks;

function getTasks() {
    global $collection;
    return iterator_to_array($collection->find());
}

function addTask($taskName) {
    global $collection;
    $task = ['name' => $taskName, 'created_at' => new DateTime()];
    $collection->insertOne($task);
}

function deleteTask($taskId) {
    global $collection;
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($taskId)]);
    return $result->getDeletedCount();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    $taskName = $_POST['task_name'];
    if (!empty($taskName)) {
        addTask($taskName);
    }
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_task'])) {
    deleteTask($_GET['delete_task']);
    header("Location: index.php");
    exit();
}

?>
