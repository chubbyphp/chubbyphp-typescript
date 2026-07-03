<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.keys tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeKeysTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/keys/does-not-have-mapdata-internal-slot-set.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/keys/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]
    // SKIPPED: test/built-ins/Map/prototype/keys/does-not-have-mapdata-internal-slot.js
    // Reason: PHP methods are always bound to a Map instance; no generic this without [[MapData]]

    /**
     * test/built-ins/Map/prototype/keys/keys.js.
     */
    public function testKeys(): void
    {
        // Adapted: JS asserts `typeof Map.prototype.keys` is "function" plus its property
        // descriptor; PHP asserts the method returns a \Generator and iterates the keys.
        $map = new Map();
        $map->set('a', 1);

        $iterator = $map->keys();

        self::assertInstanceOf(\Generator::class, $iterator);
        self::assertSame(['a'], iterator_to_array($iterator));
    }

    // SKIPPED: test/built-ins/Map/prototype/keys/length.js
    // Reason: function length property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/keys/name.js
    // Reason: function name property descriptor; PHP methods have no such descriptor
    // SKIPPED: test/built-ins/Map/prototype/keys/not-a-constructor.js
    // Reason: [[Construct]] check; PHP methods are not constructible values

    /**
     * test/built-ins/Map/prototype/keys/returns-iterator-empty.js.
     */
    public function testReturnsIteratorEmpty(): void
    {
        self::assertSame([], iterator_to_array((new Map())->keys()));
    }

    /**
     * test/built-ins/Map/prototype/keys/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        $obj = new \stdClass();
        $map = new Map();
        $map->set('foo', 1);
        $map->set($obj, 2);
        $map->set($map, 3);

        $iterator = $map->keys();

        self::assertSame(['foo', $obj, $map], iterator_to_array($iterator));

        // Exhausted iterator (repeated request): JS yields { value: undefined, done: true }.
        $iterator->next();

        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());
    }

    // SKIPPED: test/built-ins/Map/prototype/keys/this-not-object-throw.js
    // Reason: PHP methods are always bound to a Map instance; this can never be a non-object
}
