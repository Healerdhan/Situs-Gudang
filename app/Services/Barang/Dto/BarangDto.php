<?php

namespace App\Services\Barang\Dto;

use PhpParser\Node\Expr\Cast\Object_;

class BarangDto
{
  private string $id;
  private string $nama_barang;
  private int $kode;
  private string $kategori;
  private string $lokasi;

  public function __construct(
    string $id,
    string $nama_barang,
    string $kode,
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

  public static function fromData(object $data): self
  {
    return new self(
      $data->id,
      $data->nama_barang,
      $data->kode,
      $data->kategori,
      $data->lokasi,
    );
  }
}
