<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.isArray tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayIsArrayTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-1.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-2.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-3.js.
     */
    public function test1543203(): void
    {
        self::assertTrue(Arr::isArray(new Arr()), 'Arr::isArray(new Arr()) must return true');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-4.js.
     */
    public function test1543204(): void
    {
        self::assertFalse(Arr::isArray(42), 'Arr::isArray(42) must return false');
        self::assertFalse(Arr::isArray(null), 'Arr::isArray(null) must return false');
        self::assertFalse(Arr::isArray(true), 'Arr::isArray(true) must return false');
        self::assertFalse(Arr::isArray('abc'), 'Arr::isArray("abc") must return false');
        self::assertFalse(Arr::isArray(new \stdClass()), 'Arr::isArray(new \stdClass) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-5.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-6.js.
     */
    public function test1543206(): void
    {
        self::assertTrue(Arr::isArray(new Arr(10)), 'Arr::isArray(new Arr(10)) must return true');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-7.js.
     */
    public function test1543207(): void
    {
        self::assertFalse(Arr::isArray((object) []), 'Arr::isArray((object) []) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-10.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-11.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-12.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-13.js.
     */
    public function test15432113(): void
    {
        $arg = (static fn (): array => \func_get_args())(1, 2, 3);

        self::assertFalse(Arr::isArray($arg), 'Arr::isArray($arguments) must return false');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-15.js.
     */
    public function test15432115(): void
    {
        // In JS this is the global object; in PHPUnit $this is the test instance.
        self::assertFalse(Arr::isArray($this), 'Arr::isArray($this) must return false');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-1.js.
     */
    public function test1543211(): void
    {
        self::assertFalse(Arr::isArray(true), 'Arr::isArray(true) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-2.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-3.js.
     */
    public function test1543213(): void
    {
        self::assertFalse(Arr::isArray(5), 'Arr::isArray(5) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-4.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-5.js.
     */
    public function test1543215(): void
    {
        self::assertFalse(Arr::isArray('abc'), 'Arr::isArray("abc") must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-6.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-7.js.
     */
    public function test1543217(): void
    {
        self::assertFalse(Arr::isArray(static function (): void {}), 'Arr::isArray(static function() {}) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-8.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-9.js.
     */
    public function test1543219(): void
    {
        self::assertFalse(Arr::isArray(new \DateTimeImmutable()), 'Arr::isArray(new \DateTimeImmutable()) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-2-1.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-2-2.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/isArray/15.4.3.2-2-3.js.
     */
    public function test1543223(): void
    {
        self::assertFalse(Arr::isArray(['0' => 12, '1' => 9, 'length' => 2]));
    }

    // SKIPPED: test/built-ins/Array/isArray/descriptor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/proxy.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/isArray/proxy-revoked.js
    // Reason: test262 semantics are not portable to PHP
}
