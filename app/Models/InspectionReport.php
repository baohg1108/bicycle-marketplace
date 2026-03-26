<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InspectionReport extends Model
{
    use HasFactory;

    protected $table = 'inspection_reports';

    public $timestamps = false;

    protected $fillable = [
        'request_id',
        'inspector_id',
        'overall_condition',
        'frame_condition',
        'brake_condition',
        'drivetrain_condition',
        'wheelset_condition',
        'electrical_condition',
        'summary',
        'recommendation',
        'report_url',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function request()
    {
        return $this->belongsTo(InspectionRequest::class, 'request_id');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
    public function checklistItems()
    {
    return $this->hasMany(InspectionChecklistItem::class, 'report_id');
    }
    public function labels()
    {
    return $this->hasMany(InspectionLabel::class);
    }
}