<?php

spl_autoload_register(function ($class) {

    $map = [
        'Controller' => __DIR__ . '/../Controllers/',
        'Repository' => __DIR__ . '/../Repositories/',
        'Service'    => __DIR__ . '/../Services/',
        'Model'      => __DIR__ . '/../Models/',
    ];

    // Try mapped directories first
    foreach ($map as $suffix => $directory) {
        if (str_ends_with($class, $suffix)) {
            $file = $directory . $class . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }

    // Fallback: search common directories
    $fallback = [
        __DIR__ . '/../Models/',
        __DIR__ . '/../Repositories/',
        __DIR__ . '/../Services/',
        __DIR__ . '/../Controllers/',
        __DIR__ . '/',
    ];

    foreach ($fallback as $directory) {
        $file = $directory . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // If nothing found → explicit error
    throw new Exception("Autoloader: Unable to load class '$class'");
});