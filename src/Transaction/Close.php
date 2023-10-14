<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Transaction;

use Ghostwriter\StreamQuestion\Traits\TransactionTrait;
use Ghostwriter\StreamQuestion\Interface\Transaction\CloseTransactionInterface;


final readonly class Close implements CloseTransactionInterface
{
    use TransactionTrait;
}