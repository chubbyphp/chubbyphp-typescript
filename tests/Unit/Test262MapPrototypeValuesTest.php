<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.values tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeValuesTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/values/does-not-have-mapdata-internal-slot-set.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/values/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/values/does-not-have-mapdata-internal-slot.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]

    // SKIPPED: test/built-ins/Map/prototype/values/length.js
    // Reason: function length property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/values/name.js
    // Reason: function name property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/values/not-a-constructor.js
    // Reason: [[Construct]] check; PHP methods are not constructible values

    /**
     * test/built-ins/Map/prototype/values/returns-iterator-empty.js.
     */
    public function testReturnsIteratorEmpty(): void
    {
        self::assertSame([], iterator_to_array((new Map())->values()));
    }

    /**
     * test/built-ins/Map/prototype/values/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        $obj = new \stdClass();
        $map = new Map();
        $map->set(1, 'foo');
        $map->set(2, $obj);
        $map->set(3, $map);

        $iterator = $map->values();

        self::assertSame(['foo', $obj, $map], iterator_to_array($iterator));

        // Exhausted iterator (repeated request): JS yields { value: undefined, done: true }.
        $iterator->next();

        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());
    }

    // SKIPPED: test/built-ins/Map/prototype/values/this-not-object-throw.js
    // Reason: PHP methods are always bound to a Map instance; this can never be a non-object

    /**
     * test/built-ins/Map/prototype/values/values.js.
     */
    public function testValues(): void
    {
        // Adapted: JS asserts `typeof Map.prototype.values` is "function" plus its property
        // descriptor; PHP asserts the method returns a \Generator and iterates the values.
        $map = new Map();
        $map->set('a', 1);

        $iterator = $map->values();

        self::assertInstanceOf(\Generator::class, $iterator);
        self::assertSame([1], iterator_to_array($iterator));
    }
}
