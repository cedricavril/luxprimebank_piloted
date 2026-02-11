<?php

class Transfer
{
    private Account $source;
    private Account $target;
    private float $amount;

    /**
     * Transfer constructor
     */
    public function __construct(Account $source, Account $target, float $amount)
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Transfer amount must be positive');
        }

        $this->source = $source;
        $this->target = $target;
        $this->amount = $amount;
    }

    /**
     * Execute the transfer (atomic operation)
     */
    public function execute(): bool
    {

        // Prevent transfer to the same account
        if ($this->source->getId() === $this->target->getId()) {
            TransferHistory::log(
                $this->source->getId(),
                $this->target->getId(),
                $this->amount,
                'REFUSED'
            );
            return false;
        }

        // Block transfer if one of the accounts is blocked
        if ($this->source->getStatus() === 'BLOCKED' || $this->target->getStatus() === 'BLOCKED') {

            TransferHistory::log(
                $this->source->getId(),
                $this->target->getId(),
                $this->amount,
                'FAILED'
            );

            return false;
        }

        // Try to debit source account
        if (!$this->source->applyOperation(-$this->amount)) {

            TransferHistory::log(
                $this->source->getId(),
                $this->target->getId(),
                $this->amount,
                'FAILED'
            );

            return false;
        }

        // Credit target account
        $this->target->applyOperation($this->amount);

        // Log successful transfer
        TransferHistory::log(
            $this->source->getId(),
            $this->target->getId(),
            $this->amount,
            'SUCCESS'
        );

        return true;
    }


}
