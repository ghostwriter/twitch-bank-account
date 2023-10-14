<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Transaction;

use Ghostwriter\StreamQuestion\Traits\TransactionTrait;
use Ghostwriter\StreamQuestion\Interface\Transaction\OpenTransactionInterface;

final readonly class Open implements OpenTransactionInterface
{
    use TransactionTrait;
}