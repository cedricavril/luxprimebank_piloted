<?php

class Router
{
    public function dispatch($uri)
    {
        // Normalize URI (remove query string)
        $uri = parse_url($uri, PHP_URL_PATH);

        // Root route redirects to dashboard
        if ($uri === '/' || $uri === '') {
            require __DIR__ . '/../Controllers/DashboardController.php';
            $controller = new DashboardController();
            return $controller->index();
        }

        if ($uri === '/dashboard') {
            require __DIR__ . '/../Controllers/DashboardController.php';
            $controller = new DashboardController();
            return $controller->index();
        }

        echo "404";
    }
}
