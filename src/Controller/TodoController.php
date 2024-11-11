<?php

namespace App\Controller;

use App\Model\TodoModel;
use App\View\TodoView;

class TodoController {
    private $todoModel;
    private $todoView;

    public function __construct() {
        // Pass filename to the model
        $this->todoModel = new TodoModel();
        $this->todoView = new TodoView();
    }

    public function listTasks() {
        $tasks = $this->todoModel->getAllTasks();
        $this->todoView->displayTasks($tasks);
    }
    // Setter for the model
    public function setModel(TodoModel $todoModel) {
        $this->todoModel = $todoModel;
    }

    // Setter for the view
    public function setView(TodoView $todoView) {
        $this->todoView = $todoView;
    }

    public function addTask($description) {
        $task = $this->todoModel->addTask($description);
        $this->todoView->displayMessage("Task added: {$task['description']} (ID: {$task['id']})");
    }

    public function completeTask($id) {
        if ($this->todoModel->completeTask($id)) {
            $this->todoView->displayMessage("Task ID $id marked as completed.");
        } else {
            $this->todoView->displayMessage("Task not found with ID $id.");
        }
    }

    public function deleteTask($id) {
        if ($this->todoModel->deleteTask($id)) {
            $this->todoView->displayMessage("Task ID $id deleted.");
        } else {
            $this->todoView->displayMessage("Task not found with ID $id.");
        }
    }

    public function changeTaskDescription($id, $newDescription) {
        if ($this->todoModel->changeTaskDescription($id, $newDescription)) {
            $this->todoView->displayMessage("Task ID $id description updated.");
        } else {
            $this->todoView->displayMessage("Task not found with ID $id.");
        }
    }
}
