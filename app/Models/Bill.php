<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'title',
        'description',
        'amount',
        'due_date',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount'   => 'decimal:2',
            'due_date' => 'date',
            'status'   => BillStatus::class,
        ];
    }

    /**
     * Get the student this bill belongs to.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Determine if the bill is overdue (due_date < today AND status = unpaid).
     */
    protected function isOverdue(): Attribute
    {
        return Attribute::get(function () {
            return $this->due_date->lt(now()->startOfDay())
                && $this->status === BillStatus::Unpaid;
        });
    }

    /**
     * Format the amount as IDR currency string.
     */
    public function formattedAmount(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }
}
