<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEmployee extends Model
{
    use HasFactory;

    protected $table = 'service_employees';
    protected $fillable = ['id_service', 'id_employee'];

    public static function scopeSearch($search)
    {
        return empty($search) ? static::query()
            : static::where('id_service', 'like', '%' . $search . '%')
            ->orWhere('id_employee', 'like', '%' . $search . '%');
    }

    public function oneService()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
    public function oneEmployee()
    {
        return $this->belongsTo(Employee::class, 'id_employee');
    }
}
