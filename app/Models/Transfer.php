<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    public function from_account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function to_account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
