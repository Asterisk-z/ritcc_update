<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionTemp extends Model
{
    use HasFactory;
    protected $table = 'tblInstitutionTemp';
    public $guarded = [];
    public $timestamps = false;
}
