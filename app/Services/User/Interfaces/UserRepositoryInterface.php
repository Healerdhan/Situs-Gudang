<?php

namespace App\Services\User\Interfaces;

use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;

interface UserRepositoryInterface
{
  public function getAllUser(): array;
  public function getUserById(int $id): array;
  public function createUser(CreateUserDto $data): array;
  public function updateUser(UpdateUserDto $data, int $id): array;
  public function deleteUser(int $id): array;
}
