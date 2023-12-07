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
        'complaint_completed_date',
        'complaint_desc',
        'status_id',
        'priority_id',
        'created_at',
        'updated_at',
        'proceed_at',
    ];

    // Atur kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'created_at',
        'updated_at',
        'proceed_at',
    ];

    protected $primaryKey = 'complaint_id';
}
