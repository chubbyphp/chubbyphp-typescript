<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
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
     * test/built-ins/Map/prototype/getOrInsert/append-new-values-normalizes-zero-key.js.
     */
    public function testAppendNewValuesNormalizesZeroKey(): void
    {
        $map = new Map();
        $map->getOrInsert(-0.0, 42);

        self::assertSame(42, $map->get(0), '$map->get(0) must return 42 after getOrInsert(-0.0, 42)');

        // assertSame(-0.0, 0.0) is true in PHP, so the string cast proves the stored key is +0, not -0.
        $keys = iterator_to_array($map->keys());
        self::assertCount(1, $keys, 'map contains exactly one key');
        self::assertSame('0', (string) $keys[0], 'the -0.0 key is stored canonicalized as +0 (stringifies to "0", not "-0")');

        $map = new Map();
        $map->getOrInsert(0.0, 43);

        self::assertSame(43, $map->get(0), '$map->get(0) must return 43 after getOrInsert(0.0, 43)');
        self::assertSame(43, $map->get(-0.0), '$map->get(-0.0) must return 43, -0 matches the stored +0 key');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/append-new-values.js.
     *
     * Adapted: PHP has no Symbol; a \stdClass object key stands in for Symbol(2).
     */
    public function testAppendNewValues(): void
    {
        $s = new \stdClass();
        $map = new Map([[4, 4], ['foo3', 3], [$s, 2]]);

        $map->getOrInsert(null, 42);
        $map->getOrInsert(1, 'valid');

        self::assertSame(5, $map->size, '$map->size must be 5');
        self::assertSame('valid', $map->get(1), '$map->get(1) must return "valid"');

        $results = [];

        $map->forEach(static function (mixed $value, mixed $key) use (&$results): void {
            $results[] = ['value' => $value, 'key' => $key];
        });

        $result = array_pop($results);
        self::assertSame('valid', $result['value'], 'last appended entry has value "valid"');
        self::assertSame(1, $result['key'], 'last appended entry has key 1');

        $result = array_pop($results);
        self::assertSame(42, $result['value'], 'second to last appended entry has value 42');
        self::assertNull($result['key'], 'second to last appended entry has key null');

        $result = array_pop($results);
        self::assertSame(2, $result['value'], 'pre-existing last entry has value 2');
        self::assertSame($s, $result['key'], 'pre-existing last entry has the object key');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/append-value-if-key-is-not-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists.
     */
    public function testAppendValueIfKeyIsNotPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        $map->getOrInsert('bar', 0);
        self::assertSame(0, $map->get('bar'), '$map->get("bar") must return 0');

        $map->getOrInsert(1, 42);
        self::assertSame(42, $map->get(1), '$map->get(1) must return 42');

        $map->getOrInsert(NAN, 1);
        self::assertSame(1, $map->get(NAN), '$map->get(NAN) must return 1 (SameValueZero matches NaN)');

        $item = new \stdClass();
        $map->getOrInsert($item, 2);
        self::assertSame(2, $map->get($item), '$map->get($item) must return 2 for the object key');

        $item = new Arr();
        $map->getOrInsert($item, 3);
        self::assertSame(3, $map->get($item), '$map->get($item) must return 3 for the Arr key (JS [])');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        $map->getOrInsert($item, 4);
        self::assertSame(4, $map->get($item), '$map->get($item) must return 4 for the second object key');

        $item = null;
        $map->getOrInsert($item, 5);
        self::assertSame(5, $map->get($item), '$map->get(null) must return 5');

        self::assertSame(7, $map->size, 'all 7 distinct keys were appended');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/does-not-have-mapdata-internal-slot-set.js
    // Reason: rebinds `this` onto a Set via .call(); PHP methods are statically bound to Map instances

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: rebinds `this` onto a WeakMap via .call(); PHP methods are statically bound to Map instances

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/does-not-have-mapdata-internal-slot.js
    // Reason: rebinds `this` onto arrays/plain objects via .call(); PHP methods are statically bound to Map instances

    /**
     * test/built-ins/Map/prototype/getOrInsert/getOrInsert.js.
     *
     * Adapted: the JS property descriptor checks (writable/enumerable/configurable) have no
     * PHP equivalent; only the "is a function" aspect is portable.
     */
    public function testGetOrInsert(): void
    {
        self::assertTrue(method_exists(Map::class, 'getOrInsert'), 'Map::getOrInsert must exist');

        $map = new Map();
        self::assertIsCallable([$map, 'getOrInsert'], '[$map, "getOrInsert"] must be callable');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/length.js
    // Reason: verifies the JS function's `length` own-property descriptor; JS function metadata has no PHP equivalent

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/name.js
    // Reason: verifies the JS function's `name` own-property descriptor; JS function metadata has no PHP equivalent

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/not-a-constructor.js
    // Reason: `new m.getOrInsert()`; PHP methods are not constructible values

    /**
     * test/built-ins/Map/prototype/getOrInsert/returns-value-if-key-is-not-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists.
     */
    public function testReturnsValueIfKeyIsNotPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        self::assertSame(0, $map->getOrInsert('bar', 0), '$map->getOrInsert("bar", 0) must return 0');

        self::assertSame(42, $map->getOrInsert(1, 42), '$map->getOrInsert(1, 42) must return 42');

        self::assertSame(1, $map->getOrInsert(NAN, 1), '$map->getOrInsert(NAN, 1) must return 1');

        $item = new \stdClass();
        self::assertSame(2, $map->getOrInsert($item, 2), '$map->getOrInsert($item, 2) must return 2 for the object key');

        $item = new Arr();
        self::assertSame(3, $map->getOrInsert($item, 3), '$map->getOrInsert($item, 3) must return 3 for the Arr key (JS [])');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        self::assertSame(4, $map->getOrInsert($item, 4), '$map->getOrInsert($item, 4) must return 4 for the second object key');

        $item = null;
        self::assertSame(5, $map->getOrInsert($item, 5), '$map->getOrInsert(null, 5) must return 5');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/returns-value-if-key-is-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists. Additionally asserts that a key explicitly mapped to null (JS undefined)
     * is PRESENT: getOrInsert returns the stored null, not the default.
     */
    public function testReturnsValueIfKeyIsPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        $map->set('bar', 0);
        self::assertSame($map->get('bar'), $map->getOrInsert('bar', 1), 'getOrInsert("bar", 1) must equal get("bar")');
        self::assertSame(0, $map->getOrInsert('bar', 1), 'getOrInsert("bar", 1) must return the stored 0');

        $map->set(1, 42);
        self::assertSame($map->get(1), $map->getOrInsert(1, 43), 'getOrInsert(1, 43) must equal get(1)');
        self::assertSame(42, $map->getOrInsert(1, 43), 'getOrInsert(1, 43) must return the stored 42');

        $map->set(NAN, 1);
        self::assertSame($map->get(NAN), $map->getOrInsert(NAN, 2), 'getOrInsert(NAN, 2) must equal get(NAN)');
        self::assertSame(1, $map->getOrInsert(NAN, 2), 'getOrInsert(NAN, 2) must return the stored 1');

        $item = new \stdClass();
        $map->set($item, 2);
        self::assertSame($map->get($item), $map->getOrInsert($item, 3), 'getOrInsert($item, 3) must equal get($item)');
        self::assertSame(2, $map->getOrInsert($item, 3), 'getOrInsert($item, 3) must return the stored 2');

        $item = new Arr();
        $map->set($item, 3);
        self::assertSame($map->get($item), $map->getOrInsert($item, 4), 'getOrInsert($item, 4) must equal get($item)');
        self::assertSame(3, $map->getOrInsert($item, 4), 'getOrInsert($item, 4) must return the stored 3');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        $map->set($item, 4);
        self::assertSame($map->get($item), $map->getOrInsert($item, 5), 'getOrInsert($item, 5) must equal get($item)');
        self::assertSame(4, $map->getOrInsert($item, 5), 'getOrInsert($item, 5) must return the stored 4');

        $item = null;
        $map->set($item, 5);
        self::assertSame($map->get($item), $map->getOrInsert($item, 6), 'getOrInsert(null, 6) must equal get(null)');
        self::assertSame(5, $map->getOrInsert($item, 6), 'getOrInsert(null, 6) must return the stored 5');

        // A key explicitly mapped to null (JS undefined) is present; the default must not win.
        $map->set('undef', null);
        self::assertNull($map->getOrInsert('undef', 7), 'getOrInsert("undef", 7) must return the stored null, not the default');
        self::assertSame(8, $map->size, 'no getOrInsert call on a present key appended an entry');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsert/returns-value-normalized-zero-key.js.
     */
    public function testReturnsValueNormalizedZeroKey(): void
    {
        $map = new Map();

        $map->set(0.0, 42);
        self::assertSame(42, $map->getOrInsert(-0.0, 1), '$map->getOrInsert(-0.0, 1) must return the 42 stored under +0');

        $map = new Map();
        $map->set(-0.0, 43);
        self::assertSame(43, $map->getOrInsert(0.0, 1), '$map->getOrInsert(0.0, 1) must return the 43 stored under the canonicalized -0 key');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsert/this-not-object-throw.js
    // Reason: rebinds `this` onto primitives via .call(); PHP methods are statically bound to Map instances
}
