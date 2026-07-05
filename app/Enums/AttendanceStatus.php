<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case Present    = 'present';
    case Sick       = 'sick';
    case Permission = 'permission';
    case Absent     = 'absent';

    /**
     * Get a human-readable label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Present    => 'Present',
            self::Sick       => 'Sick',
            self::Permission => 'Permission',
            self::Absent     => 'Absent',
        };
    }

    /**
     * Get the CSS color class for badge display.
     */
    public function color(): string
    {
        return match ($this) {
            self::Present    => 'emerald',
            self::Sick       => 'amber',
            self::Permission => 'sky',
            self::Absent     => 'red',
        };
    }
}
