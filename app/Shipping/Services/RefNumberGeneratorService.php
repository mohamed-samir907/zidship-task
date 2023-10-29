<?php

namespace App\Shipping\Services;

use Exception;

class RefNumberGeneratorService
{
    /**
     * Generate unique hash.
     *
     * @param  int $length
     * @return string
     */
    public function generate(int $length = 8): string
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }

        return substr(bin2hex($bytes), 0, $length);
    }
}
