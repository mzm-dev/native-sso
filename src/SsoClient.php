<?php

namespace Mzm\PhpSso;

use Mzm\PhpSso\Auth\SsoAuthenticator;
use Mzm\PhpSso\Session\SessionManager;
use Mzm\PhpSso\Database\UserFinderInterface;
use Mzm\PhpSso\Database\DefaultUserFinder;

class SsoClient
{
    protected $ssoBaseUrl;
    protected $redirectHome;
    protected $userFinder;

    public function __construct(array $config = [])
    {
        $this->ssoBaseUrl = $config['sso_base_url'] ?? '';
        $this->redirectHome = $config['redirect_home'] ?? '/';
        $this->userFinder = $config['user_finder'] ?? new DefaultUserFinder();

        SessionManager::start();
    }

    public function showLogin()
    {
        return ViewRenderer::render('login', []);
    }

    public function handleCallback()
    {
        $token = $_GET['token'] ?? null;

        if (!$token) {
            echo ViewRenderer::render('error', ['message' => 'Token tidak diterima.']);
            exit;
        }

        // Semak token jika valid
        $authenticator = new SsoAuthenticator($this->ssoBaseUrl);
        $userData = $authenticator->validateToken($token);

        if (!$userData) {
            echo ViewRenderer::render('error', ['message' => 'Token tidak sah atau tamat tempoh.']);
            SessionManager::destroy();  // Clear session
            header("Location: /login");  // Redirect ke login
            exit;
        }

        // Cari pengguna dalam pangkalan data
        $localUser = $this->userFinder->findLocalUser($userData);

        if (!$localUser) {
            echo ViewRenderer::render('error', ['message' => 'Pengguna tidak ditemui.']);
            exit;
        }

        // Simpan pengguna dalam session
        SessionManager::set('user', $localUser);

        // Redirect ke halaman utama
        header("Location: {$this->redirectHome}");
        exit;
    }
}
