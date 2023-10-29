<?php

namespace App\Integrations\KwickBox;

use Illuminate\Support\Facades\Http;

final class KwickBox
{
    private string $baseUrl = "https://system.kwick-box.com/api/external/";

    public function __construct(
        private string $apiKey,
    ) {
    }

    public function getRequest(string $endpoint)
    {
        return Http::withHeaders([
            "ApiKey" => $this->apiKey,
        ])->get($this->fullUrl($endpoint));
    }

    public function postRequest(string $endpoint, array $body)
    {
        return Http::withHeaders([
            "ApiKey" => $this->apiKey,
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ])->retry(3, 1000)
            ->post($this->fullUrl($endpoint), $body);
    }

    private function fullUrl(string $endpoint): string
    {
        return $this->baseUrl . ltrim($endpoint, "/");
    }
}
