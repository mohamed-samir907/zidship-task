<?php

namespace App\Shipping\Enums;

enum Platform: string
{
    case KwickBox = "kwickbox";
    case Aramex = "aramex";
}
