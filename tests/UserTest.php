<?php


declare(strict_types=1);

namespace Ghostwriter\StreamQuestion\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Ghostwriter\StreamQuestion\User;
use InvalidArgumentException;

#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    public function testUserHasName(): void
    {
        $user = new User('John Doe');

        self::assertSame('John Doe', $user->name());
    }

    public function testUserNameMustBeNonEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new User('');
    }
}