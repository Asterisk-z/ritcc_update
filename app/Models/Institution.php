<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $table = 'tblInstitution';
    public $guarded = [];
    public $timestamps = false;
    // Define the inverse relationship to Profile
    public function profiles()
    {
        return $this->hasMany(Profile::class, 'Institution', 'ID');
    }
}
