<?php
putenv('APP_ENV=test');

// Include the Controller directly, avoiding public/index.php
require_once __DIR__ . '/../app/Controllers/DashboardController.php';

// Instantiate and call the controller
$controller = new DashboardController();
$controller->index();