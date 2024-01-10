<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;
    protected $table = 'tblAuction';
    public $guarded = [];
    public $timestamps = false;

    public $with = ['auctioneer'];

    public function security()
    {
        return $this->hasOne(Security::class, 'id', 'securityRef');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'auctionRef', 'id');
    }


    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneerRef', 'id');
    }
}
