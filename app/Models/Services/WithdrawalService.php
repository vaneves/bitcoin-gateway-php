<?php 

namespace App\Models\Services;

use App\Models\Entities\Withdrawal;
use App\Models\Enum\IWithdrawalStatus;

class WithdrawalService extends AppService
{
    public function list($user_id)
    {
        $withdrawals = Withdrawal::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $withdrawals;
    }
}