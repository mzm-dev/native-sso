<?php

namespace Mzm\PhpSso\Middleware;

use Mzm\PhpSso\Session\SessionManager;

class AuthMiddleware
{
    public function handle()
    {
        $user = SessionManager::get('user');
        if (!$user) {
            // Jika tiada session user, redirect ke halaman login
            header('Location: /login');
            exit;
        }
    }
}
