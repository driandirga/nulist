<?php

namespace App\Services;

interface TodoListService
{
    public function saveTodo(string $id, string $todo): void;

    public function getTodoList():array;

    public function removeTodo(string $todoId);
}
