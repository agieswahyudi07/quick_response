<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeedModel extends Model
{
    use HasFactory;

    protected $table = 'ms_need';

    // Atur kolom yang dapat diisi (fillable)
    protected $fillable = [
        'need_name',
        'need_item',
        'need_detail',
        'need_qty',
        'need_price',
        'complaint_id',
        'created_at',
        'updated_at',
    ];

    // Atur kolom yang harus disembunyikan (hidden)
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'need_id';

    public function complaint()
    {
        return $this->belongsTo(ComplaintModel::class, 'complaint_id');
    }

    public function priority()
    {
        return $this->belongsTo(PriorityModel::class, 'priority_id');
    }
}
