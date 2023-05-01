<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Profiler\Profile;

class Customer extends Model
{
    use HasFactory;

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'profile.url' => config('services.file_master.customer_profile') . $this->profile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
