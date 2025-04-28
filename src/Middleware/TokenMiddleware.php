<?php

namespace Mzm\PhpSso\Middleware;

use Mzm\PhpSso\Session\SessionManager;
use Mzm\PhpSso\Auth\SsoAuthenticator;

class TokenMiddleware
{
    protected $ssoBaseUrl;

    public function __construct(string $ssoBaseUrl)
    {
        $this->ssoBaseUrl = $ssoBaseUrl;
    }

    public function handle()
    {
        $user = SessionManager::get('user');
        if ($user) {
            // Dapatkan token dari sesi
            $token = $user['token'] ?? null;
            if ($token) {
                // Semak token
                $authenticator = new SsoAuthenticator($this->ssoBaseUrl);
                $userData = $authenticator->validateToken($token);

                if (!$userData) {
                    // Jika token tidak sah atau tamat tempoh, clear session
                    SessionManager::destroy();
                    header('Location: /login');  // Redirect ke login
                    exit;
                }
            }
        }
    }
}
