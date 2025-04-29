<?php

namespace Mzm\PhpSso\Middleware;

use Mzm\PhpSso\Enums\Cons;
use Mzm\PhpSso\Helpers\Logger;
use Mzm\PhpSso\Session\SessionManager;

class AuthMiddleware
{
    public function handle()
    {
        $user = SessionManager::get(Cons::SESSION_SSO_USER->value);
        if (!$user) {
            Logger::log("AuthMiddeware : Tiada session user, redirect ke halaman login.");
            // Jika tiada session user, redirect ke halaman login
            header('Location: /login');
            exit;
        }
    }
}
