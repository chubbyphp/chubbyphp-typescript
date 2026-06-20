<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype[@@iterator] tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeIteratorTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator/descriptor.js
    // Reason: PHP has no Symbol.iterator; function identity / descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator/length.js
    // Reason: PHP has no Symbol.iterator; function identity / descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator/name.js
    // Reason: PHP has no Symbol.iterator; function identity / descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator/not-a-constructor.js
    // Reason: PHP has no Symbol.iterator; function identity / descriptor tests are not portable
    // SKIPPED: test/built-ins/Map/prototype/Symbol.iterator.js
    // Reason: PHP has no Symbol.iterator; function identity / descriptor tests are not portable

    /**
     * test/built-ins/Map/prototype/Symbol.iterator.js.
     */
    public function testSymbolIterator(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        $entries = [];
        foreach ($map as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([['a', 1], ['b', 2]], $entries);
    }

    /**
     * test/built-ins/Map/prototype/Symbol.iterator.js.
     */
    public function testDefaultIteratorYieldsSameAsEntries(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertSame(
            iterator_to_array($map->entries()),
            iterator_to_array($map),
        );
    }
}
