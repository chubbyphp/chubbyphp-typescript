<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.clear tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeClearTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/clear/clear-map.js.
     */
    public function testClearMap(): void
    {
        $m1 = new Map([
            ['foo', 'bar'],
            [1, 1],
        ]);
        $m2 = new Map();
        $m3 = new Map();
        $m2->set('foo', 'bar');
        $m2->set(1, 1);
        // Adapted: PHP has no Symbol; an object key stands in for Symbol('a').
        $m2->set(new \stdClass(), new \stdClass());

        $m1->clear();
        $m2->clear();
        $m3->clear();

        self::assertSame(0, $m1->size, 'm1.size is 0 after clear()');
        self::assertSame(0, $m2->size, 'm2.size is 0 after clear()');
        self::assertSame(0, $m3->size, 'm3.size is 0 after clear()');
    }

    /**
     * test/built-ins/Map/prototype/clear/clear.js.
     */
    public function testClear(): void
    {
        // Adapted: property descriptors are not portable; assert the method exists and works.
        self::assertTrue(method_exists(Map::class, 'clear'), 'Map::clear() is a method');

        $map = new Map([['a', 1]]);
        $map->clear();

        self::assertSame(0, $map->size, 'size is 0 after clear()');
    }

    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-not-map-object.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-not-object.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-set-object-throws.js
    // Reason: methods are invoked on Map instances; no Set port exists

    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-weakmap-object-throws.js
    // Reason: methods are invoked on Map instances; no WeakMap port exists

    // SKIPPED: test/built-ins/Map/prototype/clear/length.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/clear/map-data-list-is-preserved.js.
     */
    public function testMapDataListIsPreserved(): void
    {
        $map = new Map([
            [1, 1],
            [2, 2],
            [3, 3],
        ]);

        $iterator = $map->entries();

        self::assertSame([1, 1], $iterator->current(), 'first entry is [1, 1]');

        $map->clear();

        $iterator->next();

        self::assertNull($iterator->current(), 'current() is null (JS undefined) after clear()');
        self::assertFalse($iterator->valid(), 'iterator is done after clear()');

        // Adapted extension: the entry list is preserved in place, so a suspended
        // iterator keeps its position and visits entries added after the clear().
        $map = new Map([
            [1, 1],
            [2, 2],
            [3, 3],
        ]);

        $visited = [];

        foreach ($map as [$key, $value]) {
            $visited[] = [$key, $value];

            if (1 === $key) {
                $map->clear();
                $map->set(4, 4);
            }
        }

        self::assertSame(
            [[1, 1], [4, 4]],
            $visited,
            'live iterator skips cleared entries but sees the entry added after clear()'
        );
    }

    // SKIPPED: test/built-ins/Map/prototype/clear/name.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/clear/not-a-constructor.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/clear/returns-undefined.js.
     */
    public function testReturnsUndefined(): void
    {
        // Adapted: PHP clear() is declared `: void`, the closest analogue of always
        // returning undefined; assert the declared return type and that clear() is
        // usable as a plain statement on populated and empty maps.
        $returnType = (new \ReflectionMethod(Map::class, 'clear'))->getReturnType();

        self::assertInstanceOf(\ReflectionNamedType::class, $returnType);
        self::assertSame('void', $returnType->getName(), 'clear() is declared void');

        $map = new Map([
            ['foo', 'bar'],
            [1, 1],
        ]);

        $map->clear();

        self::assertSame(0, $map->size, 'clears a populated map');

        $map->clear();

        self::assertSame(0, $map->size, 'clear() on an empty map keeps size 0');
    }
}
