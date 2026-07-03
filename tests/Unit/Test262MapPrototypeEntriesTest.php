<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.entries tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeEntriesTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/entries/does-not-have-mapdata-internal-slot-set.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/entries/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/entries/does-not-have-mapdata-internal-slot.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]

    /**
     * test/built-ins/Map/prototype/entries/entries.js.
     */
    public function testEntries(): void
    {
        // Adapted: JS asserts `typeof Map.prototype.entries` is "function" plus its property
        // descriptor; PHP asserts the method returns a \Generator and iterates the entries.
        $map = new Map();
        $map->set('a', 1);

        $iterator = $map->entries();

        self::assertInstanceOf(\Generator::class, $iterator);
        self::assertSame([['a', 1]], iterator_to_array($iterator));
    }

    // SKIPPED: test/built-ins/Map/prototype/entries/length.js
    // Reason: function length property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/entries/name.js
    // Reason: function name property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/entries/not-a-constructor.js
    // Reason: [[Construct]] check; PHP methods are not constructible values

    /**
     * test/built-ins/Map/prototype/entries/returns-iterator-empty.js.
     */
    public function testReturnsIteratorEmpty(): void
    {
        self::assertSame([], iterator_to_array((new Map())->entries()));
    }

    /**
     * test/built-ins/Map/prototype/entries/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        $map = new Map();
        $map->set('a', 1);
        $map->set('b', 2);
        $map->set('c', 3);

        $iterator = $map->entries();

        self::assertSame([['a', 1], ['b', 2], ['c', 3]], iterator_to_array($iterator));

        // Exhausted iterator (repeated request): JS yields { value: undefined, done: true }.
        $iterator->next();

        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());
    }

    // SKIPPED: test/built-ins/Map/prototype/entries/this-not-object-throw.js
    // Reason: PHP methods are always bound to a Map instance; this can never be a non-object
}
