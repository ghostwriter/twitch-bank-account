<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

interface StatementListInterface{
    /**
     * @return array<TransactionInterface>
     */
    public function transactions(): array;
}
