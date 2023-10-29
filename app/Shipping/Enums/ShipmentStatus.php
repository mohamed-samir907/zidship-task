<?php

namespace App\Shipping\Enums;

enum ShipmentStatus: string
{
    case Draft                  = "draft";
    case Unknown                = "unknown";
    case Created                = "created";
    case AssignedForPickup      = "assigned_for_pickup";
    case PickedUp               = "picked_up";
    case PickupFailed           = "pickup_failed";
    case Received               = "received";
    case AssignedForDelivery    = "assigned_for_delivery";
    case CalledRecipient        = "called_recipient";
    case Delivered              = "delivered";
    case FailedDelivery         = "failed_delivery";
    case ReturnedToCustomer     = "returned_to_customer";
    case CodCollected           = "cod_collected"; // cash on delivery
    case Canceled               = "canceled";
}
