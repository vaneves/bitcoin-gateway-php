<?php 

namespace App\Models\Enum;

abstract class InvoiceStatus
{
    const WAITING = 0;
    const INCOMPLETE = 1;
    const PAID = 2;
    const DISPUTE = 3;
    const RETURNED = 4;
    const CANCELED = 5;

    const TEXTS = [
        self::WAITING => 'Aguardando Pagamento',
        self::INCOMPLETE => 'Pagamento Incompleto',
        self::PAID => 'Pago',
        self::DISPUTE => 'Em Disputa',
        self::RETURNED => 'Devolvido',
        self::CANCELED => 'Cancelado',
    ];
}