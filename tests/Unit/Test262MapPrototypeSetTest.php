<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.set tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeSetTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot-set.js
    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot-weakmap.js
    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/set/length.js
    // SKIPPED: test/built-ins/Map/prototype/set/name.js
    // SKIPPED: test/built-ins/Map/prototype/set/not-a-constructor.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/set/append-new-values-normalizes-zero-key.js.
     */
    public function testAppendNewValuesNormalizesZeroKey(): void
    {
        $map = new Map();
        $map->set(-0.0, 42);

        self::assertSame(42, $map->get(0));

        $map = new Map();
        $map->set(+0.0, 43);

        self::assertSame(43, $map->get(0));
    }

    /**
     * test/built-ins/Map/prototype/set/append-new-values-return-map.js.
     */
    public function testAppendNewValuesReturnMap(): void
    {
        $map = new Map();

        self::assertSame($map, $map->set(1, 1));
        self::assertSame($map, $map->set(1, 1)->set(2, 2)->set(3, 3));
    }

    // SKIPPED: test/built-ins/Map/prototype/set/append-new-values.js
    // Reason: requires Symbol keys

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value-normalizes-zero-key.js.
     */
    public function testReplacesAValueNormalizesZeroKey(): void
    {
        $map = new Map([[+0.0, 1]]);

        $map->set(-0.0, 42);
        self::assertSame(42, $map->get(+0.0));

        $map = new Map([[-0.0, 1]]);

        $map->set(+0.0, 42);
        self::assertSame(42, $map->get(-0.0));
    }

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value-returns-map.js.
     */
    public function testReplacesAValueReturnsMap(): void
    {
        $map = new Map([['item', 0]]);

        self::assertSame($map, $map->set('item', 42));
    }

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value.js.
     */
    public function testReplacesAValue(): void
    {
        $map = new Map([['item', 1]]);

        $map->set('item', 42);

        self::assertSame(42, $map->get('item'));
        self::assertSame(1, $map->size);
    }

    /**
     * test/built-ins/Map/prototype/set/returns-this.js.
     */
    public function testReturnsThis(): void
    {
        $map = new Map();

        self::assertSame($map, $map->set('a', 1));
    }

    /**
     * test/built-ins/Map/prototype/set/set.js.
     */
    public function testSet(): void
    {
        $map = new Map();
        $map->set('a', 1);

        self::assertSame(1, $map->size);
        self::assertSame(1, $map->get('a'));
    }

    /**
     * test/built-ins/Map/prototype/set/same-value-zero.js.
     */
    public function testSameValueZero(): void
    {
        $map = new Map();
        $map->set(NAN, 'first');
        $map->set(NAN, 'second');
        $map->set(-0.0, 'zero');

        self::assertSame(2, $map->size);
        self::assertSame('second', $map->get(NAN));
        self::assertSame('zero', $map->get(0));
    }

    /**
     * test/built-ins/Map/prototype/set/updates-existing-value.js.
     */
    public function testUpdatesExistingValue(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        $map->set('a', 3);

        self::assertSame(2, $map->size);
        self::assertSame(3, $map->get('a'));
        self::assertSame([['a', 3], ['b', 2]], $map->toArray());
    }

    // SKIPPED: test/built-ins/Map/prototype/set/this-not-object-throw.js
    // Reason: PHP methods are invoked on Map instances
}
