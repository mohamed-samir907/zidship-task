<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function sender()
    {
        return $this->hasOne(ShipmentDetail::class, "shipment_id")->where("type", "sender");
    }

    public function recipient()
    {
        return $this->hasOne(ShipmentDetail::class, "shipment_id")->where("type", "recipient");
    }

    public function items()
    {
        return $this->hasMany(ShipmentItem::class, "shipment_id");
    }
}
