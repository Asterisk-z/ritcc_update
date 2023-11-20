<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityTemp extends Model
{
    use HasFactory;

    protected $table = 'tblSecurityTemp';
    public $guarded = [];
    public $timestamps = false;
}
