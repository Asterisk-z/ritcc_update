<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = 'tblPackage';
    public $guarded = [];
    public $timestamps = false;

    // Define the inverse relationship to Profile
    public function profiles()
    {
        return $this->hasMany(Profile::class, 'Package', 'ID');
    }
}
