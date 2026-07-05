<?php

namespace App\Services;

use App\Enums\BillStatus;
use App\Models\Bill;

class BillService
{
    /**
     * Toggle a bill's payment status between paid and unpaid.
     */
    public function toggleStatus(Bill $bill): void
    {
        $bill->status = $bill->status === BillStatus::Paid
            ? BillStatus::Unpaid
            : BillStatus::Paid;

        $bill->save();
    }
}
