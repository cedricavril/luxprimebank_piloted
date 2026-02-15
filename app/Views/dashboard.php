<?php if (isset($_SESSION['flash_success'])): ?>
    <div class="alert success">
        <?= htmlspecialchars($_SESSION['flash_success']) ?>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash_error'])): ?>
    <div class="alert error">
        <?= htmlspecialchars($_SESSION['flash_error']) ?>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
<?php endif; ?>

<form method="POST" action="/">
    <input type="hidden" name="action" value="transfer">

    <label for="source_account_id">Source account</label>
    <select name="source_account_id" required>
        <?php foreach ($accounts as $account): ?>
            <option value="<?= $account->getId() ?>">
                <?= $account->getType() ?> — <?= $account->getBalance() ?> €
            </option>
        <?php endforeach; ?>
    </select>

    <label for="target_account_id">Target account</label>
    <select name="target_account_id" required>
        <?php foreach ($accounts as $account): ?>
            <option value="<?= $account->getId() ?>">
                <?= $account->getType() ?> — <?= $account->getBalance() ?> €
            </option>
        <?php endforeach; ?>
    </select>

    <label for="amount">Amount</label>
    <input type="number" name="amount" step="0.01" min="0.01" required>

    <button type="submit">Transfer</button>
</form>
