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
    // SKIPPED: test/built-ins/Map/prototype/has/does-not-have-mapdata-internal-slot-set.js
    // Reason: JS re-targets Map.prototype.has onto a Set via .call(); PHP methods are always invoked on a Map instance

    // SKIPPED: test/built-ins/Map/prototype/has/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: JS re-targets Map.prototype.has onto a WeakMap via .call(); PHP methods are always invoked on a Map instance

    // SKIPPED: test/built-ins/Map/prototype/has/does-not-have-mapdata-internal-slot.js
    // Reason: JS re-targets Map.prototype.has onto plain objects/arrays via .call(); PHP methods are always invoked on a Map instance

    /**
     * test/built-ins/Map/prototype/has/has.js.
     */
    public function testHas(): void
    {
        // Adaptation: the JS property descriptor checks (writable/enumerable/configurable)
        // have no PHP equivalent; only "typeof Map.prototype.has is function" is portable.
        self::assertTrue(method_exists(Map::class, 'has'), 'Map::has() must exist');
        self::assertIsCallable([new Map(), 'has'], 'Map::has() must be callable');
    }

    // SKIPPED: test/built-ins/Map/prototype/has/length.js
    // Reason: asserts the Map.prototype.has.length arity property descriptor; PHP functions have no length property

    // SKIPPED: test/built-ins/Map/prototype/has/name.js
    // Reason: asserts the Map.prototype.has.name property descriptor; PHP methods have no name property descriptor

    /**
     * test/built-ins/Map/prototype/has/normalizes-zero-key.js.
     */
    public function testNormalizesZeroKey(): void
    {
        $map = new Map();

        self::assertFalse($map->has(-0.0), '$map->has(-0.0) returns false on an empty map');
        self::assertFalse($map->has(0.0), '$map->has(0.0) returns false on an empty map');

        $map->set(-0.0, 42);
        self::assertTrue($map->has(-0.0), '$map->has(-0.0) returns true after $map->set(-0.0, 42)');
        self::assertTrue($map->has(0.0), '$map->has(0.0) returns true after $map->set(-0.0, 42)');
        self::assertTrue($map->has(0), '$map->has(0) returns true after $map->set(-0.0, 42) (int 0 and float -0.0 are the same key)');

        $map->clear();

        $map->set(0.0, 42);
        self::assertTrue($map->has(-0.0), '$map->has(-0.0) returns true after $map->set(0.0, 42)');
        self::assertTrue($map->has(0.0), '$map->has(0.0) returns true after $map->set(0.0, 42)');
        self::assertTrue($map->has(0), '$map->has(0) returns true after $map->set(0.0, 42) (int 0 and float 0.0 are the same key)');
    }

    // SKIPPED: test/built-ins/Map/prototype/has/not-a-constructor.js
    // Reason: asserts `new m.has()` throws a TypeError; PHP methods have no [[Construct]] and cannot be new-ed

    /**
     * test/built-ins/Map/prototype/has/return-false-different-key-types.js.
     */
    public function testReturnFalseDifferentKeyTypes(): void
    {
        // Adaptation: the JS key-type matrix is mapped to PHP types. Symbol and BigInt keys
        // have no PHP equivalent and are omitted; JS undefined is PHP null, so the separate
        // JS null and undefined keys collapse into a single null key.
        $map = new Map();

        self::assertFalse($map->has('str'), "\$map->has('str') returns false");
        self::assertFalse($map->has(1), '$map->has(1) returns false');
        self::assertFalse($map->has(1.5), '$map->has(1.5) returns false');
        self::assertFalse($map->has(NAN), '$map->has(NAN) returns false');
        self::assertFalse($map->has(true), '$map->has(true) returns false');
        self::assertFalse($map->has(false), '$map->has(false) returns false');
        self::assertFalse($map->has(new \stdClass()), '$map->has(new \stdClass()) returns false');
        self::assertFalse($map->has([]), '$map->has([]) returns false');
        self::assertFalse($map->has(null), '$map->has(null) returns false');
    }

    /**
     * test/built-ins/Map/prototype/has/return-true-different-key-types.js.
     */
    public function testReturnTrueDifferentKeyTypes(): void
    {
        // Adaptation: the JS key-type matrix is mapped to PHP types. Symbol and BigInt keys
        // have no PHP equivalent and are omitted; JS undefined is PHP null, so the separate
        // JS null and undefined keys collapse into a single null key. Objects compare by
        // identity, int 1 and float 1.0 are the same key (JS numbers are doubles), and
        // string '1' is not equal to int 1.
        $map = new Map();

        $obj = new \stdClass();
        $arr = [];

        $map->set('str', null);
        $map->set(1, null);
        $map->set(1.5, null);
        $map->set(NAN, null);
        $map->set(true, null);
        $map->set(false, null);
        $map->set($obj, null);
        $map->set($arr, null);
        $map->set(null, null);

        self::assertTrue($map->has('str'), "\$map->has('str') returns true");
        self::assertTrue($map->has(1), '$map->has(1) returns true');
        self::assertTrue($map->has(1.0), '$map->has(1.0) returns true (int 1 and float 1.0 are the same key)');
        self::assertFalse($map->has('1'), "\$map->has('1') returns false (string '1' is not int 1)");
        self::assertTrue($map->has(1.5), '$map->has(1.5) returns true');
        self::assertTrue($map->has(NAN), '$map->has(NAN) returns true (NaN matches NaN)');
        self::assertTrue($map->has(true), '$map->has(true) returns true');
        self::assertTrue($map->has(false), '$map->has(false) returns true');
        self::assertTrue($map->has($obj), '$map->has($obj) returns true');
        self::assertFalse($map->has(new \stdClass()), '$map->has(new \stdClass()) returns false (objects compare by identity)');
        self::assertTrue($map->has($arr), '$map->has($arr) returns true');
        self::assertTrue($map->has(null), '$map->has(null) returns true');
    }

    // SKIPPED: test/built-ins/Map/prototype/has/this-not-object-throw.js
    // Reason: JS calls Map.prototype.has with non-object `this` (false, 1, '', undefined, null, Symbol); PHP methods are always invoked on a Map instance
}
