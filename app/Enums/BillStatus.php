<?php

namespace App\Enums;

enum BillStatus: string
{
    case Paid   = 'paid';
    case Unpaid = 'unpaid';

    /**
     * Get a human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Paid   => 'Paid',
            self::Unpaid => 'Unpaid',
        };
    }

    /**
     * Get the CSS color class for badge display.
     */
    public function color(): string
    {
        return match ($this) {
            self::Paid   => 'emerald',
            self::Unpaid => 'amber',
        };
    }
}
