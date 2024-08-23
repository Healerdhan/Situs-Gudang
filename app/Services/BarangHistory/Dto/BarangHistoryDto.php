<?php

namespace App\Services\BarangHistory\Dto;

class BarangHistoryDto
{
  private string $id;
  private string $barang_id;
  private string $nama_barang;
  private string $change_description;
  private string $changed_at;
  private string $changed_by;

  public function __construct(
    string $id,
    string $barang_id,
    string $nama_barang,
    string $change_description,
    string $changed_at,
    string $changed_by
  ) {
    $this->id = $id;
    $this->barang_id = $barang_id;
    $this->nama_barang = $nama_barang;
    $this->change_description = $change_description;
    $this->changed_at = $changed_at;
    $this->changed_by = $changed_by;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getBarangId(): string
  {
    return $this->barang_id;
  }

  public function getNamaBarang(): string
  {
    return $this->nama_barang;
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
      'id' => $this->getId(),
      'barang_id' => $this->getBarangId(),
      'nama_barang' => $this->getNamaBarang(),
      'change_description' => $this->getChangeDescription(),
      'changed_at' => $this->getChangedAt(),
      'changed_by' => $this->getChangedBy(),
    ];
  }


  public static function fromData(object $data): self
  {
    return new self(
      $data->id,
      $data->barang_id,
      $data->nama_barang,
      $data->change_description,
      $data->changed_at,
      $data->changed_by,
    );
  }
}
