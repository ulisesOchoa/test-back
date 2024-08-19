<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'identity_number',
        'date_of_joining'
    ];

    public function assignment()
    {
        return $this->hasOne(Assignment::class);
    }
}
