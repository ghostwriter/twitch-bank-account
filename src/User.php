<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use Ghostwriter\StreamQuestion\Interface\UserInterface;

final readonly class User implements UserInterface
{
    private readonly int $id;
    public function __construct(
        private readonly string $name
    ) {

        if (trim($name) === '')
        {
            throw new \InvalidArgumentException('Name MUST be a non-empty-sting.');
        }

        $this->id = spl_object_id($this);
    }
    public function name(): string
    {
        return $this->name;
    }

    public function id(): int
    {
        return $this->id;
    }
}