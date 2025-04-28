<?php

namespace Mzm\PhpSso;

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

        return "View {$view} tidak dijumpai.";
    }
}
