<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileApp extends Model
{
    protected $fillable = ['version', 'file_name', 'file_path', 'is_active'];
}
