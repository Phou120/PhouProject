<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    public function format()
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'logo'=>$this->logo,
            'logo.url' => config('services.file_path.restaurant_logo') . $this->logo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function rest()
    {
        return $this->hasMany(Category::class);
    }
}
