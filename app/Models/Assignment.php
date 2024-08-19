<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'quality_id',
        'purchase_price',
        'sale_price',
        'profit',
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
