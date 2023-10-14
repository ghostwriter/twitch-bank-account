<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use DateTimeImmutable;
use Ghostwriter\StreamQuestion\Interface\AccountInterface;
use Ghostwriter\StreamQuestion\Interface\Transaction\DepositTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\Transaction\WithdrawTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionListInterface;
use Ghostwriter\StreamQuestion\Interface\UserInterface;
use Ghostwriter\StreamQuestion\TransactionList;



final readonly class Account implements AccountInterface {
    public function __construct(
        private readonly UserInterface $owner,
        private readonly TransactionListInterface $transactionList = new TransactionList(),
        private readonly DateTimeImmutable $openingDate = new DateTimeImmutable(),
        private readonly int $ceiling = 0
    ) {
    }

    public function owner(): UserInterface
    {
        return $this->owner;
    }

    public function balance(): int
    {
        return $this->transactionList->balance();
    }

    public function ceiling(): int
    {
        return $this->ceiling;
    }

    public function transactions(): TransactionListInterface
    {
        return $this->transactionList;
    }
    public function toArray(): array
    {
        return $this->transactionList->toArray();
    }

    public function deposit (DepositTransactionInterface $amount): self
    {
        $this->transactionList->add($amount);

        return $this;
    }


    public function withdraw(WithdrawTransactionInterface $amount): self
    {
        $this->transactionList->add($amount);

        return $this;
    }
 }