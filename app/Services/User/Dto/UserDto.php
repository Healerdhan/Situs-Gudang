<?php

namespace App\Services\User\Dto;

class UserDto
{
  public int $id;
  private string $name;
  private string $email;
  private ?string $email_verified_at;
  private string $created_at;
  private string $updated_at;

  public function __construct(
    int $id,
    string $name,
    string $email,
    ?string $email_verified_at,
    string $created_at,
    string $updated_at
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->email_verified_at = $email_verified_at;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
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

  public function getEmailVerifiedAt(): ?string
  {
    return $this->email_verified_at;
  }

  public function getCreatedAt(): string
  {
    return $this->created_at;
  }

  public function getUpdatedAt(): string
  {
    return $this->updated_at;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'email' => $this->getEmail(),
      'email_verified_at' => $this->getEmailVerifiedAt(),
      'created_at' => $this->getCreatedAt(),
      'updated_at' => $this->getUpdatedAt(),
    ];
  }

  public static function fromData(object $data): self
  {
    return new self(
      $data->id,
      $data->name,
      $data->email,
      $data->email_verified_at ?? null,
      $data->created_at,
      $data->updated_at,
    );
  }
}
