<?php

namespace App\Services\Barang\Dto;

use App\Traits\Validation;

class UpdateBarangDto
{
	use Validation;

	private string $id;
	private string $nama_barang;
	private int $kode;
	private string $kategori;
	private string $lokasi;


	public function __construct(
		string $id,
		string $nama_barang,
		int $kode,
		string $kategori,
		string $lokasi
	) {
		$this->id = $id;
		$this->nama_barang = $nama_barang;
		$this->kode = $kode;
		$this->kategori = $kategori;
		$this->lokasi = $lokasi;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getNamaBarang(): string
	{
		return $this->nama_barang;
	}

	public function getKode(): int
	{
		return $this->kode;
	}

	public function getKategori(): string
	{
		return $this->kategori;
	}

	public function getLokasi(): string
	{
		return $this->lokasi;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'nama_barang' => $this->getNamaBarang(),
			'kode' => $this->getKode(),
			'kategori' => $this->getKategori(),
			'lokasi' => $this->getLokasi(),
		];
	}

	public function validate(): void
	{
		$data = $this->toArray();
		$rules = [
			'id' => 'required|uuid|exists:barangs,id',
			'nama_barang' => 'required|string',
			'kode' => 'required|integer|unique:barangs,kode,' . $this->getId() . ',id',
			'kategori' => 'required|string',
			'lokasi' => 'required|string',
		];
		$messages = [
			'id.required' => 'ID wajib diisi.',
			'id.uuid' => 'ID harus berupa UUID yang valid.',
			'id.exists' => 'ID tidak ditemukan di sistem.',
			'nama_barang.required' => 'Nama barang wajib diisi.',
			'kode.required' => 'Kode wajib diisi.',
			'kode.unique' => 'Kode sudah ada di sistem.',
			'kategori.required' => 'Kategori wajib diisi.',
			'lokasi.required' => 'Lokasi wajib diisi.',
		];
		$this->validateData($data, $rules, $messages);
	}
}
