<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use DateTimeImmutable;
use IteratorAggregate;
use Countable;

/**
 * @extends IteratorAggregate<TransactionInterface>
 */
interface TransactionListInterface extends IteratorAggregate, Countable {
    
    /**
     * @return array<TransactionInterface>
     */
    public function toArray(): array;
    public function balance(): int;
    public function between(DateTimeImmutable $startDate, DateTimeImmutable $endDate): self;
    public function first(null|\Closure $filter = null): ?TransactionInterface;
    public function on(DateTimeImmutable $date): self;
    public function add(TransactionInterface $transaction): void;
    public function remove(TransactionInterface $transaction): void;
}
