<?php
/*namespace App\Controllers;*/

/*require_once __DIR__ . '/../Core/Controller.php';*/
require_once __DIR__ . '/../Models/Account.php';
require_once __DIR__ . '/../Models/Operation.php';
require_once __DIR__ . '/../Models/User.php';

/*class DashboardController extends Controller*/
class DashboardController
{
    public function index()
    {


        // Create a dummy authenticated user (temporary, no session yet)
        $user = new User(
            1,
            'john.doe@test.com',
            'John',
            'Doe',
            'USER'
        );

        $accounts = $user->getAccounts();

        $dashboardData = [];

        foreach ($accounts as $account) {

            $operationModel = (!empty($_GET['corrupted']) && $_GET['corrupted'] === '1')
                ? CorruptedOperation::class
                : Operation::class;

            $operations = $operationModel::getAll();

            $totalPositive = 0;
            $totalNegative = 0;
            $errorMessage = null;

            foreach ($operations as $operation) {
                $amount = $operation['amount'];

                if (!$account->applyOperation($amount)) {
                    $errorMessage = 'Error: Negative balance detected';
                    break;
                }

                if ($amount >= 0) {
                    $totalPositive += $amount;
                } else {
                    $totalNegative += abs($amount);
                }

            }

            $dashboardData[] = [
                'type'          => $account->getType(),
                'balance'       => $account->getBalance(),
                'operations'    => $operations,
                'totalPositive' => $totalPositive,
                'totalNegative' => $totalNegative,
                'errorMessage'  => $errorMessage
            ];
        }

        require __DIR__ . '/../Views/dashboard.php';
    }
    public function show(): void
    {
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo 'Access denied';
    return;
}
        $accounts = $user->getAccounts();

        require __DIR__ . '/../Views/dashboard.php';
    }

}