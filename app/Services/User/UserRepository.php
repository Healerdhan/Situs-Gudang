<?php

namespace App\Services\User;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Models\User;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Dto\UserDto;
use App\Services\User\Interfaces\UserRepositoryInterface;
use App\Traits\PaginationResponse;
use App\Traits\RequestFilter;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
  use ResponseFormatter, PaginationResponse, RequestFilter;
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getAllUser(): array
  {
    try {
      $users = $this->user->all();
      if ($users->isEmpty()) {
        throw new Error(404, 'No User Found');
      }
      $response = array();

      foreach ($users as $user) {
        $userDto = new UserDto(
          $user->id,
          $user->name,
          $user->email,
          $user->email_verified_at,
          $user->created_at,
          $user->updated_at
        );
        $response[] = $userDto->toArray();
      }

      return $this->success(Code::SUCCESS, $response, Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function getUserById(int $id): array
  {
    try {
      $user = $this->user->find($id);
      if (!$user) {
        throw new Error(422, 'User Not Found');
      }

      $response = new UserDto(
        $user->id,
        $user->name,
        $user->email,
        $user->email_verified_at,
        $user->created_at,
        $user->updated_at
      );
      return $this->success(Code::SUCCESS, $response->toArray(), Message::successGet);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function createUser(CreateUserDto $data): array
  {
    try {
      $existingUser = $this->user->where('email', $data->getEmail())->first();
      if ($existingUser) {
        throw new Error(409, 'email already exists');
      }
      $user = $this->user->create([
        'name' => $data->getName(),
        'email' => $data->getEmail(),
        'password' => $data->getPassword(),
      ]);

      if (!$user) {
        throw new Error(500, 'Failed to create user');
      }

      // $response = new CreateUserDto(
      //   $user->name,
      //   $user->email,
      //   $user->password
      // );

      return $this->success(Code::SUCCESS, $user, Message::successCreate);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function updateUser(UpdateUserDto $data, int $id): array
  {
    try {
      $user = $this->user->find($id);
      if (!$user) {
        throw new Error(404, 'user not found');
      }
      $user->update([
        'name' => $data->toArray()['name'],
        'email' => $data->toArray()['email'],
        'password' => $data->toArray()['password']
      ]);

      $updatedUser = $this->user->find($id);

      $response = new UserDto(
        $updatedUser->id,
        $updatedUser->name,
        $updatedUser->email,
        $updatedUser->email_verified_at,
        $updatedUser->created_at,
        $updatedUser->updated_at
      );

      return $this->success(Code::SUCCESS, $response, Message::successUpdate);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }

  public function deleteUser(int $id): array
  {
    try {
      $user = $this->user->findOrFail($id);
      if (!$user) {
        throw new Error(404, 'User Not Found');
      }
      $user->delete();

      return $this->success(Code::SUCCESS, Message::successDelete);
    } catch (Error | \Exception $e) {
      return $this->error($e);
    }
  }
}
