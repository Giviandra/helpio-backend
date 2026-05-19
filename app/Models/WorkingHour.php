<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['expert_profile_id', 'day_of_week', 'start_time', 'end_time', 'is_closed'])]
class WorkingHour extends Model
{
    // Relasi balik ke profil ahli
    public function expertProfile(): BelongsTo
    {
        return $this->belongsTo(ExpertProfile::class);
    }
}