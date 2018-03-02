<?php 

namespace App\Models\Enum;

abstract class NotificationStatus
{
    const CREATED = 0;
    const SENT = 1;
    const RECEIVED = 2;

    const TEXTS = [
        self::CREATED => 'Agendada',
        self::SENT => 'Envida',
        self::RECEIVED => 'Recebida com Sucesso',
    ];
}