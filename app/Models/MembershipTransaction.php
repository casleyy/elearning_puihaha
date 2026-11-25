<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTransaction extends Model
{
    protected $fillable = ['member_id', 'reference_number', 'type', 'status', 'amount', 'period_starts_at', 'period_ends_at'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'period_starts_at' => 'date', 'period_ends_at' => 'date'];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
