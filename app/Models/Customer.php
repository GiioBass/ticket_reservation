<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'identification_number',
        'name',
        'email',
        'phone',
        'address'
    ];

    /**
     * @param $value
     * @return string
     */
    public function setNameAttribute($value): string
    {
        return $this->attributes['name'] = strtoupper($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movement(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Movement::class);
    }

}
