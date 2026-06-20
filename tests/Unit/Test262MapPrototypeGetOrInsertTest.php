<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.getOrInsert tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeGetOrInsertTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/getOrInsert/returns-existing-value.js.
     */
    public function testReturnsExistingValue(): void
    {
        $map = new Map([['a', 1]]);

        self::assertSame(1, $map->getOrInsert('a', 2));
        self::assertSame(1, $map->get('a'));
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/inserts-default-value.js.
     */
    public function testInsertsDefaultValue(): void
    {
        $map = new Map();

        self::assertSame('default', $map->getOrInsert('a', 'default'));
        self::assertSame('default', $map->get('a'));
        self::assertSame(1, $map->size);
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/null-value-is-not-missing.js.
     */
    public function testNullValueIsNotMissing(): void
    {
        $map = new Map([['a', null]]);

        self::assertNull($map->getOrInsert('a', 'default'));
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/length.js
    // Reason: function length / descriptor tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/name.js
    // Reason: function name / descriptor tests are not portable to PHP
}
