<?php

namespace App\Services\User\Dto;

use App\Traits\Validation;

class UpdateUserDto
{

	use Validation;

	private int $id;
	private string $name;
	private string $email;
	private string $password;

	public function __construct(
		int $id,
		string $name,
		string $email,
		string $password
	) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->password = $password;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'email' => $this->getEmail(),
			'password' => $this->getPassword(),
		];
	}

	public function validate(): void
	{
		$data = $this->toArray();
		$rules = [
			'id' => 'required|integer',
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users,email',
			'password' => 'required|string|min:8',
		];
		$messages = [
			'id.required' => 'ID is required.',
			'id.integer' => 'ID must be an integer.',
			'name.required' => 'Nama wajib diisi.',
			'name.string' => 'Nama harus berupa teks.',
			'name.max' => 'Nama maksimal 255 karakter.',
			'email.required' => 'Email wajib diisi.',
			'email.email' => 'Email harus dalam format yang benar.',
			'email.max' => 'Email maksimal 255 karakter.',
			'email.unique' => 'Email sudah terdaftar.',
			'password.required' => 'Password wajib diisi.',
			'password.min' => 'Password minimal 8 karakter.',
		];
		$this->validateData($data, $rules, $messages);
	}
}
