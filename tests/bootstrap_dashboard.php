<?php
// fonctionne sans ce ficher en test, donc yagni a priori. à virer dès que tout marche en test et en prod.

putenv('APP_ENV=test');

// Include the Controller directly, avoiding public/index.php
require_once __DIR__ . '/../app/Controllers/DashboardController.php';

// Instantiate and call the controller
$controller = new DashboardController();
$controller->index();