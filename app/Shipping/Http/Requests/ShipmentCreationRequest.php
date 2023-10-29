<?php

namespace App\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "platform"                  => ["required", "in:kwickbox,aramex"],
            "cod"                       => ["required", "boolean"],
            "pickup_date"               => ["required", "date"],
            "sender"                    => ["required", "array"],
            "sender.name"               => ["required", "string"],
            "sender.phone"              => ["required", "string"],
            "sender.email"              => ["bail", "nullable", "email"],
            "sender.country"            => ["required", "string"],
            "sender.state"              => ["bail", "nullable", "string"],
            "sender.city"               => ["required", "string"],
            "sender.postal_code"        => ["bail", "nullable", "numeric", "gt:0"],
            "sender.address_line1"      => ["required", "string"],
            "sender.address_line2"      => ["bail", "nullable", "string"],
            "sender.address_line3"      => ["bail", "nullable", "string"],
            "recipient"                 => ["required", "array"],
            "recipient.name"            => ["required", "string"],
            "recipient.phone"           => ["required", "string"],
            "recipient.email"           => ["bail", "nullable", "email"],
            "recipient.country"         => ["required", "string"],
            "recipient.state"           => ["bail", "nullable", "string"],
            "recipient.city"            => ["required", "string"],
            "recipient.postal_code"     => ["bail", "nullable", "numeric", "gt:0"],
            "recipient.address_line1"   => ["required", "string"],
            "recipient.address_line2"   => ["bail", "nullable", "string"],
            "recipient.address_line3"   => ["bail", "nullable", "string"],
            "items"                     => ["required", "array"],
            "items.*.title"             => ["required", "string"],
            "items.*.description"       => ["bail", "nullable", "string"],
            "items.*.quantity"          => ["required", "numeric", "gt:0"],
            "items.*.weight"            => ["required", "numeric"],
            "items.*.unit"              => ["required", "in:kg,gm"],
            "items.*.price"             => ["required", "numeric", "gt:0"],
        ];
    }
}
