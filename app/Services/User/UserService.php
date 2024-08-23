<?php

namespace App\Services\User;

use App\Exceptions\Error;
use App\Helpers\Code;
use App\Helpers\Message;
use App\Services\User\Dto\CreateUserDto;
use App\Services\User\Dto\UpdateUserDto;
use App\Services\User\Interfaces\UserRepositoryInterface;
use App\Services\User\Interfaces\UserServiceInterface;
use App\Traits\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    use ResponseFormatter;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUser(): array
    {
        try {
            $data = $this->userRepository->getAllUser();
            if (!$data['success']) {
                throw new Error(422, 'Data Not Found');
                // throw new Error($data['code'], $data['message'], $data['error']);
            }
            return $this->success(Code::SUCCESS, $data, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }

    public function getUserById(int $id): array
    {
        try {
            $data = $this->userRepository->getUserById($id);
            if (!$data['success']) {
                throw new Error($data['code'], $data['message'], $data['error']);
            }
            return $this->success(Code::SUCCESS, $data, Message::successGet);
        } catch (Error | \Exception $e) {
            return $this->error($e);
        }
    }

    public function createUser(Request $request): array
    {
        DB::beginTransaction();
        try {
            $dto = new CreateUserDto($request->name, $request->email, $request->password);
            $dto->validate();

            $data = $this->userRepository->createUser($dto);
            if (!$data['success']) {
                throw new Error(422, 'Failed To Add Data');
                // throw new Error($data['code'], $data['message'], $data['error']);
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $data, Message::successCreate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function updateUser(Request $request, int $id): array
    {
        DB::beginTransaction();
        try {
            $dto = new UpdateUserDto(
                $id,
                $request->name,
                $request->email,
                $request->password
            );
            $dto->validate();

            $data = $this->userRepository->updateUser($dto, $id);
            if (!$data['success']) {
                throw new Error($data['code'], $data['message'], $data['error']);
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $data, Message::successUpdate);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }

    public function deleteUser(int $id): array
    {
        DB::beginTransaction();
        try {
            $data = $this->userRepository->deleteUser($id);
            if (!$data['success']) {
                throw new Error($data['code'], $data['message'], $data['error']);
            }

            DB::commit();
            return $this->success(Code::SUCCESS, $data, Message::successDelete);
        } catch (Error | \Exception $e) {
            DB::rollBack();
            return $this->error($e);
        }
    }
}
