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
    // SKIPPED: test/built-ins/Map/prototype/entries/does-not-have-mapdata-internal-slot-weakmap.js
    // SKIPPED: test/built-ins/Map/prototype/entries/does-not-have-mapdata-internal-slot.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/entries/entries.js
    // Reason: prop-desc descriptor tests are not portable

    // SKIPPED: test/built-ins/Map/prototype/entries/length.js
    // SKIPPED: test/built-ins/Map/prototype/entries/name.js
    // SKIPPED: test/built-ins/Map/prototype/entries/not-a-constructor.js
    // Reason: length/name/not-a-constructor descriptor tests are not portable

    /**
     * test/built-ins/Map/prototype/entries/returns-iterator-empty.js.
     */
    public function testReturnsIteratorEmpty(): void
    {
        $iterator = (new Map())->entries();

        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());
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

        self::assertSame(['a', 1], $iterator->current());
        self::assertCount(2, $iterator->current());
        self::assertTrue($iterator->valid());

        $iterator->next();

        self::assertSame(['b', 2], $iterator->current());
        self::assertCount(2, $iterator->current());
        self::assertTrue($iterator->valid());

        $iterator->next();

        self::assertSame(['c', 3], $iterator->current());
        self::assertCount(2, $iterator->current());
        self::assertTrue($iterator->valid());

        $iterator->next();

        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());

        $iterator->next();

        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());
    }

    // SKIPPED: test/built-ins/Map/prototype/entries/this-not-object-throw.js
    // Reason: methods are invoked on Map instances, not generic this values
}
