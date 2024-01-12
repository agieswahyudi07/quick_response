<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ComplaintModel extends Model
{

    use HasFactory;

    protected $table = 'ms_complaint';

    // Atur kolom yang dapat diisi (fillable)
    protected $fillable = [
        'complaint_name',
        'complaint_reporter',
        'complaint_location',
        'complaint_time',
        'complaint_date',
        'complaint_desc',
        'status_id',
        'priority_id',
        'proceed_at',
        'completed_at',
        'complaint_cause',
        'complaint_solution',
        'created_at',
        'updated_at',
    ];

    // Atur kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'complaint_id';

    public function status()
    {
        return $this->belongsTo(StatusModel::class, 'status_id');
    }

    public function priority()
    {
        return $this->belongsTo(PriorityModel::class, 'priority_id');
    }
}
