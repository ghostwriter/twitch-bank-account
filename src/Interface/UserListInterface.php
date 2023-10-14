<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use Closure;
use IteratorAggregate;
use Countable;

/**
 * @extends IteratorAggregate<UserInterface>
 */
interface UserListInterface extends IteratorAggregate, Countable {
    public function has(UserInterface $user): bool;
    public function get(UserInterface $user): UserInterface;
    public function add(UserInterface $user): void;
    public function remove(UserInterface $user): void;

    public function first(null|Closure $filter = null): ?UserInterface;
    /**
     * @return array<UserInterface>
     */
    public function toArray(): array;
}
