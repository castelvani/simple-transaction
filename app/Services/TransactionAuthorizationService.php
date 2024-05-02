<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TransactionAuthorizationService
{
  public function __construct(private $baseUri = 'https://run.mocky.io/v3/')
  {
  }

  public function validateTransaction()
  {
    $response = Http::get($this->baseUri . '5794d450-d2e2-4412-8131-73d0293ac1cc')->json();
    if (isset($response['message']) && $response['message'] == 'Autorizado') return true;
    return false;
  }
}
