<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

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
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'incident_date' => 'date',
        'victim_info' => 'array',
        'perpetrator_info' => 'array',
        'witness_info' => 'array',
        'evidence_files' => 'array',
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

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function statusHistories()
    {
        return $this->hasMany(ReportStatusHistory::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Generate Report Number
    public static function generateReportNumber()
    {
        $date = now()->format('Ymd');
        $lastReport = self::whereDate('created_at', now()->toDateString())
                         ->orderBy('id', 'desc')
                         ->first();

        $number = $lastReport ? (int)substr($lastReport->report_number, -4) + 1 : 1;

        return 'DA-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
