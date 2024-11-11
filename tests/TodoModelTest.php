<?php



namespace App\Tests;


use PHPUnit\Framework\TestCase;
use App\Model\TodoModel;

class TodoModelTest extends TestCase {

    private $model;

    protected function setUp(): void {
        // Set up the TodoModel with a temporary file for testing
        $this->model = new TodoModel('php://memory'); // Use in-memory file to avoid actual file writing during tests
    }
    /**
     * @test
     * @description Add a task and verify it's added
     */
    public function testAddTask() {
        $task = $this->model->addTask('Test task');
        $tasks = $this->model->getAllTasks();

        // Check that the task was added and has an ID
        $this->assertCount(1, $tasks);
        $this->assertArrayHasKey('id', $task);
        $this->assertEquals('Test task', $task['description']);
        $this->assertFalse($task['completed']);
    }
    /**
     * @test
     * @description test task completed
     */
    public function testCompleteTask() {
        $task = $this->model->addTask('Test task to complete');
        $this->assertFalse($task['completed']); // Initially, the task is not completed

        $this->model->completeTask($task['id']);
        $task = $this->model->getAllTasks()[$task['id']];

        // Check that the task is now completed
        $this->assertTrue($task['completed']);
    }

    public function testDeleteTask() {
        $task = $this->model->addTask('Test task to delete');
        $tasksBefore = $this->model->getAllTasks();
        $this->assertCount(1, $tasksBefore);

        $this->model->deleteTask($task['id']);
        $tasksAfter = $this->model->getAllTasks();

        // Check that the task has been deleted
        $this->assertCount(0, $tasksAfter);
    }

    public function testChangeTaskDescription() {
        $task = $this->model->addTask('Old description');
        $this->assertEquals('Old description', $task['description']);

        $this->model->changeTaskDescription($task['id'], 'New description');
        $task = $this->model->getAllTasks()[$task['id']];

        // Check that the description has been updated
        $this->assertEquals('New description', $task['description']);
    }

    protected function tearDown(): void {
        // Clean up the in-memory model after tests (no actual file is written)
        unset($this->model);
    }
}
