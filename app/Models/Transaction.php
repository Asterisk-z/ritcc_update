<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'tblTransaction';
    public $guarded = [];
    public $timestamps = false;

    public function auction()
    {
        return $this->hasOne(Auction::class, 'id', 'auctionRef');
    }

    public function bidder_obj()
    {
        return $this->hasOne(Profile::class, 'id', 'bidderRef');
    }

    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneerEmail', 'email');
    }

    public function bidder()
    {
        return $this->belongsTo(Profile::class, 'bidderRef', 'id');
    }
}
