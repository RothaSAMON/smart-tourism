<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('table_provinces')]
#[Fillable(['name', 'image', 'description', 'status'])]
class Province extends Model
{
    use HasFactory;

    /**
     * @return HasMany<Attraction, $this>
     */
    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }
}
