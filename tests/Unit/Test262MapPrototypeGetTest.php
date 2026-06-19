<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.get tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeGetTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/get/does-not-have-mapdata-internal-slot*.js
    // Reason: methods are invoked on Map instances

    /**
     * test/built-ins/Map/prototype/get/get.js.
     */
    public function testGet(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertSame(1, $map->get('a'));
        self::assertSame(2, $map->get('b'));
    }

    // SKIPPED: test/built-ins/Map/prototype/get/length.js
    // SKIPPED: test/built-ins/Map/prototype/get/name.js
    // SKIPPED: test/built-ins/Map/prototype/get/not-a-constructor.js

    /**
     * test/built-ins/Map/prototype/get/returns-undefined.js.
     */
    public function testReturnsUndefined(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        self::assertNull($map->get('b'));
    }

    /**
     * test/built-ins/Map/prototype/get/returns-value-different-key-types.js.
     */
    public function testReturnsValueDifferentKeyTypes(): void
    {
        $map = new Map();

        $map->set('bar', 0);
        self::assertSame(0, $map->get('bar'));

        $map->set(1, 42);
        self::assertSame(42, $map->get(1));

        $map->set(NAN, 1);
        self::assertSame(1, $map->get(NAN));

        $item = new \stdClass();
        $map->set($item, 2);
        self::assertSame(2, $map->get($item));

        $item = [];
        $map->set($item, 3);
        self::assertSame(3, $map->get($item));

        // Symbol() has no PHP equivalent and is omitted.

        $map->set(null, 5);
        self::assertSame(5, $map->get(null));
    }

    /**
     * test/built-ins/Map/prototype/get/returns-value-normalized-zero-key.js.
     */
    public function testReturnsValueNormalizedZeroKey(): void
    {
        $map = new Map();
        $map->set(0.0, 42);

        self::assertSame(42, $map->get(-0.0));

        $map = new Map();
        $map->set(-0.0, 43);

        self::assertSame(43, $map->get(0.0));
    }

    /**
     * test/built-ins/Map/prototype/get/same-value-zero.js.
     */
    public function testSameValueZero(): void
    {
        $map = new Map();
        $map->set(NAN, 'NaN');
        $map->set(-0.0, 'zero');

        self::assertSame('NaN', $map->get(NAN));
        self::assertSame('zero', $map->get(0));
    }

    // SKIPPED: test/built-ins/Map/prototype/get/this-not-object-throw.js
}
