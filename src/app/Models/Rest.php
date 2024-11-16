<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rest extends Model
{
    use HasFactory;

    // Restは一つのWorkに属する
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    // Mass assignable attributes
    protected $fillable = [
        'work_id',
        'rest_start',
        'rest_finish',
    ];

    // The attributes that should be cast.
    protected $casts = [
        'rest_start' => 'datetime:H:i:s',
        'rest_finish' => 'datetime:H:i:s',
    ];

    public function getUserNameById()
  {
    return DB::table('rests')
            ->join('users', 'rests.user_id', '=', 'users.id')
            ->get();
  }
}
