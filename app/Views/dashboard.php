<h1>Dashboard</h1>

<?php foreach ($dashboardData as $data): ?>

    <h2>Account type: <?= htmlspecialchars($data['type']) ?></h2>

    <?php if (!empty($data['errorMessage'])): ?>
        <p><?= htmlspecialchars($data['errorMessage']) ?></p>
    <?php endif; ?>

    <p>Balance: <?= number_format($data['balance'], 2) ?> €</p>

    <p>Total Positive: <?= number_format($data['totalPositive'], 2) ?> €</p>
    <p>Total Negative: <?= number_format($data['totalNegative'], 2) ?> €</p>

    <table border="1">
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>

        <?php foreach ($data['operations'] as $op): ?>
            <tr>
                <td><?= htmlspecialchars($op['date']) ?></td>
                <td><?= htmlspecialchars($op['description']) ?></td>
                <td><?= number_format($op['amount'], 2) ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>

<?php endforeach; ?>
