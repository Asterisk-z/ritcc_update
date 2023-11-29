<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileTemp extends Model
{
    use HasFactory;
    protected $table = 'tblProfileTemp';
    public $guarded = [];
    public $timestamps = false;
}
