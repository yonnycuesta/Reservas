<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inning extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service',
        'part_day',
        'inning_date',
        'inning_hour',
        'description',
        'status',
        'file_attachment',
    ];

    public static function scopeSearch($search)
    {
        return empty($search) ? static::query()
            : static::where('customer_name', 'like', '%' . $search . '%')
            ->orWhere('customer_email', 'like', '%' . $search . '%')
            ->orWhere('customer_phone', 'like', '%' . $search . '%')
            ->orWhere('inning_date', 'like', '%' . $search . '%');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
