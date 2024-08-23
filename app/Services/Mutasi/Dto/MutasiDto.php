<?php

namespace App\Services\Mutasi\Dto;

class MutasiDto
{
  private int $id;
  private string $tanggal;
  private string $jenis_mutasi;
  private int $jumlah;
  private int $user_id;
  private string $barang_id;

  public function __construct(
    int $id,
    string $tanggal,
    string $jenis_mutasi,
    int $jumlah,
    int $user_id,
    string $barang_id
  ) {
    $this->id = $id;
    $this->tanggal = $tanggal;
    $this->jenis_mutasi = $jenis_mutasi;
    $this->jumlah = $jumlah;
    $this->user_id = $user_id;
    $this->barang_id = $barang_id;
  }


  public function getId(): int
  {
    return $this->id;
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
      'id' => $this->getId(),
      'tanggal' => $this->getTanggal(),
      'jenis_mutasi' => $this->getJenisMutasi(),
      'jumlah' => $this->getJumlah(),
      'user_id' => $this->getUserId(),
      'barang_id' => $this->getBarangId()
    ];
  }


  public static function fromData(object $data): self
  {
    return new self(
      $data->id,
      $data->tanggal,
      $data->jenis_mutasi,
      $data->jumlah,
      $data->user_id,
      $data->barang_id
    );
  }
}
