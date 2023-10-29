<?php

namespace App\Shipping\Enums;

enum ShipmentDetailsType: string
{
    case Sender     = "sender";
    case Recipient  = "recipient";
}
