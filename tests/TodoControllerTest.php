<?php
// tests/TodoControllerTest.php
namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\TodoController;
use App\Model\TodoModel;
use App\View\TodoView;

class TodoControllerTest extends TestCase {
    private $todoController;
    private $mockModel;
    private $mockView;

    protected function setUp(): void {
        // Create mocks for TodoModel and TodoView
        $this->mockModel = $this->createMock(TodoModel::class);
        $this->mockView = $this->createMock(TodoView::class);

        // Instantiate the controller with the mocked dependencies
        $this->todoController = new TodoController();
        // Inject the mocks into the controller
        $this->todoController->setModel($this->mockModel);
        $this->todoController->setView($this->mockView);
    }

    public function testListTasks() {
        // Arrange
        $tasks = [
            ['id' => 1, 'description' => 'Test task', 'completed' => false]
        ];
        $this->mockModel->method('getAllTasks')->willReturn($tasks);

        // Expect the view's displayTasks method to be called with the tasks
        $this->mockView->expects($this->once())
            ->method('displayTasks')
            ->with($tasks);

        // Act
        $this->todoController->listTasks();
    }

    public function testAddTask() {
        // Arrange
        $taskDescription = 'New task';
        $task = ['id' => 1, 'description' => $taskDescription, 'completed' => false];
        $this->mockModel->method('addTask')->with($taskDescription)->willReturn($task);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task added: {$taskDescription} (ID: {$task['id']})");

        // Act
        $this->todoController->addTask($taskDescription);
    }

    public function testCompleteTask() {
        // Arrange
        $taskId = 1;
        $this->mockModel->method('completeTask')->with($taskId)->willReturn(true);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task ID $taskId marked as completed.");

        // Act
        $this->todoController->completeTask($taskId);
    }

    public function testDeleteTask() {
        // Arrange
        $taskId = 1;
        $this->mockModel->method('deleteTask')->with($taskId)->willReturn(true);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task ID $taskId deleted.");

        // Act
        $this->todoController->deleteTask($taskId);
    }

    public function testChangeTaskDescription() {
        // Arrange
        $taskId = 1;
        $newDescription = 'Updated task description';
        $this->mockModel->method('changeTaskDescription')->with($taskId, $newDescription)->willReturn(true);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task ID $taskId description updated.");

        // Act
        $this->todoController->changeTaskDescription($taskId, $newDescription);
    }

    // Additional tests for error cases
    public function testCompleteTaskTaskNotFound() {
        // Arrange
        $taskId = 999;
        $this->mockModel->method('completeTask')->with($taskId)->willReturn(false);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task not found with ID $taskId.");

        // Act
        $this->todoController->completeTask($taskId);
    }

    public function testDeleteTaskTaskNotFound() {
        // Arrange
        $taskId = 999;
        $this->mockModel->method('deleteTask')->with($taskId)->willReturn(false);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task not found with ID $taskId.");

        // Act
        $this->todoController->deleteTask($taskId);
    }

    public function testChangeTaskDescriptionTaskNotFound() {
        // Arrange
        $taskId = 999;
        $newDescription = 'Updated task description';
        $this->mockModel->method('changeTaskDescription')->with($taskId, $newDescription)->willReturn(false);

        // Expect the view's displayMessage method to be called
        $this->mockView->expects($this->once())
            ->method('displayMessage')
            ->with("Task not found with ID $taskId.");

        // Act
        $this->todoController->changeTaskDescription($taskId, $newDescription);
    }
}
