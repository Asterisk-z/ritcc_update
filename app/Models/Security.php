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

    public $with = ['auctioneer'];

    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneerRef', 'id');
    }
}
