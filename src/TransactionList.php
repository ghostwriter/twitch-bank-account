<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use DateTimeImmutable;
use Ghostwriter\StreamQuestion\Interface\TransactionInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionListInterface;
use Ghostwriter\StreamQuestion\Interface\Transaction\DepositTransactionInterface;
use Ghostwriter\StreamQuestion\Interface\Transaction\WithdrawTransactionInterface;


final class TransactionList implements TransactionListInterface {
    /**
     * @param  array<TransactionInterface> $transactions
     */
    public function __construct(
        private array $transactions = [],
    ) {
    }

    public function balance(): int {
        return array_reduce(
            $this->transactions,
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

    public function first(null|\Closure $filter = null): ?TransactionInterface
    {
        $filter ??= static fn (TransactionInterface $transaction) => true;
        
        foreach ($this as $transaction) {
            if (! $filter($transaction)) {
                continue;
            }

            return $transaction;
        }

        return null;
    }

    public function on(DateTimeImmutable $date): self  
    {
        return $this->filter(static fn(TransactionInterface $transaction) => $transaction->date()->getTimestamp() === $date->getTimestamp());
    }

    public function between(DateTimeImmutable $startDate, DateTimeImmutable $endDate): self
    {
        return $this->filter(
            static fn(TransactionInterface $transaction) => 
            $transaction->date()->getTimestamp() >= $startDate->getTimestamp() &&
            $transaction->date()->getTimestamp() <= $endDate->getTimestamp()
        );
    }



    public function toArray(): array  
    {
        return $this->transactions;
    }

    public function add(TransactionInterface $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    public function remove(TransactionInterface $transaction): void
    {
        $this->transactions = array_filter(
            $this->transactions,
            fn (TransactionInterface $t) => $t !== $transaction
        );
    }

    public function filter(callable $filter): TransactionListInterface
    {
        return new TransactionList(array_filter($this->transactions, $filter));
    }

    public function map(callable $mapper): TransactionListInterface
    {
        return new TransactionList(array_map($mapper, $this->transactions));
    }

    public function reduce(callable $reducer, $initialValue): mixed
    {
        return array_reduce($this->transactions, $reducer, $initialValue);
    }

    public function sort(callable $comparator): TransactionListInterface
    {
        $transactions = $this->transactions;
        usort($transactions, $comparator);
        return new TransactionList($transactions);
    }

    public function count(): int
    {
        return count($this->transactions);
    }

    public function getIterator(): \Generator
    {
        yield from $this->transactions;
    }


 }