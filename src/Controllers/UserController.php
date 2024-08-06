<?php

namespace App\Controllers;

use App\Response\ErrorResponse;
use App\Models\User;
use App\Response\JsonResponse;

class UserController
{
    private array $users;

    public function __construct()
    {
        $this->users = [
            new User(1, 'John Doe', 'Male', 30, '123 Elm Street'),
            new User(2, 'Jane Smith', 'Female', 25, '456 Oak Avenue')
        ];
    }

    private function validateId($id): void
    {
        if (! is_numeric($id) || $id <= 0) {
            $response = new ErrorResponse('Invalid user ID', 400);
            $response->send();
        }
    }

    public function getAllUsers(): void
    {
        $userArray = array_map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'gender' => $user->gender,
                'age' => $user->age,
                'address' => $user->address
            ];
        }, $this->users);
        $response = new JsonResponse($userArray);
        $response->send();
    }

    public function getUserById($id): void
    {
        $this->validateId($id);

        $user = array_filter($this->users, fn(User $user) => $user->id == $id);
        if ($user) {
            $response = new JsonResponse(array_values($user)[0]);
        } else {
            $response = new ErrorResponse('User not found', 404);
        }
        $response->send();
    }
}