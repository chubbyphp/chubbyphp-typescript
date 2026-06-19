<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.has tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeHasTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/has/does-not-have-mapdata-internal-slot*.js
    // Reason: methods are invoked on Map instances

    /**
     * test/built-ins/Map/prototype/has/has.js.
     */
    public function testHas(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        self::assertTrue($map->has('a'));
        self::assertFalse($map->has('b'));
    }

    // SKIPPED: test/built-ins/Map/prototype/has/length.js
    // SKIPPED: test/built-ins/Map/prototype/has/name.js
    // SKIPPED: test/built-ins/Map/prototype/has/not-a-constructor.js

    /**
     * test/built-ins/Map/prototype/has/normalizes-zero-key.js.
     */
    public function testNormalizesZeroKey(): void
    {
        $map = new Map();

        self::assertFalse($map->has(-0.0));
        self::assertFalse($map->has(0.0));

        $map->set(-0.0, 42);
        self::assertTrue($map->has(-0.0));
        self::assertTrue($map->has(0.0));

        $map->clear();

        $map->set(0.0, 42);
        self::assertTrue($map->has(-0.0));
        self::assertTrue($map->has(0.0));
    }

    /**
     * test/built-ins/Map/prototype/has/return-false-different-key-types.js.
     */
    public function testReturnFalseDifferentKeyTypes(): void
    {
        $map = new Map();

        self::assertFalse($map->has('str'));
        self::assertFalse($map->has(1));
        self::assertFalse($map->has(NAN));
        self::assertFalse($map->has(true));
        self::assertFalse($map->has(false));
        self::assertFalse($map->has(new \stdClass()));
        self::assertFalse($map->has([]));
        // Symbol() has no PHP equivalent and is omitted.
        self::assertFalse($map->has(null));
    }

    /**
     * test/built-ins/Map/prototype/has/return-true-different-key-types.js.
     */
    public function testReturnTrueDifferentKeyTypes(): void
    {
        $map = new Map();

        $obj = new \stdClass();
        $arr = [];

        $map->set('str', null);
        $map->set(1, null);
        $map->set(NAN, null);
        $map->set(true, null);
        $map->set(false, null);
        $map->set($obj, null);
        $map->set($arr, null);
        // Symbol() has no PHP equivalent and is omitted.
        $map->set(null, null);

        self::assertTrue($map->has('str'));
        self::assertTrue($map->has(1));
        self::assertTrue($map->has(NAN));
        self::assertTrue($map->has(true));
        self::assertTrue($map->has(false));
        self::assertTrue($map->has($obj));
        self::assertTrue($map->has($arr));
        self::assertTrue($map->has(null));
    }

    /**
     * test/built-ins/Map/prototype/has/returns-false.js.
     */
    public function testReturnsFalse(): void
    {
        $map = new Map();

        self::assertFalse($map->has('a'));
    }

    /**
     * test/built-ins/Map/prototype/has/returns-true.js.
     */
    public function testReturnsTrue(): void
    {
        $map = new Map([
            ['a', 1],
        ]);

        self::assertTrue($map->has('a'));
    }

    /**
     * test/built-ins/Map/prototype/has/same-value-zero.js.
     */
    public function testSameValueZero(): void
    {
        $map = new Map();
        $map->set(NAN, 'NaN');
        $map->set(-0.0, 'zero');

        self::assertTrue($map->has(NAN));
        self::assertTrue($map->has(0));
    }

    // SKIPPED: test/built-ins/Map/prototype/has/this-not-object-throw.js
}
