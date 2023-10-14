<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Interface;

use DateTimeImmutable;

interface ClosedAccountInterface extends AccountInterface {
    public function closingDate(): DateTimeImmutable;
    public function account(): AccountInterface;
}

