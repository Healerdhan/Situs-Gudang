<?php

namespace App\Services\Mutasi\Dto;

use App\Traits\Validation;

class CreateMutasiDto
{
	use Validation;

	private string $tanggal;
	private string $jenis_mutasi;
	private int $jumlah;
	private int $user_id;
	private string $barang_id;

	public function __construct(
		string $tanggal,
		string $jenis_mutasi,
		int $jumlah,
		int $user_id,
		string $barang_id
	) {
		$this->tanggal = $tanggal;
		$this->jenis_mutasi = $jenis_mutasi;
		$this->jumlah = $jumlah;
		$this->user_id = $user_id;
		$this->barang_id = $barang_id;
	}

	public function getTanggal(): string
	{
		return $this->tanggal;
	}

	public function getJenisMutasi(): string
	{
		return $this->jenis_mutasi;
	}

	public function getJumlah(): int
	{
		return $this->jumlah;
	}

	public function getUserId(): int
	{
		return $this->user_id;
	}

	public function getBarangId(): string
	{
		return $this->barang_id;
	}

	public function toArray(): array
	{
		return [
			'tanggal' => $this->getTanggal(),
			'jenis_mutasi' => $this->getJenisMutasi(),
			'jumlah' => $this->getJumlah(),
			'user_id' => $this->getUserId(),
			'barang_id' => $this->getBarangId()
		];
	}

	public function validate(): void
	{
		$data = $this->toArray();
		$rules = [
			'tanggal' => 'required|date',
			'jenis_mutasi' => 'required|string|max:255',
			'jumlah' => 'required|integer|min:1',
			'user_id' => 'required|exists:users,id|integer',
			'barang_id' => 'required|exists:barangs,id|uuid',
		];
		$messages = [
			'tanggal.required' => 'Tanggal is required.',
			'tanggal.date' => 'Tanggal must be a valid date.',
			'jenis_mutasi.required' => 'Jenis mutasi is required.',
			'jenis_mutasi.string' => 'Jenis mutasi must be a string.',
			'jumlah.required' => 'Jumlah is required.',
			'jumlah.integer' => 'Jumlah must be an integer.',
			'jumlah.min' => 'Jumlah must be at least 1.',
			'user_id.required' => 'User ID is required.',
			'user_id.exists' => 'User ID must exist in the users table.',
			'barang_id.required' => 'Barang ID is required.',
			'barang_id.exists' => 'Barang ID must exist in the barang table.',
			'barang_id.uuid' => 'Barang ID must be a valid UUID.',
		];
		$this->validateData($data, $rules, $messages);
	}
}
