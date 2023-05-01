<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    public function format()
    {
        return [
            'id'=>$this->id,
            'food'=> [
                'name' =>$this->food->name,
                'type' =>$this->food->type->name,

            ],
            'qty'=>$this->qty,
            'price'=>$this->price,
        ];
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }


}
