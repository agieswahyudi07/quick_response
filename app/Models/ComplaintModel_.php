<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComplaintModel extends Model
{
    use HasFactory;

    protected $table = 'ms_complaint';

    protected $fillable = [
        'complaint_name',
        'complaint_reporter',
        'complaint_location',
        'complaint_time',
        'complaint_date',
        'complaint_desc',
        'status_id',
        'priorty_id',
        'created_at',
        'updated_at',
        'proceed_at',
    ];

    public function index()
    {
        $result = DB::table('ms_complaint')
            ->where('status_id', '=', '1')
            ->get();

        return $result;
    }

    public function queue()
    {
        $result = DB::table('ms_complaint')
            ->where('status_id', '=', '1')
            ->orderBy('priority_id', 'asc')
            ->get();
        return $result;
    }

    public function queue_process($id)
    {
        $result = DB::table('ms_complaint')->where('complaint_id', '=', $id)->first();

        return $result;
    }

    public function priority()
    {
        $result = DB::table('ms_priority')
            ->get();

        return $result;
    }

    public function priority_name($param)
    {
        $result = DB::table('ms_priority')
            ->where('priority_id', '=', $param)
            ->first();

        return $result;
    }


    protected $hidden = [

        'created_at',
        'updated_at',
        'proceed_at',
    ];

    protected $primaryKey = [
        'complaint_id'
    ];
}
