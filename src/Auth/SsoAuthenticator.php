<?php

namespace Mzm\PhpSso\Auth;

class SsoAuthenticator
{
    protected $ssoBaseUrl;

    public function __construct(string $ssoBaseUrl)
    {
        $this->ssoBaseUrl = rtrim($ssoBaseUrl, '/');
    }

    public function validateToken(string $token): ?array
    {
        // CURL to SSO Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->ssoBaseUrl}/api/user");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $httpCode = $info['http_code'];

        curl_close($ch);

        if ($httpCode == 200) {
            return json_decode($response, true);
        }

        return null;
    }
}
