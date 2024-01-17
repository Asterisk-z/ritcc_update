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
    public $with = ['packages', 'institutions'];

    // Define the relationship to Package
    public function packages()
    {
        return $this->belongsTo(Package::class, 'package', 'ID');
    }

    // Define the relationship to Institution
    public function institutions()
    {
        return $this->belongsTo(Institution::class, 'institution', 'ID');
    }
}
