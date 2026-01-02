<?php

namespace App\Enum;

enum TransactionType: string
{
    case WITHDRAWAL = 'withdrawal'; // prélèvement
    case DEPOSIT  = 'deposit'; // dépot
}
