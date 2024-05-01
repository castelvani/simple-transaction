<?php

namespace App\Jobs;

use App\Enums\TransactionStatusEnum;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\TransactionAuthorizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private TransactionRepository $transactionRepository,
        private WalletRepository $walletRepository,
        public Transaction $transaction
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new TransactionAuthorizationService)->validateTransaction();

        if ($response['message'] != 'Autorizado') {
            $this->transactionRepository->executeTransaction($this->transaction);
            $this->walletRepository->creditBalance($this->transaction->payee, $this->transaction->value);
        } else {
            $this->transactionRepository->transactionReversal($this->transaction);
            $this->walletRepository->reverseBalance($this->transaction->payer, $this->transaction->value);
        }
    }
}
