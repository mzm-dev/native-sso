<?php

namespace Mzm\PhpSso\Auth;

use Mzm\PhpSso\Helpers\Logger;

class SsoAuthenticator
{
    protected $ssoBaseUrl;
    protected $ssoOrigin;
    protected $ssoToken;

    public function __construct(string $ssoBaseUrl, string $ssoOrigin, string $ssoToken)
    {
        $this->ssoBaseUrl = rtrim($ssoBaseUrl, '/');
        $this->ssoOrigin = $ssoOrigin;
        $this->ssoToken = $ssoToken;
    }

    public function validateToken(string $token): ?array
    {

        // CURL to SSO Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$this->ssoBaseUrl}/api/user");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Authorization: Bearer {$token}",
            "X-Client-Origin: {$this->ssoOrigin}",
            "X-Client-Token: {$this->ssoToken}",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $httpCode = $info['http_code'];

        curl_close($ch);

        if ($httpCode == 200) {
            Logger::log("Curl Success : {$this->ssoBaseUrl}/api/user");
            return json_decode($response, true);
        } else {
            Logger::log("Curl error: " . curl_error($ch));
            Logger::log("Curl Status {$httpCode} : ". json_decode($response, true));            
        }

        return null;
    }
}
