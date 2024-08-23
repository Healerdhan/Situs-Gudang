<?php

namespace App\Services\User\Interfaces;

use Illuminate\Http\Request;

interface UserServiceInterface
{
  public function getAllUser(): array;
  public function getUserById(int $id): array;
  public function createUser(Request $request): array;
  public function updateUser(Request $request, int $id): array;
  public function deleteUser(int $id): array;
}
