<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'profile',
    ];

    public static function scopeSearch($search)
    {
        return empty($search) ? static::query()
            : static::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->orWhere('address', 'like', '%' . $search . '%')
            ->orWhere('profile', 'like', '%' . $search . '%');
    }

    public function allServices()
    {
        return $this->belongsToMany(Service::class, 'service_employees', 'id_employee', 'id_service');
    }
}
