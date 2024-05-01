<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationAvailabilityService
{
  public function __construct(private $baseUri = 'https://run.mocky.io/v3/')
  {
  }

  public function validateAvailability()
  {
    return Http::get($this->baseUri . '54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6');
  }
}
