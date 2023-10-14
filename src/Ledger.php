<?php

declare(strict_types=1);

namespace Ghostwriter\StreamQuestion;

use Ghostwriter\StreamQuestion\Interface\AccountListInterface;
use Ghostwriter\StreamQuestion\Interface\AccountInterface;
use Ghostwriter\StreamQuestion\Account;
use Ghostwriter\StreamQuestion\Deposit;
use Ghostwriter\StreamQuestion\Interface\ClosedAccountInterface;
use Ghostwriter\StreamQuestion\Interface\UserInterface;
use Ghostwriter\StreamQuestion\Interface\UserListInterface;
use Ghostwriter\StreamQuestion\Interface\TransactionListInterface;
use Ghostwriter\StreamQuestion\StatementList;
use Ghostwriter\StreamQuestion\Interface\StatementListInterface;

final class Ledger 
{
    public function __construct(
        private readonly AccountListInterface $accounts,
    ) {
    }

    public function accounts(): AccountListInterface
    {
        return $this->accounts;
    }

    public function owners(): UserListInterface
    {
        return $this->accounts->owners();
    }

    public function statements(UserInterface $user): StatementListInterface
    {
        return new StatementList($this->transactionsForUser($user)->toArray());
    }

    public function transactionsForUser(UserInterface $user): TransactionListInterface
    {
        return $this->accounts
            ->filter(static fn(AccountInterface $account): bool => $account->owner() === $user)
            ->transactions();
    }


    public function transactions(): TransactionListInterface
    {
        return $this->accounts->transactions();
    }

    public function open(string $name, int $amount): AccountInterface
    {
        $account = new Account(new User($name));

        if ($this->accounts->has($account)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Account already exists for %s.',
                    $account->owner()->name()
                )
            );
        }

        return $this->deposit($account, $amount);
    }

    public function close(AccountInterface $account): ClosedAccountInterface
    {
        if (! $this->accounts->has($account)) {
            throw new \InvalidArgumentException('Account not found.');
        }

        $currentAccount = $this->accounts->get($account);

        return new ClosedAccount(
            $this->withdraw(
                $currentAccount, 
                $currentAccount->balance()
            )
        );
    }

    public function deposit(AccountInterface $account, int $amount): AccountInterface
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        $account = $this->accounts->get($account);
        $this->accounts->remove($account);

        $updatedAccount = $account->deposit(new Deposit($amount));
        $this->accounts->add($updatedAccount);

        return $account;
    }

    public function withdraw(AccountInterface $account, int $amount): AccountInterface
    {
        if ($this->accounts->has($account)){
            throw new \InvalidArgumentException('Account does not belong to this owner');
        }

        $account = $this->accounts->get($account);
        $this->accounts->remove($account);

        $updatedAccount = $account->withdraw(new Withdraw($amount));
        $this->accounts->add($updatedAccount);

        return $account;
    }
}
