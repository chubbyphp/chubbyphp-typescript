<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype[Symbol.iterator] tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeIteratorTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/Symbol.iterator.js.
     */
    public function testSymbolIterator(): void
    {
        // Adapted: JS asserts Map.prototype[Symbol.iterator] === Map.prototype.entries plus its
        // property descriptor; PHP equivalent: getIterator() / foreach ($map as $entry) yield
        // the same entry sequence as entries().
        $map = new Map();
        $map->set('a', 1);
        $map->set('b', 2);

        self::assertSame(
            iterator_to_array($map->entries()),
            iterator_to_array($map->getIterator()),
        );

        $entries = [];
        foreach ($map as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([['a', 1], ['b', 2]], $entries);
    }

    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator/not-a-constructor.js
    // Reason: [[Construct]] check; PHP methods are not constructible values
}
