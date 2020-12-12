<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderEvaluation extends Model
{
    protected $fillable = ['order_id', 'client_id', 'comment', 'stars'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
