<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['expert_profile_id', 'user_id', 'rating', 'comment'])]
class Review extends Model
{
    // Review ini milik seorang ahli
    public function expertProfile(): BelongsTo
    {
        return $this->belongsTo(ExpertProfile::class);
    }

    // Review ini ditulis oleh seorang user (customer)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}