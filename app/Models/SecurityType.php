<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityType extends Model
{
    use HasFactory;

    protected $table = 'tblSecurityType';
    public $guarded = [];
    public $timestamps = false;
}
