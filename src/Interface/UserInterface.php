<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;
interface UserInterface {
    public function name(): string;
    public function id(): int;
}