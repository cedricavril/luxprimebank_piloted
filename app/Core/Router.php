<?php

declare(strict_types=1);

/*namespace App\Core;*/

/*use App\Controllers\TransferController;
use App\Controllers\DashboardController;
use App\Services\TransferService;
use App\Repositories\AccountRepository;
*/
class Router
{
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $action = $_POST['action'] ?? null;

        if ($method === 'POST' && $action !== null) {
            $this->handlePostAction($action);
            return;
        }

        $this->renderDashboard();
    }

    private function handlePostAction(string $action): void
    {
        switch ($action) {

            case 'transfer':
                $this->handleTransfer();
                break;

            default:
                $this->renderDashboard();
        }
    }

    private function handleTransfer(): void
    {
        $controller = new TransferController(
            new TransferService(
                new AccountRepository()
            )
        );

        $controller->handle();
    }

    private function renderDashboard(): void
    {
        $controller = new DashboardController();
        $controller->show();
    }
}
