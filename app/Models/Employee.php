<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address;
use App\Models\EmployeeRole;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'first_name', 'last_name', 'address_id', 'employee_role_id'];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(EmployeeRole::class, 'employee_role_id', 'id');
    }
}
