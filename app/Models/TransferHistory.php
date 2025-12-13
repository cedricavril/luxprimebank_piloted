<?php

class TransferHistory
{
    /**
     * In-memory storage for transfer logs (temporary, no database yet)
     */
    private static array $logs = [];

    /**
     * Log a transfer
     */
    public static function log(
        int $sourceAccountId,
        int $targetAccountId,
        float $amount,
        string $status
    ): void {
        self::$logs[] = [
            'source_account_id' => $sourceAccountId,
            'target_account_id' => $targetAccountId,
            'amount'            => $amount,
            'status'            => $status,
            'date'              => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Return all transfer logs
     */
    public static function getAll(): array
    {
        return self::$logs;
    }

    /**
     * Clear all logs (for tests only)
     */
    public static function clear(): void
    {
        self::$logs = [];
    }

    /**
     * Get all transfers by source account ID
     */
    public static function getBySourceAccount(int $accountId): array
    {
        return array_values(array_filter(
            self::$logs,
            fn ($row) => $row['source_account_id'] === $accountId
        ));
    }

    /**
     * Get all transfers by target account ID
     */
    public static function getByTargetAccount(int $accountId): array
    {
        return array_values(array_filter(
            self::$logs,
            fn ($row) => $row['target_account_id'] === $accountId
        ));
    }
    
}
