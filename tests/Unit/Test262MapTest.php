<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map constructor tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapTest extends TestCase
{
    /**
     * test/built-ins/Map/bigint-number-same-value.js.
     */
    public function testBigIntNumberSameValue(): void
    {
        // PHP has no BigInt primitive; object equivalents are not coerced.
        $map = new Map();
        $map->set(1, 'number');

        self::assertTrue($map->has(1));
        self::assertFalse($map->has('1'));
    }

    /**
     * test/built-ins/Map/constructor.js.
     */
    public function testConstructor(): void
    {
        self::assertInstanceOf(Map::class, new Map());
    }

    // SKIPPED: test/built-ins/Map/does-not-throw-when-set-is-not-callable.js
    // Reason: constructor uses direct storage, not a user-supplied set method

    // SKIPPED: test/built-ins/Map/get-set-method-failure.js
    // Reason: constructor does not call a set method

    // SKIPPED: test/built-ins/Map/groupBy/callback-arg.js
    // SKIPPED: test/built-ins/Map/groupBy/callback-throws.js
    // SKIPPED: test/built-ins/Map/groupBy/emptyList.js
    // SKIPPED: test/built-ins/Map/groupBy/evenOdd.js
    // SKIPPED: test/built-ins/Map/groupBy/groupLength.js
    // SKIPPED: test/built-ins/Map/groupBy/invalid-callback.js
    // SKIPPED: test/built-ins/Map/groupBy/invalid-iterable.js
    // SKIPPED: test/built-ins/Map/groupBy/iterator-next-throws.js
    // SKIPPED: test/built-ins/Map/groupBy/length.js
    // SKIPPED: test/built-ins/Map/groupBy/map-instance.js
    // SKIPPED: test/built-ins/Map/groupBy/name.js
    // SKIPPED: test/built-ins/Map/groupBy/negativeZero.js
    // SKIPPED: test/built-ins/Map/groupBy/string.js
    // SKIPPED: test/built-ins/Map/groupBy/toPropertyKey.js
    // Reason: Map.groupBy static method is not implemented

    // SKIPPED: test/built-ins/Map/is-a-constructor.js
    // Reason: PHP class constructor is always a constructor

    /**
     * test/built-ins/Map/iterable-calls-set.js.
     */
    public function testIterableCallsSet(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertSame(2, $map->size);
        self::assertSame(1, $map->get('a'));
        self::assertSame(2, $map->get('b'));
    }

    // SKIPPED: test/built-ins/Map/iterator-close-after-set-failure.js
    // Reason: requires Symbol.iterator and iterator return/throw completion records

    // SKIPPED: test/built-ins/Map/iterator-close-failure-after-set-failure.js
    // Reason: requires Symbol.iterator and iterator return/throw completion records

    /**
     * test/built-ins/Map/iterator-is-undefined-throws.js.
     */
    public function testIteratorIsUndefinedThrows(): void
    {
        $this->expectException(\TypeError::class);

        new Map(new \stdClass());
    }

    // SKIPPED: test/built-ins/Map/iterator-item-first-entry-returns-abrupt.js
    // Reason: requires Object.defineProperty getter-setter semantics and iterator close

    // SKIPPED: test/built-ins/Map/iterator-item-second-entry-returns-abrupt.js
    // Reason: requires Object.defineProperty getter-setter semantics and iterator close

    // SKIPPED: test/built-ins/Map/iterator-items-are-not-object-close-iterator.js
    // Reason: requires Symbol.iterator and iterator return completion records

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObjectInteger(): void
    {
        $this->expectException(\TypeError::class);

        new Map([1]);
    }

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObjectString(): void
    {
        $this->expectException(\TypeError::class);

        new Map(['']);
    }

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObjectBoolean(): void
    {
        $this->expectException(\TypeError::class);

        new Map([true]);
    }

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObjectNull(): void
    {
        $this->expectException(\TypeError::class);

        new Map([null]);
    }

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObjectUndefined(): void
    {
        $this->expectException(\TypeError::class);

        new Map([null]);
    }

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorMixedValidAndInvalidItems(): void
    {
        $this->expectException(\TypeError::class);

        new Map([
            ['a', 1],
            2,
        ]);
    }

    /**
     * test/built-ins/Map/iterator-next-failure.js.
     */
    public function testIteratorNextFailure(): void
    {
        $this->expectException(\RuntimeException::class);

        $generator = static function (): \Generator {
            yield ['a', 1];

            throw new \RuntimeException('next failure');
        };

        new Map($generator());
    }

    /**
     * test/built-ins/Map/iterator-value-failure.js.
     */
    public function testIteratorValueFailure(): void
    {
        $this->expectException(\RuntimeException::class);

        $iterable = new class implements \Iterator {
            private bool $valid = true;

            public function current(): mixed
            {
                throw new \RuntimeException('value failure');
            }

            public function key(): mixed
            {
                return 0;
            }

            public function next(): void
            {
                $this->valid = false;
            }

            public function rewind(): void
            {
                $this->valid = true;
            }

            public function valid(): bool
            {
                return $this->valid;
            }
        };

        new Map($iterable);
    }

    // SKIPPED: test/built-ins/Map/length.js
    // SKIPPED: test/built-ins/Map/name.js
    // Reason: length/name/prop-desc descriptor tests are not portable

    /**
     * test/built-ins/Map/map-iterable-empty-does-not-call-set.js.
     */
    public function testEmptyIterableDoesNotCallSet(): void
    {
        $map = new Map([]);

        self::assertSame(0, $map->size);
    }

    /**
     * test/built-ins/Map/map-iterable-empty-does-not-modify.js.
     */
    public function testEmptyIterableDoesNotModify(): void
    {
        $map = new Map();
        $newMap = new Map($map);

        self::assertSame(0, $newMap->size);
    }

    /**
     * test/built-ins/Map/map-iterable-throws-when-set-is-not-callable.js.
     */
    public function testIterableThrowsOnInvalidEntry(): void
    {
        $this->expectException(\TypeError::class);

        new Map([['a', 1], 2]);
    }

    /**
     * test/built-ins/Map/map-iterable.js.
     */
    public function testMapIterable(): void
    {
        $map = new Map([
            ['a', 1],
            ['b', 2],
        ]);

        self::assertSame(2, $map->size);
        self::assertSame(1, $map->get('a'));
        self::assertSame(2, $map->get('b'));
    }

    /**
     * test/built-ins/Map/map-no-iterable-does-not-call-set.js.
     */
    public function testNoIterableDoesNotCallSet(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);
    }

    /**
     * test/built-ins/Map/map-no-iterable.js.
     */
    public function testNoIterable(): void
    {
        $map1 = new Map();
        $map2 = new Map(null);

        self::assertSame(0, $map1->size);
        self::assertSame(0, $map2->size);
        self::assertInstanceOf(Map::class, $map1);
        self::assertInstanceOf(Map::class, $map2);
    }

    /**
     * test/built-ins/Map/map.js.
     */
    public function testMap(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);
        self::assertInstanceOf(Map::class, $map);
    }

    // SKIPPED: test/built-ins/Map/newtarget.js
    // Reason: PHP has no equivalent of JavaScript's new.target

    // SKIPPED: test/built-ins/Map/properties-of-map-instances.js
    // SKIPPED: test/built-ins/Map/properties-of-the-map-prototype-object.js
    // Reason: property descriptor tests are not portable

    // SKIPPED: test/built-ins/Map/proto-from-ctor-realm.js
    // SKIPPED: test/built-ins/Map/prototype-of-map.js
    // Reason: realm and intrinsic prototype tests are not portable

    // SKIPPED: test/built-ins/Map/Symbol.species/length.js
    // SKIPPED: test/built-ins/Map/Symbol.species/return-value.js
    // SKIPPED: test/built-ins/Map/Symbol.species/symbol-species-name.js
    // SKIPPED: test/built-ins/Map/Symbol.species/symbol-species.js
    // Reason: Symbol.species is not supported in PHP

    // SKIPPED: test/built-ins/Map/undefined-newtarget.js
    // Reason: PHP has no equivalent of JavaScript's new.target

    /**
     * test/built-ins/Map/valid-keys.js.
     */
    public function testValidKeys(): void
    {
        $objectKey = new \stdClass();
        $arrayKey = ['key'];
        $functionKey = static fn (): null => null;
        $mapKey = new Map();
        $classKey = new class {};

        $map = new Map([
            [1, 'one'],
            [9007199254740991, 'max safe int'],
            ['', 'empty string'],
            [true, 'true'],
            [false, 'false'],
            [null, 'null'],
            [$objectKey, 'object'],
            [$arrayKey, 'array'],
            [$functionKey, 'function'],
            [$mapKey, 'map'],
            [$classKey, 'class'],
            [NAN, 'NaN'],
        ]);

        self::assertSame('one', $map->get(1));
        self::assertSame('max safe int', $map->get(9007199254740991));
        self::assertSame('empty string', $map->get(''));
        self::assertSame('true', $map->get(true));
        self::assertSame('false', $map->get(false));
        self::assertSame('null', $map->get(null));
        self::assertSame('object', $map->get($objectKey));
        self::assertSame('array', $map->get($arrayKey));
        self::assertSame('function', $map->get($functionKey));
        self::assertSame('map', $map->get($mapKey));
        self::assertSame('class', $map->get($classKey));
        self::assertSame('NaN', $map->get(NAN));
        self::assertSame(12, $map->size);

        // Same-value-zero: -0 and +0 are equivalent.
        $zeroMap = new Map([[-0.0, 'negative zero']]);
        self::assertSame('negative zero', $zeroMap->get(-0.0));
        self::assertSame('negative zero', $zeroMap->get(0));
        $zeroMap->set(0, 'zero');
        self::assertSame('zero', $zeroMap->get(-0.0));
        self::assertSame('zero', $zeroMap->get(0));

        // Same-value-zero: all NaN values are equivalent.
        $nanMap = new Map([[NAN, 'NaN']]);
        self::assertSame('NaN', $nanMap->get(NAN));
        $nanMap->set(NAN, 'updated NaN');
        self::assertSame('updated NaN', $nanMap->get(NAN));
    }
}
