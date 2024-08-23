<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceConfigProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    // Daftarkan service binding di sini
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // Inisialisasi layanan di sini
    // Barang
    $this->app->bind(\App\Services\Barang\Interfaces\BarangServiceInterface::class, \App\Services\Barang\BarangService::class);
    $this->app->bind(\App\Services\Barang\Interfaces\BarangRepositoryInterface::class, \App\Services\Barang\BarangRepository::class);

    $this->app->bind(\App\Services\User\Interfaces\UserServiceInterface::class, \App\Services\User\UserService::class);
    $this->app->bind(\App\Services\User\Interfaces\UserRepositoryInterface::class, \App\Services\User\UserRepository::class);

    // Mutasi
    $this->app->bind(\App\Services\Mutasi\Interfaces\MutasiServiceInterface::class, \App\Services\Mutasi\MutasiService::class);
    $this->app->bind(\App\Services\Mutasi\Interfaces\MutasiRepositoryInterface::class, \App\Services\Mutasi\MutasiRepository::class);
  }
}
