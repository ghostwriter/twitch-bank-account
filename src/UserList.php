<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use Closure;
use Generator;
use Ghostwriter\StreamQuestion\Interface\UserInterface;
use Ghostwriter\StreamQuestion\Interface\UserListInterface;

final class UserList implements UserListInterface
{
    public function __construct(
        private array $users = []
    ) {
    }

    public function has(UserInterface $user): bool
    {
        foreach($this as $current){
            if ($current === $user){
                return true;
            }
        }
        return false;
    }
    public function get(UserInterface $user): UserInterface
    {
        foreach($this as $current){
            if ($current === $user){
                return $current;
            }
        }

        throw new \InvalidArgumentException('User not found.');
    }
    public function add(UserInterface $user): void
    {
        $this->users[] = $user;
    }
    public function remove(UserInterface $user): void
    {
        foreach($this->users as $key => $current){
            if ($current === $user){
                unset($this->users[$key]);
            }
        }
    }
    public function first(null|Closure $filter = null): ?UserInterface
    {
        foreach($this as $current){
            return $current;
        }
        return null;
    }
    
    /**
     * @return array<UserInterface>
     */
    public function toArray(): array
    {
        return $this->users;
    }

    public function count(): int
    {
        return iterator_count($this);
    }
    public function getIterator(): Generator
    {
        yield from $this->users;
    }
}