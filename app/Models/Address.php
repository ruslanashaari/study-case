<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Address extends Model
{
    use HasFactory, SoftDeletes;

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

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id', 'address_id');
    }
}
