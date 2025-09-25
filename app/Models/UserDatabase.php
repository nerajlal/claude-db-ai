<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDatabase extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'file_path',
        'original_name',
    ];

    public function owner()
    {
        return $this->belongsTo(Login::class, 'login_id');
    }
}