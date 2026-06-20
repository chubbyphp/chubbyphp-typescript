<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.getOrInsertComputed tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeGetOrInsertComputedTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/returns-existing-value.js.
     */
    public function testReturnsExistingValue(): void
    {
        $map = new Map([['a', 1]]);

        $calls = 0;
        $value = $map->getOrInsertComputed('a', static function () use (&$calls): int {
            ++$calls;

            return 2;
        });

        self::assertSame(1, $value);
        self::assertSame(0, $calls);
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/inserts-computed-value.js.
     */
    public function testInsertsComputedValue(): void
    {
        $map = new Map();

        $value = $map->getOrInsertComputed('a', static fn (string $key): string => 'default for '.$key);

        self::assertSame('default for a', $value);
        self::assertSame('default for a', $map->get('a'));
        self::assertSame(1, $map->size);
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/callback-receives-key.js.
     */
    public function testCallbackReceivesKey(): void
    {
        $map = new Map();

        $received = null;
        $map->getOrInsertComputed('key', static function (string $key) use (&$received): string {
            $received = $key;

            return 'value';
        });

        self::assertSame('key', $received);
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/callback-not-called-when-key-exists.js.
     */
    public function testCallbackNotCalledWhenKeyExists(): void
    {
        $map = new Map([['a', 'existing']]);

        $calls = 0;
        $value = $map->getOrInsertComputed('a', static function () use (&$calls): string {
            ++$calls;

            return 'new';
        });

        self::assertSame('existing', $value);
        self::assertSame(0, $calls);
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/invalid-callback.js.
     */
    public function testInvalidCallback(): void
    {
        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line
        (new Map())->getOrInsertComputed('a', 'not-a-callback');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/length.js
    // Reason: function length / descriptor tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/name.js
    // Reason: function name / descriptor tests are not portable to PHP
}
