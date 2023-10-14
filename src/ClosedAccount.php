<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use DateTimeImmutable;
use Ghostwriter\StreamQuestion\Interface\DepositTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\UserInterface;
use Ghostwriter\StreamQuestion\Interface\AccountInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionListInterface;
use Ghostwriter\StreamQuestion\Interface\WithdrawTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionInterface;
use Ghostwriter\StreamQuestion\Interface\ClosedAccountInterface;


final readonly class ClosedAccount implements ClosedAccountInterface {
    public function __construct(
        private readonly AccountInterface $account,
        private readonly DateTimeImmutable $closingDate = new DateTimeImmutable(),
    ) {
    }
    public function closingDate(): DateTimeImmutable
    {
        return $this->closingDate;
    }

    public function account(): AccountInterface
    {
        return $this->account;
    }
    public function owner(): UserInterface
    {
        return $this->account->owner();
    }

    public function balance(): int
    {
        return array_reduce(
            $this->transactions()->toArray(),
            static function (int $balance, TransactionInterface $transaction): int {
                return match(true) {
                    default => throw new \Exception('Unknown transaction type'),
                    $transaction instanceof WithdrawTransactionInterface => $balance - $transaction->amount(),
                    $transaction instanceof DepositTransactionInterface => $balance + $transaction->amount(),
                };
            },
            0
        );
    }

    public function ceiling(): int
    {
        return $this->account->ceiling();
    }

    public function toArray(): array
    {
        return $this->account->transactions()->toArray();
    }

    public function transactions(): TransactionListInterface
    {
        return $this->account->transactions();
    }

    public function deposit (TransactionInterface $amount): void
    {
        throw new \Exception('Account is closed');
    }


    public function withdraw(TransactionInterface $amount): void
    {
        throw new \Exception('Account is closed');
    }
 }