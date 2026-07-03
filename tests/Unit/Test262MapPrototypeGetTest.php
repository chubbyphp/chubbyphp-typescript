<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.get tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeGetTest extends TestCase
{
    // SKIPPED: test/built-ins/Map/prototype/get/does-not-have-mapdata-internal-slot-set.js
    // Reason: JS re-targets Map.prototype.get onto a Set via .call(); PHP methods are always invoked on a Map instance

    // SKIPPED: test/built-ins/Map/prototype/get/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: JS re-targets Map.prototype.get onto a WeakMap via .call(); PHP methods are always invoked on a Map instance

    // SKIPPED: test/built-ins/Map/prototype/get/does-not-have-mapdata-internal-slot.js
    // Reason: JS re-targets Map.prototype.get onto plain objects/arrays via .call(); PHP methods are always invoked on a Map instance

    /**
     * test/built-ins/Map/prototype/get/get.js.
     */
    public function testGet(): void
    {
        // Adaptation: the JS property descriptor checks (writable/enumerable/configurable)
        // have no PHP equivalent; only "typeof Map.prototype.get is function" is portable.
        self::assertTrue(method_exists(Map::class, 'get'), 'Map::get() must exist');
        self::assertIsCallable([new Map(), 'get'], 'Map::get() must be callable');
    }

    // SKIPPED: test/built-ins/Map/prototype/get/length.js
    // Reason: asserts the Map.prototype.get.length arity property descriptor; PHP functions have no length property

    // SKIPPED: test/built-ins/Map/prototype/get/name.js
    // Reason: asserts the Map.prototype.get.name property descriptor; PHP methods have no name property descriptor

    // SKIPPED: test/built-ins/Map/prototype/get/not-a-constructor.js
    // Reason: asserts `new m.get()` throws a TypeError; PHP methods have no [[Construct]] and cannot be new-ed

    /**
     * test/built-ins/Map/prototype/get/returns-undefined.js.
     */
    public function testReturnsUndefined(): void
    {
        $map = new Map();

        self::assertNull($map->get('item'), 'returns null if key is not on the map');

        $map->set('item', 1);
        $map->set('another_item', 2);
        $map->delete('item');

        self::assertNull($map->get('item'), 'returns null if key was deleted');

        $map->set('item', 1);
        $map->clear();

        self::assertNull($map->get('item'), 'returns null after map is cleared');

        // Adaptation: PHP null plays JS undefined; a key explicitly mapped to null also
        // returns null from get(), but has() still distinguishes it from a missing key.
        $map->set('null_item', null);

        self::assertNull($map->get('null_item'), 'returns null for a key explicitly mapped to null');
        self::assertTrue($map->has('null_item'), 'has() returns true for a key explicitly mapped to null');
        self::assertFalse($map->has('item'), 'has() returns false for the missing key');
    }

    /**
     * test/built-ins/Map/prototype/get/returns-value-different-key-types.js.
     */
    public function testReturnsValueDifferentKeyTypes(): void
    {
        // Adaptation: the JS key-type matrix is mapped to PHP types. Symbol and BigInt keys
        // have no PHP equivalent and are omitted; JS undefined is PHP null, so the separate
        // JS null and undefined keys collapse into a single null key. Objects compare by
        // identity, int 1 and float 1.0 are the same key (JS numbers are doubles), and
        // string '1' is not equal to int 1.
        $map = new Map();

        $map->set('bar', 0);
        self::assertSame(0, $map->get('bar'), "\$map->get('bar') must return 0");

        $map->set(1, 42);
        self::assertSame(42, $map->get(1), '$map->get(1) must return 42');
        self::assertSame(42, $map->get(1.0), '$map->get(1.0) must return 42 (int 1 and float 1.0 are the same key)');
        self::assertNull($map->get('1'), "\$map->get('1') returns null (string '1' is not int 1)");

        $map->set(1.5, 43);
        self::assertSame(43, $map->get(1.5), '$map->get(1.5) must return 43');

        $map->set(NAN, 1);
        self::assertSame(1, $map->get(NAN), '$map->get(NAN) must return 1 (NaN matches NaN)');

        $map->set(true, 7);
        self::assertSame(7, $map->get(true), '$map->get(true) must return 7');

        $map->set(false, 8);
        self::assertSame(8, $map->get(false), '$map->get(false) must return 8');

        $item = new \stdClass();
        $map->set($item, 2);
        self::assertSame(2, $map->get($item), '$map->get($item) must return 2');
        self::assertNull($map->get(new \stdClass()), '$map->get(new \stdClass()) returns null (objects compare by identity)');

        $item = [];
        $map->set($item, 3);
        self::assertSame(3, $map->get($item), '$map->get([]) must return 3');

        $item = null;
        $map->set($item, 5);
        self::assertSame(5, $map->get($item), '$map->get(null) must return 5');
    }

    /**
     * test/built-ins/Map/prototype/get/returns-value-normalized-zero-key.js.
     */
    public function testReturnsValueNormalizedZeroKey(): void
    {
        $map = new Map();

        $map->set(0.0, 42);
        self::assertSame(42, $map->get(-0.0), '$map->get(-0.0) must return 42');
        self::assertSame(42, $map->get(0.0), '$map->get(0.0) must return 42');
        self::assertSame(42, $map->get(0), '$map->get(0) must return 42 (int 0 and float 0.0 are the same key)');

        $map = new Map();

        $map->set(-0.0, 43);
        self::assertSame(43, $map->get(0.0), '$map->get(0.0) must return 43');
        self::assertSame(43, $map->get(-0.0), '$map->get(-0.0) must return 43');
        self::assertSame(43, $map->get(0), '$map->get(0) must return 43 (int 0 and float -0.0 are the same key)');
    }

    // SKIPPED: test/built-ins/Map/prototype/get/this-not-object-throw.js
    // Reason: JS calls Map.prototype.get with non-object `this` (false, 1, '', undefined, null, Symbol); PHP methods are always invoked on a Map instance
}
