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
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/keys/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: methods are invoked on Map instances, not generic this values
    // SKIPPED: test/built-ins/Map/prototype/keys/does-not-have-mapdata-internal-slot.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/keys/keys.js
    // Reason: property descriptor / function identity tests are not portable to PHP
    // SKIPPED: test/built-ins/Map/prototype/keys/length.js
    // Reason: property descriptor / function identity tests are not portable to PHP
    // SKIPPED: test/built-ins/Map/prototype/keys/name.js
    // Reason: property descriptor / function identity tests are not portable to PHP
    // SKIPPED: test/built-ins/Map/prototype/keys/not-a-constructor.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/keys/returns-iterator-empty.js.
     */
    public function testReturnsIteratorEmpty(): void
    {
        $map = new Map();

        self::assertFalse($map->keys()->valid());
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

        self::assertTrue($iterator->valid());
        self::assertSame('foo', $iterator->current());

        $iterator->next();
        self::assertTrue($iterator->valid());
        self::assertSame($obj, $iterator->current());

        $iterator->next();
        self::assertTrue($iterator->valid());
        self::assertSame($map, $iterator->current());

        $iterator->next();
        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());

        $iterator->next();
        self::assertFalse($iterator->valid());
        self::assertNull($iterator->current());
    }

    // SKIPPED: test/built-ins/Map/prototype/keys/this-not-object-throw.js
    // Reason: PHP methods are invoked on Map instances
}
