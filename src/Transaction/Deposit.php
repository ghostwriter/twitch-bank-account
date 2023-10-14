<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Transaction;

use Ghostwriter\StreamQuestion\Interface\Transaction\DepositTransactionInterface;
use Ghostwriter\StreamQuestion\Traits\TransactionTrait;

final readonly class Deposit implements DepositTransactionInterface
{
    use TransactionTrait;
}