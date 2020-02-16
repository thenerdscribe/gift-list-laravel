<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Gift extends Model
{
    use Searchable;
    public function purchaser()
    {
        return $this->belongsTo('App\User');
    }
    public function receiver()
    {
        return $this->belongsTo('App\User');
    }
    public function giftList()
    {
        return $this->belongsToMany('App\GiftList');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
