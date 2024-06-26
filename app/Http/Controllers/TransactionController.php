<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Jobs\ProcessTransactionsJob;
use App\Models\User;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\TransactionAuthorizationService;
use Exception;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private WalletRepository $walletRepository,
        public TransactionAuthorizationService $transactionAuthorizationService
    ) {
    }

    public function transfer(TransactionRequest $request): Response
    {
        try {
            $payer = User::whereId($request->payer)->first();

            if ($payer->wallet->balance < $request->value) {
                return response('Insufficient balance', Response::HTTP_PAYMENT_REQUIRED);
            }

            $payee = User::whereId($request->payee)->first();

            $payload = [
                'payer_id' => $payer->wallet->id,
                'payee_id' => $payee->wallet->id,
                'value'    => $request->value
            ];

            $this->walletRepository->debitBalance($payer->wallet, $request->value);

            $transaction = $this->transactionRepository->processTransaction($payload);

            ProcessTransactionsJob::dispatch(
                $this->transactionRepository,
                $this->walletRepository,
                $transaction,
                $this->transactionAuthorizationService
            );

            return response('Processing transaction', Response::HTTP_OK);
        } catch (Exception $ex) {
            return response($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
