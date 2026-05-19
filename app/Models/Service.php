<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['category_id', 'name', 'slug', 'description'])]
class Service extends Model
{
    // Relasi: Jasa ini milik satu Kategori tertentu
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}