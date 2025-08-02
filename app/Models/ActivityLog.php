<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $dates = ['logged_at'];

    protected $fillable = ['user_id', 'activity', 'role', 'ip_address', 'logged_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
