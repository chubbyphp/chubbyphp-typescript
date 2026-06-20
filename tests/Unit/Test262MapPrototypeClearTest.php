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
        $map = new Map([
            [1, 1],
            [2, 2],
        ]);

        $map->clear();

        self::assertSame(0, $map->size);
        self::assertFalse($map->has(1));
        self::assertFalse($map->has(2));
    }

    /**
     * test/built-ins/Map/prototype/clear/clear.js.
     */
    public function testClear(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertNull($map->clear());
        self::assertSame(0, $map->size);
    }

    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-not-map-object.js
    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-not-object.js
    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-set-object-throws.js
    // SKIPPED: test/built-ins/Map/prototype/clear/context-is-weakmap-object-throws.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/clear/length.js
    // SKIPPED: test/built-ins/Map/prototype/clear/name.js
    // SKIPPED: test/built-ins/Map/prototype/clear/not-a-constructor.js
    // Reason: length/name/not-a-constructor descriptor tests are not portable

    /**
     * test/built-ins/Map/prototype/clear/map-data-list-is-preserved.js.
     */
    public function testMapDataListIsPreserved(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
            ['c', 3],
        ]);

        $map->clear();
        $map->set('d', 4);

        self::assertSame(1, $map->size);
        self::assertSame(4, $map->get('d'));
    }

    /**
     * test/built-ins/Map/prototype/clear/returns-undefined.js.
     */
    public function testReturnsUndefined(): void
    {
        $map = new Map();

        self::assertNull($map->clear());
    }
}
