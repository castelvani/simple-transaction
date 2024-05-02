<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Notifications\TransactionReceived;
use App\Services\NotificationAvailabilityService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NotifyTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Transaction $transaction,
        public NotificationAvailabilityService $notificationAvailabilityService
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = $this->notificationAvailabilityService->validateAvailability();

        if ($response) {
            Notification::send($this->transaction->payee->user, new TransactionReceived());
        }
    }
}
