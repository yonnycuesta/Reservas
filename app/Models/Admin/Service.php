<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public static function scopeSearch($search)
    {
        return empty($search) ? static::query()
            : static::where('name', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'service_employees', 'id_service', 'id_employee');
    }
}
