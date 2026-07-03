<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.set tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeSetTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/set/append-new-values-normalizes-zero-key.js.
     */
    public function testAppendNewValuesNormalizesZeroKey(): void
    {
        $map = new Map();
        $map->set(-0.0, 42);

        self::assertSame(42, $map->get(0), '$map->get(0) must return 42');

        // Adapted: assertSame(-0.0, 0.0) passes in PHP, so prove the stored key is +0 via its
        // string representation ((string) -0.0 === '-0', (string) 0.0 === '0').
        $keys = iterator_to_array($map->keys());
        self::assertCount(1, $keys, 'the map must contain exactly one key');
        self::assertSame('0', (string) $keys[0], 'the stored key must stringify to "0", proving -0 was normalized to +0');

        $map = new Map();
        $map->set(+0.0, 43);

        self::assertSame(43, $map->get(0), '$map->get(0) must return 43');
    }

    /**
     * test/built-ins/Map/prototype/set/append-new-values-return-map.js.
     */
    public function testAppendNewValuesReturnMap(): void
    {
        $map = new Map();
        $result = $map->set(1, 1);

        self::assertSame($map, $result, '$map->set(1, 1) must return the map instance');

        $result = $map->set(1, 1)->set(2, 2)->set(3, 3);

        self::assertSame($map, $result, 'Map::set is chainable');

        // The Map.prototype.set.call(map, 4, 4) rebinding part is not portable to PHP.
    }

    /**
     * test/built-ins/Map/prototype/set/append-new-values.js.
     */
    public function testAppendNewValues(): void
    {
        // Adapted: the JS Symbol(2) key is replaced by an object key (compared by identity in
        // PHP as well); the JS null key becomes PHP null (which plays JS undefined/null).
        $s = new \stdClass();
        $map = new Map([[4, 4], ['foo3', 3], [$s, 2]]);

        $map->set(null, 42);
        $map->set(1, 'valid');

        self::assertSame(5, $map->size, '$map->size must be 5');
        self::assertSame('valid', $map->get(1), '$map->get(1) must return "valid"');

        $results = [];

        $map->forEach(static function (mixed $value, mixed $key) use (&$results): void {
            $results[] = [
                'value' => $value,
                'key' => $key,
            ];
        });

        $result = array_pop($results);
        self::assertSame('valid', $result['value'], 'the last entry value must be "valid"');
        self::assertSame(1, $result['key'], 'the last entry key must be 1');

        $result = array_pop($results);
        self::assertSame(42, $result['value'], 'the second to last entry value must be 42');
        self::assertNull($result['key'], 'the second to last entry key must be null');

        $result = array_pop($results);
        self::assertSame(2, $result['value'], 'the third to last entry value must be 2');
        self::assertSame($s, $result['key'], 'the third to last entry key must be the object key');
    }

    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot-set.js
    // Reason: rebinds Map.prototype.set to a Set via .call(); PHP methods cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: rebinds Map.prototype.set to a WeakMap via .call(); PHP methods cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/set/does-not-have-mapdata-internal-slot.js
    // Reason: rebinds Map.prototype.set to arrays/plain objects via .call(); PHP methods cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/set/length.js
    // Reason: tests the "length" property descriptor of the set function object; PHP methods have no such property

    // SKIPPED: test/built-ins/Map/prototype/set/name.js
    // Reason: tests the "name" property descriptor of the set function object; PHP methods have no such property

    // SKIPPED: test/built-ins/Map/prototype/set/not-a-constructor.js
    // Reason: tests that `new map.set()` throws; PHP methods are not constructable, the concept does not exist

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value-normalizes-zero-key.js.
     */
    public function testReplacesAValueNormalizesZeroKey(): void
    {
        $map = new Map([[+0.0, 1]]);

        $map->set(-0.0, 42);
        self::assertSame(42, $map->get(+0.0), 'zero key is normalized in SameValueZero');
        self::assertSame(1, $map->size, '$map->size must stay 1: -0 replaced the +0 entry');

        $map = new Map([[-0.0, 1]]);

        $map->set(+0.0, 42);
        self::assertSame(42, $map->get(-0.0), 'zero key is normalized in SameValueZero');
        self::assertSame(1, $map->size, '$map->size must stay 1: +0 replaced the -0 entry');
    }

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value-returns-map.js.
     */
    public function testReplacesAValueReturnsMap(): void
    {
        $map = new Map([['item', 0]]);

        $x = $map->set('item', 42);
        self::assertSame($map, $x, '$map->set("item", 42) must return the map instance');

        // The Map.prototype.set.call(map, ...) / map2.set.call(map, ...) rebinding parts are
        // not portable to PHP; replacing again on the instance covers the replace-returns-map path.
        $x = $map->set('item', 0);
        self::assertSame($map, $x, 'Map::set returns the map `this` value');
    }

    /**
     * test/built-ins/Map/prototype/set/replaces-a-value.js.
     */
    public function testReplacesAValue(): void
    {
        $map = new Map([['item', 1]]);

        $map->set('item', 42);
        self::assertSame(42, $map->get('item'), '$map->get("item") must return 42');
        self::assertSame(1, $map->size, '$map->size must stay 1');
    }

    /**
     * test/built-ins/Map/prototype/set/set.js.
     */
    public function testSet(): void
    {
        // Adapted: the property descriptor parts (writable/enumerable/configurable) are not
        // portable to PHP; assert that Map::set exists and is callable instead.
        self::assertTrue(method_exists(Map::class, 'set'), 'Map::set must exist');
        self::assertIsCallable([new Map(), 'set'], 'Map::set must be callable');
    }

    // SKIPPED: test/built-ins/Map/prototype/set/this-not-object-throw.js
    // Reason: calls Map.prototype.set with primitive this values via .call(); PHP methods are always invoked on a Map instance
}
