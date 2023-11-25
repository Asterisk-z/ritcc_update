<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Profile extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use HasFactory;
    protected $table = 'tblProfile';
    public $guarded = [];
    public $timestamps = false;

    // Implement the required methods from Authenticatable
    public function getAuthIdentifierName()
    {
        return 'id'; // Replace 'id' with the primary key column name of your tblProfile table
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password; // Replace 'password' with the column name storing passwords in your tblProfile table
    }

    // Define the relationship to Package
    public function package()
    {
        return $this->belongsTo(Package::class, 'Package', 'ID');
    }

    // Define the relationship to Institution
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'Institution', 'ID');
    }

    public function securities()
    {
        return $this->hasMany(Security::class, 'auctioneerRef', 'id');
    }
}
