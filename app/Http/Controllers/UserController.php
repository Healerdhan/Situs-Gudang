<?php

namespace App\Http\Controllers;

use App\Services\User\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->userService->getAllUser());
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->userService->createUser($request));
    }

    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->userService->getUserById(intval($id)));
    }

    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->userService->updateUser($request, intval($id)));
    }

    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        return $this->response($this->userService->deleteUser(intval($id)));
    }
}
