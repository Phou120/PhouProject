<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function purchase()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
