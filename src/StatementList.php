<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use Ghostwriter\StreamQuestion\Interface\StatementListInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionInterface;

final class StatementList implements StatementListInterface
{   /**
     * @param array<TransactionInterface> $transaction
     */
    public function __construct(
        private array $transactions = []
    ) {
    }

    /**
     * @return array<TransactionInterface>
     */
    public function transactions(): array
    {
        return $this->transactions;
    }
}