<?php

namespace App\Models;

use app\User;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
