<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use Closure;
use Ghostwriter\StreamQuestion\Interface\AccountInterface;
use Ghostwriter\StreamQuestion\Interface\AccountListInterface;
use Ghostwriter\StreamQuestion\Interface\UserInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionListInterface;
use Ghostwriter\StreamQuestion\UserList;
use Ghostwriter\StreamQuestion\Interface\UserListInterface;

final class AccountList implements AccountListInterface {
    /**
     * @param array<AccountInterface> $accounts
     */
    public function __construct(
        private array $accounts = [],
    ) {
    }

    public function owners(): UserListInterface
    {
        return new UserList(array_map(
            static fn(AccountInterface $account): UserInterface =>  $account->owner(),
            $this->accounts
        ));
    }

    public function transactions(): TransactionListInterface
    {
        return new TransactionList([...array_map(
            static fn(AccountInterface $account): array =>  $account->transactions()->toArray(),
            $this->accounts
        )]);
    }
    public function first(null|\Closure $filter = null): ?AccountInterface
    {
        $filter ??= static fn (AccountInterface $account) => true;
        
        foreach ($this as $account) {
            if (! $filter($account)) {
                continue;
            }

            return $account;
        }

        return null;
    }

    public function toArray(): array  
    {
        return $this->accounts;
    }

    public function has(AccountInterface $account): bool
    {
        foreach($this as $current) {
            if ($current === $account) {
                return true;
            }
        }

        return false;
    }

    public function get(AccountInterface $account): AccountInterface
    {
        foreach($this as $current) {
            if ($current === $account) {
                return $current;
            }
        }

        throw new \InvalidArgumentException('Account not found');
    }

    public function add(AccountInterface $account): void
    {
        $this->accounts[] = $account;
    }

    public function remove(AccountInterface $account): void
    {
        $this->accounts = array_filter(
            $this->accounts,
            static fn (AccountInterface $current) => $current !== $account
        );
    }

    public function filter(Closure $filter): AccountListInterface
    {
        return new self(array_filter($this->accounts, $filter));
    }

    public function map(Closure $mapper): AccountListInterface
    {
        return new self(array_map($mapper, $this->accounts));
    }

    public function reduce(Closure $reducer, $initialValue): mixed
    {
        return array_reduce($this->accounts, $reducer, $initialValue);
    }

    public function sort(Closure $comparator): AccountListInterface
    {
        $accounts = $this->accounts;

        usort($accounts, $comparator);

        return new self($accounts);
    }

    public function count(): int
    {
        return count($this->accounts);
    }

    public function getIterator(): \Generator
    {
        yield from $this->accounts;
    }
 }