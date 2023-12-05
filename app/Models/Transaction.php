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

    public function auction() {
        return $this->hasOne(Auction::class, 'id', 'auctionRef');
    }
}
