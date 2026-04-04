<?php

putenv('APP_ENV=prod');

require_once __DIR__ . '/app/Core/Autoloader.php';
require_once __DIR__ . '/app/Core/Container.php';

/*à virer vu qu'on a l'autoloader, virer dès que ça marche en prod.*/

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/Controller.php';

require_once __DIR__ . '/app/Models/Account.php';
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Models/Operation.php';

require_once __DIR__ . '/app/Models/Transfer.php';
require_once __DIR__ . '/app/Models/TransferHistory.php';

require_once __DIR__ . '/app/Repositories/AccountRepository.php';

require_once __DIR__ . '/app/Services/AuthService.php';

require_once __DIR__ . '/app/Controllers/DashboardController.php';

// \à virer vu qu'on a l'autoloader, virer dès que ça marche en prod.

$container = new Container();

$container->set('AccountRepository', function () {
    return new AccountRepository();
});

$container->set('SessionManager', function () {
    return new SessionManager();
});

$container->set('AuthService', function ($c) {
    return new AuthService(
        $c->get('AccountRepository'),
        $c->get('SessionManager')
    );
});

return $container;