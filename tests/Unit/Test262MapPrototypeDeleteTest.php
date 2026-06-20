<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.delete tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeDeleteTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/delete/context-is-not-map-object.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/delete/context-is-not-object.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/delete/context-is-set-object-throws.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/delete/context-is-weakmap-object-throws.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/delete/delete.js
    // Reason: prop-desc descriptor tests are not portable

    /**
     * test/built-ins/Map/prototype/delete/does-not-break-iterators.js.
     */
    public function testDoesNotBreakIterators(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
            ['c', 3],
        ]);

        $iterator = $map->entries();
        $iterator->next();
        $map->delete('b');
        $iterator->next();

        self::assertSame(['c', 3], $iterator->current());
        self::assertTrue($iterator->valid());

        $iterator->next();

        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());
    }

    // SKIPPED: test/built-ins/Map/prototype/delete/length.js
    // Reason: length/name/not-a-constructor descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/delete/name.js
    // Reason: length/name/not-a-constructor descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/delete/not-a-constructor.js
    // Reason: length/name/not-a-constructor descriptor tests are not portable

    /**
     * test/built-ins/Map/prototype/delete/returns-false.js.
     */
    public function testReturnsFalse(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertFalse($map->delete('not-in-the-map'));

        $map->delete('a');

        self::assertFalse($map->delete('a'));
        self::assertSame(1, $map->size);
    }

    /**
     * test/built-ins/Map/prototype/delete/returns-true-for-deleted-entry.js.
     */
    public function testReturnsTrueForDeletedEntry(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertTrue($map->delete('a'));
        self::assertSame(1, $map->size);
    }
}
