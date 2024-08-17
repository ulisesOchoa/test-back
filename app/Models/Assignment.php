<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'quality_id',
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quality()
    {
        return $this->belongsTo(Quality::class);
    }

}
