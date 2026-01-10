<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_number',
        'user_id',
        'category_id',
        'reporter_name',
        'reporter_phone',
        'reporter_email',
        'is_anonymous',
        'incident_type',
        'incident_description',
        'incident_location',
        'incident_address',
        'latitude',
        'longitude',
        'incident_date',
        'incident_time',
        'victim_info',
        'perpetrator_info',
        'witness_info',
        'evidence_files',
        'status',
        'priority',
        'severity',
        'assigned_to',
        'admin_notes',
        'resolution_notes',
        'resolved_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'victim_info' => 'array',
        'perpetrator_info' => 'array',
        'witness_info' => 'array',
        'evidence_files' => 'array',
        'incident_date' => 'date',
        'resolved_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
