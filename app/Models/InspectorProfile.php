<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InspectorProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'certification',
        'specialty',
        'service_area',
        'inspection_fee',
        'total_inspected',
        'is_available'
    ];

    protected $casts = [
        'inspection_fee' => 'decimal:2',
        'total_inspected' => 'integer',
        'is_available' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSpecialtyArrayAttribute()
    {
        return $this->specialty
            ? explode(',', $this->specialty)
            : [];
    }

    public function setSpecialtyAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['specialty'] = implode(',', $value);
        } else {
            $this->attributes['specialty'] = $value;
        }
    }
}