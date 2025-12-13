<?php

class Operation
{
    public static function getAll()
    {
        return [
            [
                'date' => '2025-11-26',
                'description' => 'Deposit',
                'amount' => 500.00
            ],
            [
                'date' => '2025-11-25',
                'description' => 'Withdrawal',
                'amount' => -200.00
            ]
        ];
    }
}
