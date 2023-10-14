<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Traits;

use DateTimeImmutable;

trait TransactionTrait {
    public function __construct(
        private readonly int $amount,
        private readonly DateTimeImmutable $date = new DateTimeImmutable(),
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }
    }

    final public function amount(): int
    {
        return $this->amount;
    }

    final public function date(): DateTimeImmutable
    {
        return $this->date;
    }
}