<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationAvailabilityService
{
  public function __construct(private string $baseUri = 'https://run.mocky.io/v3/')
  {
  }

  public function validateAvailability(): bool
  {
    $response = Http::get($this->baseUri . '54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6')->json();
    if (isset($response['message']) && $response['message']) return true;
    return false;
  }
}
