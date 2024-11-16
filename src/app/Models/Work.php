<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Work extends Model
{
    use HasFactory;

    // Workは一人のUserに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Workは複数のRestを持つ
    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    // この行はクラスの外に出てしまっています。削除または移動する必要があります。
    // $table->date('work_date')->nullable(); // NULLを許可する

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'work_date',
        'work_start',
        'work_finish',
    ];

    // The attributes that should be cast.
    protected $casts = [
        'work_date' => 'date',
        'work_start' => 'datetime:H:i:s',
        'work_finish' => 'datetime:H:i:s',
    ];
}
