<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InspectionChecklistItem extends Model
{
    use HasFactory;

    protected $table = 'inspection_checklist_items';

    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'component',
        'status',
        'notes',
    ];

    public function report()
    {
        return $this->belongsTo(InspectionReport::class, 'report_id');
    }
}