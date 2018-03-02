<?php 

namespace App\Models\Enum;

abstract class WithdrawalStatus
{
    const REQUESTED = 0;
    const PROCESSING = 1;
    const PAID = 2;

    const TEXTS = [
        self::REQUESTED => 'Solicitado',
        self::PROCESSING => 'Processando',
        self::PAID => 'Pago',
    ];
}