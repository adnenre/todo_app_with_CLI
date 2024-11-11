<?php

namespace App\View;

class TodoView {
    public function displayTasks($tasks) {
        if (empty($tasks)) {
            echo "No tasks found.\n";
        } else {
            foreach ($tasks as $id => $task) {
                $status = $task['completed'] ? 'Completed' : 'Not Completed';
                echo "ID: $id - Description: {$task['description']} - Status: $status\n";
            }
        }
    }

    public function displayMessage($message) {
        echo $message . "\n";
    }

    public function showUsage() {
        echo "Usage: php app.php <command> [<args>]\n";
        echo "Commands:\n";
        echo "  1- list ,-l                     List all tasks\n";
        echo "  2- add <description> ,-a <description>     Add a new task\n";
        echo "  3- complete <id> ,-c <id>       Mark task as completed\n";
        echo "  4- delete <id> ,-d <id>         Delete a task\n";
        echo "  5- modifier <id> <new_description> ,-m <id> <new_description> Change task description\n";
    }
}
