<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'bio', 'location', 'verified_badge', 'current_status'])]
class ExpertProfile extends Model
{
    // Relasi: Profil ini milik satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}