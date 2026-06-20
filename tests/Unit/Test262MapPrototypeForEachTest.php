<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.forEach tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeForEachTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/forEach/callback-parameters.js.
     */
    public function testCallbackParameters(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        $seen = [];
        $map->forEach(static function (int $value, string $key, Map $m) use (&$seen, $map): void {
            self::assertSame($map, $m);
            $seen[] = [$key, $value];
        });

        self::assertSame([['a', 1], ['b', 2]], $seen);
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/callback-result-is-abrupt.js
    // Reason: PHP exceptions propagate directly, no completion records

    /**
     * test/built-ins/Map/prototype/forEach/callback-this-non-strict.js.
     */
    public function testCallbackThisNonStaticClosure(): void
    {
        $map = new Map([
            ['a', 1],
        ]);
        $context = new \stdClass();
        $context->called = false;

        $map->forEach(function (): void {
            // @phpstan-ignore-next-line
            $this->called = true;
        }, $context);

        self::assertTrue($context->called);
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/callback-this-strict.js
    // Reason: strict-mode default this binding semantics are not portable

    /**
     * test/built-ins/Map/prototype/forEach/deleted-values-during-foreach.js.
     */
    public function testDeletedValuesDuringForEach(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
            ['c', 3],
        ]);

        $seen = [];
        $map->forEach(static function (int $value, string $key, Map $m) use (&$seen): void {
            $seen[] = $key;

            if ('a' === $key) {
                $m->delete('b');
            }
        });

        self::assertSame(['a', 'c'], $seen);
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/does-not-have-mapdata-internal-slot*.js
    // Reason: methods are invoked on Map instances

    // SKIPPED: test/built-ins/Map/prototype/forEach/first-argument-is-not-callable.js
    // Reason: PHP type system rejects non-callable arguments

    /**
     * test/built-ins/Map/prototype/forEach/forEach.js.
     */
    public function testForEach(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        $called = false;
        $map->forEach(static function (int $value, string $key) use (&$called): void {
            self::assertSame('a', $key);
            self::assertSame(1, $value);
            $called = true;
        });

        self::assertTrue($called);
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-in-key-insertion-order.js.
     */
    public function testIteratesInKeyInsertionOrder(): void
    {
        $map = new Map();
        $map->set('a', 1);
        $map->set('b', 2);
        $map->set('c', 3);

        $seen = [];
        $map->forEach(static function (int $value, string $key) use (&$seen): void {
            $seen[] = $key;
        });

        self::assertSame(['a', 'b', 'c'], $seen);
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-values-added-after-foreach-begins.js.
     */
    public function testIteratesValuesAddedAfterForEachBegins(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        $seen = [];
        $map->forEach(static function (int $value, string $key, Map $m) use (&$seen): void {
            $seen[] = $key;

            if ('a' === $key) {
                $m->set('b', 2);
            }
        });

        self::assertSame(['a', 'b'], $seen);
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-values-deleted-then-readded.js.
     */
    public function testIteratesValuesDeletedThenReadded(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        $seen = [];
        $map->forEach(static function (int $value, string $key, Map $m) use (&$seen): void {
            $seen[] = [$key, $value];

            if ('a' === $key) {
                $m->delete('b');
                $m->set('b', 3);
            }
        });

        self::assertSame([['a', 1], ['b', 3]], $seen);
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/length.js
    // SKIPPED: test/built-ins/Map/prototype/forEach/name.js
    // SKIPPED: test/built-ins/Map/prototype/forEach/not-a-constructor.js

    /**
     * test/built-ins/Map/prototype/forEach/return-undefined.js.
     */
    public function testReturnUndefined(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        self::assertNull($map->forEach(static function (): void {}));
    }

    /**
     * test/built-ins/Map/prototype/forEach/second-parameter-as-callback-context.js.
     */
    public function testSecondParameterAsCallbackContext(): void
    {
        $map = new Map([
            ['a', 1],
        ]);
        $context = new \stdClass();
        $context->value = 0;

        $map->forEach(function (int $v): void {
            // @phpstan-ignore-next-line
            $this->value = $v;
        }, $context);

        self::assertSame(1, $context->value);
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/this-not-object-throw.js
}
