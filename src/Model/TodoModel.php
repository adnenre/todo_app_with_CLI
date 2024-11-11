<?php

namespace App\Model;

class TodoModel {
    private $tasks = [];
    private $filename;

    public function __construct($filename = 'tasks.txt') {
        $this->filename = $filename;
        $this->loadTasksFromFile();
    }

    private function loadTasksFromFile() {
        if (file_exists($this->filename)) {
            $data = file_get_contents($this->filename);
            $this->tasks = json_decode($data, true) ?? [];
        } else {
            // Initialize the file if it doesn't exist
            $this->tasks = [];
            $this->saveTasksToFile();
        }
    }

    public function saveTasksToFile() {
        file_put_contents($this->filename, json_encode($this->tasks, JSON_PRETTY_PRINT));
    }
    private function generateTaskId() {
        // Generate a new unique ID by finding the max ID and incrementing it
        if (empty($this->tasks)) {
            return 1; // If no tasks exist, start from 1
        }
        return max(array_keys($this->tasks)) + 1;
    }

    public function addTask($description) {
        $id = $this->generateTaskId();
        $this->tasks[$id] = [
            'id' => $id,
            'description' => $description,
            'completed' => false
        ];
        $this->saveTasksToFile(); // Save after adding
        return $this->tasks[$id];
    }

    public function getAllTasks() {
        return $this->tasks;
    }

    public function completeTask($id) {
        if (isset($this->tasks[$id])) {
            $this->tasks[$id]['completed'] = true;
            $this->saveTasksToFile(); // Save after completing
            return true;
        }
        return false;
    }

    public function deleteTask($id) {
        if (isset($this->tasks[$id])) {
            unset($this->tasks[$id]);
            $this->saveTasksToFile(); // Save after deleting
            return true;
        }
        return false;
    }

    public function changeTaskDescription($id, $newDescription) {
        if (isset($this->tasks[$id])) {
            $this->tasks[$id]['description'] = $newDescription;
            $this->saveTasksToFile(); // Save after modifying
            return true;
        }
        return false;
    }
}
