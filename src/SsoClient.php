<?php

namespace Mzm\PhpSso;

use Mzm\PhpSso\Auth\SsoAuthenticator;
use Mzm\PhpSso\Session\SessionManager;
use Mzm\PhpSso\Database\UserFinderInterface;
use Mzm\PhpSso\Database\DefaultUserFinder;
use Mzm\PhpSso\Enums\Config;
use Mzm\PhpSso\Enums\Cons;
use Mzm\PhpSso\Helpers\Logger;

class SsoClient
{
    public $ssoToken;
    public $ssoBaseUrl;
    public $ssoOrigin;
    protected $redirectHome;
    protected $userFinder;

    public function __construct(array $config = [])
    {

        $this->ssoToken = $config[Cons::SSO_TOKEN->value] ?? Config::SSO_TOKEN->value;
        $this->ssoOrigin = $config[Cons::SSO_ORIGIN->value] ??   Config::SSO_ORIGIN->value;
        $this->ssoBaseUrl = $config[Cons::SSO_BASE_URL->value] ??   Config::SSO_BASE_URL->value;
        $this->redirectHome = $config[Cons::SSO_HOME->value] ??   Config::SSO_HOME->value;
        $this->userFinder = $config[Cons::SSO_USER_FINDER->value] ??  new DefaultUserFinder();

        SessionManager::start();
    }


    public function showLogin()
    {
        return ViewRenderer::render('login', []);
    }

    public function handleCallback()
    {
        $token = $_COOKIE[Cons::COOKIES_TOKEN->value] ?? null;

        if (!$token) {
            echo ViewRenderer::render('error', ['message' => 'Token tidak diterima.']);
            Logger::log("SsoClent handleCallback : Token tidak diterima.");
            SessionManager::destroy();  // Clear session
            header("Location: /sso/login");  // Redirect ke login
            exit;
        }

        // Semak token jika valid
        $authenticator = new SsoAuthenticator($this->ssoBaseUrl, $this->ssoOrigin, $this->ssoToken);
        $userData = $authenticator->validateToken($token);


        if (!$userData || isset($userData['error'])) {
            echo ViewRenderer::render('error', [
                'message' => $userData['error'] ??  'Token tidak sah atau tamat tempoh.'
            ]);
            Logger::log("SsoClent handleCallback : Token tidak sah atau tamat tempoh.");
            SessionManager::destroy();  // Clear session
            header("Location: /sso/login");  // Redirect ke login
            exit;
        }

        SessionManager::set(Cons::SESSION_SSO_USER->value, $userData['data']);  // Clear session

        // Cari pengguna dalam pangkalan data
        $localUser = $this->userFinder->findLocalUser($userData['data']);

        if (!$localUser) {
            echo ViewRenderer::render('error', ['message' => 'Pengguna tidak ditemui.']);
            Logger::log("SsoClent handleCallback : Pengguna tidak ditemui.");
            exit;
        }

        // Simpan pengguna dalam session        
        SessionManager::set(Cons::SESSION_USER->value, $localUser);

        // Redirect ke halaman utama
        header("Location: {$this->redirectHome}");
        exit;
    }

    public function handleVerifyAuthenticated()
    {
        return $this->handleCallback($_COOKIE[Cons::COOKIES_TOKEN->value] ?? null);
    }
}
