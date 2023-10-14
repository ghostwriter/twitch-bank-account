<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use DateTimeImmutable;

interface TransactionInterface {
    public function amount(): int;
    public function date(): DateTimeImmutable;
}
