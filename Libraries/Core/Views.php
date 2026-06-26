<?php

class Views {
    public function render($viewPath, $data = []) {
    
        $parts = explode("/", $viewPath);
        $folder = ucfirst($parts[0]);
        $file   = $parts[1] ?? 'index';
        $fullPath = "Views/{$folder}/{$file}.php";

        if (!file_exists($fullPath)) {
            echo "<p style='color:red'>Vista no encontrada: {$fullPath}</p>";
            return;
        }

        $contentView = $fullPath;

        if ($folder === 'Login') {
            require_once $contentView;
        } else {
            require_once "Views/Layouts/main.php";
        }
    }
}