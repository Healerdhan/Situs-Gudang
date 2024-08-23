<?php

namespace App\Services\Barang\Dto;

use App\Traits\Validation;

class CreateBarangDto
{
	use Validation;

	private string $nama_barang;
	private int $kode;
	private string $kategori;
	private string $lokasi;

	public function __construct(
		string $nama_barang,
		string $kode,
		string $kategori,
		string $lokasi
	) {
		$this->nama_barang = $nama_barang;
		$this->kode = $kode;
		$this->kategori = $kategori;
		$this->lokasi = $lokasi;
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
			'nama_barang' => 'required|string|max:255',
			'kode' => 'required|integer|unique:barangs,kode',
			'kategori' => 'required|string|max:255',
			'lokasi' => 'required|string|max:255',
		];
		$messages = [
			'nama_barang.required' => 'Nama barang wajib diisi.',
			'kode.required' => 'Kode wajib diisi.',
			'kode.unique' => 'Kode sudah ada di sistem.',
			'kategori.required' => 'Kategori wajib diisi.',
			'lokasi.required' => 'Lokasi wajib diisi.',
		];
		$this->validateData($data, $rules, $messages);
	}
}
