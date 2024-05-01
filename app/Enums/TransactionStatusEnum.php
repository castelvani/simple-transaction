<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case Processing = 'Processing';

    case Reversed = 'Reversed';
    
    case Finished = 'Finished';
}
