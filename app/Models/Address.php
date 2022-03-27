<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $appends = ['full_address'];
    protected $guarded = ['id'];

    public function getFullAddressAttribute()
    {
        return $this->address_1
                . $this->address_2 ?? ''
                . $this->district
                . $this->postcode ?? ''
                . $this->city;
    }
}
