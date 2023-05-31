<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * @return HasMany
     */
    public function shiftManager(): HasMany
    {
        return $this->hasMany(ShiftManager::class, 'shift_id', 'id');
    }
}
