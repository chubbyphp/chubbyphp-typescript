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
    // Reason: methods are invoked on Map instances; no Set port exists

    // SKIPPED: test/built-ins/Map/prototype/delete/context-is-weakmap-object-throws.js
    // Reason: methods are invoked on Map instances; no WeakMap port exists

    /**
     * test/built-ins/Map/prototype/delete/delete.js.
     */
    public function testDelete(): void
    {
        // Adapted: property descriptors are not portable; assert the method exists and works.
        self::assertTrue(method_exists(Map::class, 'delete'), 'Map::delete() is a method');

        $map = new Map([['a', 1]]);

        self::assertTrue($map->delete('a'), 'delete("a") returns true');
        self::assertSame(0, $map->size, 'size is 0 after deleting the only entry');
    }

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

        self::assertSame(['a', 1], $iterator->current(), 'first entry is ["a", 1]');

        $map->delete('b');

        $iterator->next();

        self::assertSame(['c', 3], $iterator->current(), 'deleted entry is skipped, next entry is ["c", 3]');

        $iterator->next();

        self::assertNull($iterator->current(), 'current() is null (JS undefined) once done');
        self::assertFalse($iterator->valid(), 'iterator is done after the last entry');
    }

    // SKIPPED: test/built-ins/Map/prototype/delete/length.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/delete/name.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/delete/not-a-constructor.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/delete/returns-false.js.
     */
    public function testReturnsFalse(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertFalse($map->delete('not-in-the-map'), 'delete("not-in-the-map") returns false');

        $map->delete('a');

        self::assertFalse($map->delete('a'), 'deleting an already deleted entry returns false');
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

        self::assertTrue($map->delete('a'), 'delete("a") returns true');
        self::assertSame(1, $map->size, 'size is 1 after deleting "a"');
    }
}
