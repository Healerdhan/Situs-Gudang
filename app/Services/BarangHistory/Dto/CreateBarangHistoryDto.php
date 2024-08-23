<?php

namespace App\Services\BarangHistory\Dto;

use App\Traits\Validation;

class CreateBarangHistoryDto
{
	use Validation;

	private string $barang_id;
	private string $change_description;
	private string $changed_at;
	private string $changed_by;

	public function __construct(
		string $barang_id,
		string $change_description,
		string $changed_at,
		string $changed_by
	) {
		$this->barang_id = $barang_id;
		$this->change_description = $change_description;
		$this->changed_at = $changed_at;
		$this->changed_by = $changed_by;
	}


	public function getBarangId(): string
	{
		return $this->barang_id;
	}

	public function getChangeDescription(): string
	{
		return $this->change_description;
	}

	public function getChangedAt(): string
	{
		return $this->changed_at;
	}

	public function getChangedBy(): string
	{
		return $this->changed_by;
	}

	public function toArray(): array
	{
		return [
			'barang_id' => $this->getBarangId(),
			'change_description' => $this->getChangeDescription(),
			'changed_at' => $this->getChangedAt(),
			'changed_by' => $this->getChangedBy(),
		];
	}

	public function validate(): void
	{
		$data = $this->toArray();
		$rules = [
			'barang_id' => 'required|uuid|exists:barangs,id',
			'change_description' => 'required|string',
			'changed_at' => 'required|date',
			'changed_by' => 'required|string',
		];
		$messages = [
			'id.uuid' => 'ID harus berupa UUID yang valid.',
			'barang_id.required' => 'Barang ID wajib diisi.',
			'barang_id.uuid' => 'Barang ID harus berupa UUID yang valid.',
			'barang_id.exists' => 'Barang ID tidak ditemukan di sistem.',
			'change_description.required' => 'Deskripsi perubahan wajib diisi.',
			'changed_at.required' => 'Tanggal perubahan wajib diisi.',
			'changed_at.date' => 'Tanggal perubahan harus berupa tanggal yang valid.',
			'changed_by.required' => 'Pengubah wajib diisi.',
		];
		$this->validateData($data, $rules, $messages);
	}
}
