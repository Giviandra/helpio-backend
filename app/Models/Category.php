<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'icon', 'description'])]
class Category extends Model
{
    // Relasi: Satu Kategori memiliki banyak Jasa
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}