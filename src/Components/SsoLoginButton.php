<?php


/**
 * 
 * require_once '/path/to/autoload.php'; // pastikan autoload SSO

 * use Mzm\PhpSso\Components\SsoLoginButton;

 * // Panggil untuk paparkan butang
 * SsoLoginButton::render();
 */

namespace Mzm\PhpSso\Components;

class SsoLoginButton
{
    /**
     * Paparkan butang login SSO
     */
    public static function render(array $attributes = []): void
    {
        $url = '/sso/verify'; // URL yang butang akan pergi

        // Sediakan attribute tambahan (cth: class, id, style)
        $class = $attributes['class'] ?? 'btn btn-primary';
        $id = $attributes['id'] ?? 'sso-login-btn';
        $text = $attributes['text'] ?? 'Login dengan SSO';

        echo '<a href="' . htmlspecialchars($url) . '" class="' . htmlspecialchars($class) . '" id="' . htmlspecialchars($id) . '">' . htmlspecialchars($text) . '</a>';
    }
}
