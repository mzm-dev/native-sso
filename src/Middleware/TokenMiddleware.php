<?php

namespace Mzm\PhpSso\Middleware;

use Mzm\PhpSso\Session\SessionManager;
use Mzm\PhpSso\Auth\SsoAuthenticator;
use Mzm\PhpSso\Enums\Cons;
use Mzm\PhpSso\Helpers\Logger;

class TokenMiddleware
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

    public function handle()
    {
        $user = SessionManager::get(Cons::SESSION_SSO_USER->value);
        if ($user) {
            // Dapatkan token dari sesi
            $token = $user['token'] ?? null;
            if ($token) {
                // Semak token
                $authenticator = new SsoAuthenticator($this->ssoBaseUrl, $this->ssoOrigin, $this->ssoToken);
                $userData = $authenticator->validateToken($token);

                if (!$userData) {
                    // Jika token tidak sah atau tamat tempoh, clear session
                    Logger::log("TokenMiddleware : token tidak sah atau tamat tempoh, clear session.");
                    SessionManager::destroy();
                    header('Location: /login');  // Redirect ke login
                    exit;
                }
            }
        }
    }
}
