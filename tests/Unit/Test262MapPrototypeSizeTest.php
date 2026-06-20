<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.size tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeSizeTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/size/constructor.js
    // Reason: size is a magic property, not an accessor descriptor
    // SKIPPED: test/built-ins/Map/prototype/size/length.js
    // Reason: size is a magic property, not an accessor descriptor
    // SKIPPED: test/built-ins/Map/prototype/size/name.js
    // Reason: size is a magic property, not an accessor descriptor
    // SKIPPED: test/built-ins/Map/prototype/size/prop-desc.js
    // Reason: size is a magic property, not an accessor descriptor
    // SKIPPED: test/built-ins/Map/prototype/size/size.js
    // Reason: size is a magic property, not an accessor descriptor

    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot-set.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot.js
    // Reason: methods are invoked on Map instances, not generic this values

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-before-after-set-clear.js.
     */
    public function testReturnsCountOfPresentValuesBeforeAfterSetClear(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);

        $map->set(1, 1);
        $map->set(2, 2);

        self::assertSame(2, $map->size);

        $map->clear();

        self::assertSame(0, $map->size);
    }

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-before-after-set-delete.js.
     */
    public function testReturnsCountOfPresentValuesBeforeAfterSetDelete(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);

        $map->set(1, 1);

        self::assertSame(1, $map->size);

        $map->delete(1);

        self::assertSame(0, $map->size);
    }

    // SKIPPED: test/built-ins/Map/prototype/size/returns-count-of-present-values-by-insertion.js
    // Reason: requires Symbol keys

    // SKIPPED: test/built-ins/Map/prototype/size/returns-count-of-present-values-by-iterable.js
    // Reason: requires Symbol keys

    /**
     * test/built-ins/Map/prototype/size/size.js.
     */
    public function testSize(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);

        $map->set('a', 1);
        self::assertSame(1, $map->size);

        $map->set('b', 2);
        self::assertSame(2, $map->size);

        $map->delete('a');
        self::assertSame(1, $map->size);

        $map->clear();
        self::assertSame(0, $map->size);
    }

    // SKIPPED: test/built-ins/Map/prototype/size/this-not-object-throw.js
    // Reason: PHP methods are invoked on Map instances
}
