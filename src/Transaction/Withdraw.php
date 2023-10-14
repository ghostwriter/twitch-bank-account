<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Transaction;

use Ghostwriter\StreamQuestion\Interface\Transaction\WithdrawTransactionInterface;
use Ghostwriter\StreamQuestion\Traits\TransactionTrait;


final readonly class Withdraw implements WithdrawTransactionInterface
{
    use TransactionTrait;
}