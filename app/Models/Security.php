<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;

    protected $table = 'tblSecurity';
    public $guarded = [];
    public $timestamps = false;

    public function auctioneer()
    {
        return $this->hasOne(Profile::class, 'id', 'auctioneerRef');
    }

}
