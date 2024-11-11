<?php

require 'vendor/autoload.php';

use App\Controller\TodoController;
use App\View\TodoView;

$controller = new TodoController();
$view = new TodoView();

if ($argc < 2) {
    // Show the usage instructions from the View
    $view->showUsage();
    exit;
}

$command = $argv[1];

switch ($command) {
    case 'list':
    case '-l':
        $controller->listTasks();
        break;
    case 'add':
    case '-a':
        if (isset($argv[2])) {
            $description = implode(" ", array_slice($argv, 2));
            $controller->addTask($description);
        } else {
            $view->displayMessage("Please provide a description for the task.");
        }
        break;
    case 'complete':
    case '-c':
        if (isset($argv[2]) && is_numeric($argv[2])) {
            $id = $argv[2];
            $controller->completeTask($id);
        } else {
            $view->displayMessage("Please provide a valid task ID.");
        }
        break;
    case 'delete':
    case '-d':
        if (isset($argv[2]) && is_numeric($argv[2])) {
            $id = $argv[2];
            $controller->deleteTask($id);
        } else {
            $view->displayMessage("Please provide a valid task ID.");
        }
        break;
    case 'modifier':
    case '-m':
        if (isset($argv[2]) && is_numeric($argv[2]) && isset($argv[3])) {
            $id = $argv[2];
            $newDescription = implode(" ", array_slice($argv, 3));
            $controller->changeTaskDescription($id, $newDescription);
        } else {
            $view->displayMessage("Please provide a valid task ID and a new description.");
        }
        break;
    default:
        $view->displayMessage("Unknown command: $command");
        break;
}
