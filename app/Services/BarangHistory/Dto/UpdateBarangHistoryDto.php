<?php

namespace App\Services\BarangHistory\Dto;

use App\Traits\Validation;

class UpdateBarangHistoryDto
{

	use Validation;

	public function __construct() {}

	public function toArray(): array
	{
		return [];
	}

	public function validate(): void
	{
		$data = $this->toArray();
		$rules = [];
		$messages = [];
		$this->validateData($data, $rules, $messages);
	}
}
