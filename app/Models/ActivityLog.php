<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'tblActivityLog';
    // public $guarded = [];
    public $timestamps = false;
    protected $fillable = [
        'id', 'date', 'app', 'type', 'activity', 'username'
    ];
}
