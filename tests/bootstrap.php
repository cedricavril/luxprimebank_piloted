<?php

putenv('APP_ENV=test');

require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Controller.php';

require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/Operation.php';

require_once __DIR__ . '/../app/Models/Transfer.php';
require_once __DIR__ . '/../app/Models/TransferHistory.php';

require_once __DIR__ . '/../app/Repositories/AccountRepository.php';

require_once __DIR__ . '/../app/Controllers/DashboardController.php';
