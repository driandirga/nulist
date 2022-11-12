<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            'user' => 'drian',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'lorem'
                ],
                [
                    'id' => '2',
                    'todo' => 'ipsum'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('lorem')
            ->assertSeeText('2')
            ->assertSeeText('ipsum');
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'drian'
        ])->post('/todolist', [])
            ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'drian'
        ])->post('/todolist', [
            'todo' => 'lorem'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodo()
    {
        $this->withSession([
            'user' => 'drian',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'lorem'
                ],
                [
                    'id' => '2',
                    'todo' => 'ipsum'
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
