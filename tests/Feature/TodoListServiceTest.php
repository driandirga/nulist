<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testNuListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'lorem');

        $nulist = Session::get('todolist');
        foreach ($nulist as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('lorem', $value['todo']);
        }
    }

    public function testGetTodoEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'lorem'
            ],
            [
                'id' => '2',
                'todo' => 'ipsum'
            ],
        ];

         $this->todoListService->saveTodo('1','lorem');
         $this->todoListService->saveTodo('2','ipsum');

         self::assertEquals($expected,$this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo('1','lorem');
        $this->todoListService->saveTodo('2','ipsum');

        self::assertEquals(2,sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');

        self::assertEquals(2,sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');

        self::assertEquals(1,sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');

        self::assertEquals(0,sizeof($this->todoListService->getTodoList()));
    }


}
