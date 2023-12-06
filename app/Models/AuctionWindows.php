<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionWindows extends Model
{
    use HasFactory;
    protected $table = 'tblAuctionWindows';
    public $guarded = [];
    public $timestamps = false;
}
