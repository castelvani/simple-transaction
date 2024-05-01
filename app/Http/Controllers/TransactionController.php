<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\User;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private WalletRepository $walletRepository
    ) {
    }

    public function transfer(TransactionRequest $request): Response
    {
        $payer = User::whereId($request->payer)->first();

        if ($payer->wallet->balance < $request->value) {
            return response('Insufficient balance', Response::HTTP_PAYMENT_REQUIRED);
        }
        
        $payee = User::whereId($request->payee)->first();
        
        $payload = [
            'payer_id' => $payer->wallet->id,
            'payee_id' => $payee->wallet->id,
            'value' => $request->value
        ];

        $this->walletRepository->updateBalance($payer->wallet, $request->value);

        $this->transactionRepository->processTransaction($payload);
        return response('Processing transaction', Response::HTTP_OK);        
    }
}
