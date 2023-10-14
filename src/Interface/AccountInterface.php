<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use Ghostwriter\StreamQuestion\Interface\Transaction\DepositTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\Transaction\WithdrawTransactionInterface;

interface AccountInterface {
    public function owner(): UserInterface;
    public function balance(): int;
    public function ceiling(): int;
    public function deposit (DepositTransactionInterface $amount): self;

    public function withdraw(WithdrawTransactionInterface $amount): self;

    /** @return array<TransactionInterface> */
    public function toArray(): array;
    public function transactions(): TransactionListInterface;
}
