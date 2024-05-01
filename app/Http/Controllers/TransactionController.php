<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepository $transactionRepository
    ) {
    }

    public function transfer(TransactionRequest $request): Response
    {
        $this->transactionRepository->transfer($request->all());
        return response('Transaction succesfully finished', Response::HTTP_OK);
    }
}
