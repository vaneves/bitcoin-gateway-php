<?php

namespace App\Common;

class Money
{
    public static function toBTC($value)
    {
        return rtrim(number_format($value, 8, ',', '.'), '0') .' BTC';
    }

    public static function calculateFee($value, $fee = null)
    {
        if (!$fee) {
            $fee = env('SITE_FEE');
        }
        if ($fee <= 0) {
            throw new \AppException('Erro ao calcular a taxa', 400);
        }
        return ($value / 100) * $fee;
    }
}