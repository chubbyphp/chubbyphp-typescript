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
    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot-set.js
    // Reason: calls the extracted size getter on a Set via .call(); PHP's magic $map->size cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: calls the extracted size getter on a WeakMap via .call(); PHP's magic $map->size cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/size/does-not-have-mapdata-internal-slot.js
    // Reason: calls the extracted size getter on an array via .call(); PHP's magic $map->size cannot be detached from a Map instance

    // SKIPPED: test/built-ins/Map/prototype/size/length.js
    // Reason: tests the "length" property descriptor of the size getter function object; PHP has no getter function object

    // SKIPPED: test/built-ins/Map/prototype/size/name.js
    // Reason: tests the "name" property descriptor ("get size") of the size getter function object; PHP has no getter function object

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-before-after-set-clear.js.
     */
    public function testReturnsCountOfPresentValuesBeforeAfterSetClear(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size, 'The value of $map->size is 0');

        $map->set(1, 1);
        $map->set(2, 2);
        self::assertSame(2, $map->size, 'The value of $map->size is 2');

        $map->clear();
        self::assertSame(0, $map->size, 'The value of $map->size is 0, after executing $map->clear()');
    }

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-before-after-set-delete.js.
     */
    public function testReturnsCountOfPresentValuesBeforeAfterSetDelete(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size, 'The value of $map->size is 0');

        $map->set(1, 1);
        self::assertSame(1, $map->size, 'The value of $map->size is 1, after executing $map->set(1, 1)');

        $map->delete(1);
        self::assertSame(0, $map->size, 'The value of $map->size is 0, after executing $map->delete(1)');
    }

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-by-insertion.js.
     */
    public function testReturnsCountOfPresentValuesByInsertion(): void
    {
        // Adapted: the JS Symbol() key is replaced by an object key; JS `undefined` and `null`
        // both map to PHP null and collapse into a single key, so the expected size is 6, not 7.
        $map = new Map();

        $map->set(0, null);
        $map->set(null, null); // covers both the JS `undefined` and JS `null` keys
        $map->set(false, null);
        $map->set(NAN, null);
        $map->set('', null);
        $map->set(new \stdClass(), null);

        self::assertSame(6, $map->size, 'The value of $map->size is 6');
    }

    /**
     * test/built-ins/Map/prototype/size/returns-count-of-present-values-by-iterable.js.
     */
    public function testReturnsCountOfPresentValuesByIterable(): void
    {
        // Adapted: the JS Symbol() key is replaced by an object key; JS `undefined` and `null`
        // both map to PHP null and collapse into a single key, so the expected size is 6, not 7.
        $map = new Map([
            [0, null],
            [null, null], // covers both the JS `undefined` and JS `null` keys
            [false, null],
            [NAN, null],
            ['', null],
            [new \stdClass(), null],
        ]);

        self::assertSame(6, $map->size, 'The value of $map->size is 6');
    }

    /**
     * test/built-ins/Map/prototype/size/size.js.
     */
    public function testSize(): void
    {
        // Adapted: the JS accessor descriptor (get is a function, set is undefined) maps to
        // PHP's magic property: reading $map->size works, writing throws a TypeError.
        // The enumerable/configurable descriptor parts are not portable to PHP.
        $map = new Map([['a', 1]]);

        self::assertSame(1, $map->size, 'reading $map->size works: the getter is present');

        try {
            $map->size = 2;

            self::fail('writing $map->size must throw a TypeError: there is no setter');
        } catch (\TypeError $e) {
            self::assertSame('Cannot set property Map::$size which has only a getter', $e->getMessage());
        }

        self::assertSame(1, $map->size, '$map->size is unchanged after the rejected write');
    }

    // SKIPPED: test/built-ins/Map/prototype/size/this-not-object-throw.js
    // Reason: calls the extracted size getter with primitive this values via .call(); PHP's magic $map->size is always accessed on a Map instance
}
