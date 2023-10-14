<?php


declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Tests;

use Ghostwriter\StreamQuestion\Transaction\Deposit;
use Ghostwriter\StreamQuestion\TransactionList;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Ghostwriter\StreamQuestion\User;
use Ghostwriter\StreamQuestion\AccountList;
use Ghostwriter\StreamQuestion\Account;
use Ghostwriter\StreamQuestion\Ledger;

#[CoversClass(Ledger::class)]
final class LedgerTest extends TestCase
{
    public function testOwnerHasName(): void
    {
        $john = [
            'name' => 'John Doe',
            'balance' => 1000
        ];

        $jane = [
            'name' => 'Jane Doe',
            'balance' => 25000
        ];

        $people = [$jane, $john];
        $users = [];
        $accounts = [];
        $allTransactions = [];

        foreach($people as $person){
            $name = $person['name'];
            $balance = $person['balance'];
            $transactions = [];

            $users[] = $user = new User($name);

            $allTransactions[] = $transactions[] = $deposit = new Deposit($balance);

            $transactionsList = new TransactionList($transactions);
            self::assertSame($transactions, $transactionsList->toArray());

            $accounts[] = $account = new Account($user, $transactionsList);

            self::assertSame($name, $user->name());
            self::assertSame($name, $account->owner()->name());

            self::assertSame($balance, $deposit->amount());

            self::assertSame($balance, $account->balance());

            self::assertCount(1, $transactions);
        }

        $accountList = new AccountList($accounts);

        $ledger = new Ledger($accountList);
        
        $actualAccounts = $ledger->accounts();
        foreach($actualAccounts as $actualAccountKey => $actualAccount)
        {
            self::assertSame($accounts[$actualAccountKey], $actualAccount);
        }


        $actualUsers =$ledger->owners();
        foreach($actualUsers as $actualUserKey => $actualUser){
            self::assertSame($users[$actualUserKey], $actualUser);
        }
    }
}