<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'edrpou',
        'address',
    ];

    public function versions(): HasMany
    {
        return $this->hasMany(CompanyVersion::class);
    }
}
