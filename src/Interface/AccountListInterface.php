<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use Closure;
use IteratorAggregate;
use Countable;
use Ghostwriter\StreamQuestion\Interface\UserListInterface;

/**
 * @extends IteratorAggregate<TransactionInterface>
 */
interface AccountListInterface extends IteratorAggregate, Countable {
    public function has(AccountInterface $account): bool;
    
    public function get(AccountInterface $account): AccountInterface;
    public function add(AccountInterface $account): void;
    public function remove(AccountInterface $account): void;

    public function first(null|Closure $filter = null): ?AccountInterface;
    public function filter(Closure $filter): AccountListInterface;
    
    /**
     * @return array<AccountInterface>
     */
    public function toArray(): array;

    public function owners(): UserListInterface;
    public function transactions(): TransactionListInterface;
}
