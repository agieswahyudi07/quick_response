<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PriorityModel extends Model
{

    use HasFactory;

    protected $table = 'ms_priority';

    // Atur kolom yang dapat diisi (fillable)
    protected $fillable = [
        'priority_name',
        'priority_code',
    ];

    // Atur kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'created_at',
        'updated_at',
        'proceed_at',
    ];

    protected $primaryKey = 'priority_id';
}
