<?php

namespace Mzm\PhpSso;

use Mzm\PhpSso\Helpers\Logger;

class ViewRenderer
{
    public static function render($view, $data = [])
    {
        extract($data);
        $viewFile = __DIR__ . "/Views/{$view}.php";

        if (file_exists($viewFile)) {
            ob_start();
            include $viewFile;
            return ob_get_clean();
        }

        Logger::log("ViewRenderer : View {$view} tidak dijumpai.");
        return "View {$view} tidak dijumpai.";
    }
}
