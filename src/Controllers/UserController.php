<?php

namespace App\Controllers;

use App\Requests\GetUserByIdRequest;
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
            new User(2, 'Jane Smith', 'Female', 25, '456 Oak Avenue'),
            new User(3, 'Michael Brown', 'Male', 40, '789 Pine Road'),
            new User(4, 'Emily White', 'Female', 35, '321 Maple Lane'),
            new User(5, 'David Wilson', 'Male', 28, '654 Birch Boulevard'),
            new User(6, 'Sophia Taylor', 'Female', 22, '987 Cedar Street'),
            new User(7, 'James Anderson', 'Male', 45, '123 Spruce Court'),
            new User(8, 'Olivia Martin', 'Female', 33, '456 Willow Drive'),
            new User(9, 'Daniel Lee', 'Male', 50, '789 Fir Avenue'),
            new User(10, 'Isabella Thompson', 'Female', 27, '321 Aspen Road'),
            new User(11, 'William Harris', 'Male', 38, '654 Poplar Street'),
            new User(12, 'Mia Clark', 'Female', 29, '987 Redwood Lane'),
            new User(13, 'Henry Lewis', 'Male', 42, '123 Alder Boulevard'),
            new User(14, 'Ava Walker', 'Female', 24, '456 Cypress Court'),
            new User(15, 'Lucas King', 'Male', 31, '789 Elm Street'),
            new User(16, 'Charlotte Hall', 'Female', 26, '321 Oak Avenue'),
            new User(17, 'Mason Allen', 'Male', 36, '654 Pine Road'),
            new User(18, 'Amelia Young', 'Female', 23, '987 Maple Lane'),
            new User(19, 'Ethan Scott', 'Male', 47, '123 Birch Boulevard'),
            new User(20, 'Harper Green', 'Female', 32, '456 Cedar Street')
        ];
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
        $request = new GetUserByIdRequest(['id' => $id]);
        $request->validate();

        $user = array_filter($this->users, fn(User $user) => $user->id == $id);
        if ($user) {
            $response = new JsonResponse(array_values($user)[0]);
        } else {
            $response = new ErrorResponse('User not found', 404);
        }
        $response->send();
    }
}