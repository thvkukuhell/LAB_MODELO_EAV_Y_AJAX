<?php

spl_autoload_register(function ($clase) {
    $filePath = "Libraries/Core/{$clase}.php";
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}); 