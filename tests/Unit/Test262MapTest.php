<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map tests.
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
    public function testBigintNumberSameValue(): void
    {
        // Adaptation: PHP has no bigint, so the BigInt half of the original test is skipped.
        // Only the Number key behavior is ported; additionally, int and float keys with the
        // same numeric value are asserted to be the same key (matching JS, where all numbers
        // are doubles).
        $number = 9007199254740991;

        $m = new Map([[$number, $number]]);

        self::assertSame(1, $m->size, 'The value of `$m->size` is `1`');
        self::assertTrue($m->has($number), '$m->has(9007199254740991) must return true');
        self::assertSame($number, $m->get($number), '$m->get(9007199254740991) must return 9007199254740991');

        $m->delete($number);
        self::assertSame(0, $m->size, 'The value of `$m->size` is `0` after delete');
        self::assertFalse($m->has($number), '$m->has(9007199254740991) must return false after delete');

        $m->set($number, $number);
        self::assertSame(1, $m->size, 'The value of `$m->size` is `1` after set');

        // int 9007199254740991 and float 9007199254740991.0 are numerically equal, therefore
        // the same Map key (matching JS, where both would be the same Number value).
        $m2 = new Map([[$number, 'int'], [(float) $number, 'float']]);
        self::assertSame(1, $m2->size, 'int and float keys with the same numeric value collapse to one entry');
        self::assertSame('float', $m2->get($number), 'the second entry overwrote the value of the first');
    }

    // SKIPPED: test/built-ins/Map/constructor.js
    // Reason: tests that the Map global binding is a function; no PHP equivalent

    // SKIPPED: test/built-ins/Map/does-not-throw-when-set-is-not-callable.js
    // Reason: requires replacing the `set` adder method on Map.prototype

    // SKIPPED: test/built-ins/Map/get-set-method-failure.js
    // Reason: requires a throwing property descriptor getter for `set`

    // SKIPPED: test/built-ins/Map/is-a-constructor.js
    // Reason: tests [[Construct]] via Reflect.construct; no PHP equivalent

    // SKIPPED: test/built-ins/Map/iterable-calls-set.js
    // Reason: requires observing/replacing the `set` adder method

    // SKIPPED: test/built-ins/Map/iterator-close-after-set-failure.js
    // Reason: requires observing iterator close (return()) and replacing `set`

    // SKIPPED: test/built-ins/Map/iterator-close-failure-after-set-failure.js
    // Reason: requires observing iterator close (return()) and replacing `set`

    /**
     * test/built-ins/Map/iterator-is-undefined-throws.js.
     */
    public function testIteratorIsUndefinedThrows(): void
    {
        // Adaptation: an object without Symbol.iterator becomes a non-Traversable PHP object.
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('stdClass is not iterable');

        new Map(new \stdClass());
    }

    // SKIPPED: test/built-ins/Map/iterator-item-first-entry-returns-abrupt.js
    // Reason: requires an abrupt property getter on the entry ("0") and iterator close

    // SKIPPED: test/built-ins/Map/iterator-item-second-entry-returns-abrupt.js
    // Reason: requires an abrupt property getter on the entry ("1") and iterator close

    // SKIPPED: test/built-ins/Map/iterator-items-are-not-object-close-iterator.js
    // Reason: requires observing iterator close via return()

    /**
     * test/built-ins/Map/iterator-items-are-not-object.js.
     */
    public function testIteratorItemsAreNotObject(): void
    {
        // Adaptation: the Symbol('a') case is skipped (PHP has no Symbol);
        // the undefined case collapses into the null case (PHP null plays JS undefined).
        $items = [
            'int' => 1,
            'string' => '',
            'bool' => true,
            'null' => null,
        ];

        foreach ($items as $type => $item) {
            try {
                new Map([$item]);
                self::fail(\sprintf('new Map([<%s>]) must throw a TypeError', $type));
            } catch (\TypeError $e) {
                self::assertSame(
                    'Iterator value is not an entry object',
                    $e->getMessage(),
                    \sprintf('new Map([<%s>]) throws a TypeError with the expected message', $type)
                );
            }
        }

        try {
            new Map([['a', 1], 2]);
            self::fail("new Map([['a', 1], 2]) must throw a TypeError");
        } catch (\TypeError $e) {
            self::assertSame(
                'Iterator value is not an entry object',
                $e->getMessage(),
                'a non-iterable item after a valid entry throws a TypeError'
            );
        }
    }

    // SKIPPED: test/built-ins/Map/iterator-next-failure.js
    // Reason: requires a custom iterator whose next() completes abruptly (JS iterator protocol)

    // SKIPPED: test/built-ins/Map/iterator-value-failure.js
    // Reason: requires an abrupt `value` property getter on the iterator result

    // SKIPPED: test/built-ins/Map/length.js
    // Reason: property descriptor of Map.length; no PHP equivalent

    // SKIPPED: test/built-ins/Map/map-iterable-empty-does-not-call-set.js
    // Reason: requires observing the `set` adder method

    // SKIPPED: test/built-ins/Map/map-iterable-throws-when-set-is-not-callable.js
    // Reason: requires replacing the `set` adder method with a non-callable

    /**
     * test/built-ins/Map/map-iterable.js.
     */
    public function testMapIterable(): void
    {
        $m = new Map([
            ['attr', 1],
            ['foo', 2],
        ]);

        self::assertSame(2, $m->size, 'The value of `$m->size` is `2`');
        self::assertSame(1, $m->get('attr'), "\$m->get('attr') must return 1");
        self::assertSame(2, $m->get('foo'), "\$m->get('foo') must return 2");
    }

    // SKIPPED: test/built-ins/Map/map-no-iterable-does-not-call-set.js
    // Reason: requires observing the `set` adder method

    /**
     * test/built-ins/Map/map-no-iterable.js.
     */
    public function testMapNoIterable(): void
    {
        // Adaptation: PHP null plays both JS undefined and JS null,
        // so new Map(undefined) and new Map(null) collapse into new Map(null).
        $m1 = new Map();
        $m2 = new Map(null);

        self::assertSame(0, $m1->size, 'The value of `(new Map())->size` is `0`');
        self::assertSame(0, $m2->size, 'The value of `(new Map(null))->size` is `0`');

        self::assertInstanceOf(Map::class, $m1, '$m1 is an instance of Map');
        self::assertInstanceOf(Map::class, $m2, '$m2 is an instance of Map');
    }

    // SKIPPED: test/built-ins/Map/map.js
    // Reason: property descriptor of the Map global binding; no PHP equivalent

    // SKIPPED: test/built-ins/Map/name.js
    // Reason: property descriptor of Map.name; no PHP equivalent

    // SKIPPED: test/built-ins/Map/newtarget.js
    // Reason: prototype chain / NewTarget semantics; no PHP equivalent

    // SKIPPED: test/built-ins/Map/properties-of-map-instances.js
    // Reason: prototype chain semantics; no PHP equivalent

    // SKIPPED: test/built-ins/Map/properties-of-the-map-prototype-object.js
    // Reason: prototype chain semantics; no PHP equivalent

    // SKIPPED: test/built-ins/Map/proto-from-ctor-realm.js
    // Reason: cross-realm NewTarget semantics; no PHP equivalent

    // SKIPPED: test/built-ins/Map/prototype-of-map.js
    // Reason: prototype chain semantics; no PHP equivalent

    // SKIPPED: test/built-ins/Map/undefined-newtarget.js
    // Reason: calling Map without `new`; PHP constructors always require `new`

    /**
     * test/built-ins/Map/valid-keys.js.
     */
    public function testValidKeys(): void
    {
        // Adaptation: bigint, Symbol, TypedArray, Set, WeakMap, WeakRef and WeakSet keys are
        // skipped (no PHP equivalent); undefinedValue/unassigned collapse into the null case
        // (PHP null plays JS undefined). A stdClass, a closure and a Map instance stand in
        // for the JS object/function/class/map keys; a PHP array stands in for the JS array.
        $this->assertValidKey(-0.0, 'negativeZero');
        $this->assertValidKey(0.0, 'positiveZero');
        $this->assertValidKey(0, 'zero');
        $this->assertValidKey(1, 'one');
        $this->assertValidKey(2 ** 53 - 1, 'twoRaisedToFiftyThreeMinusOne');
        $this->assertValidKey(new \stdClass(), 'object');
        $this->assertValidKey([], 'array');
        $this->assertValidKey('', 'string');
        $this->assertValidKey(true, 'booleanTrue');
        $this->assertValidKey(false, 'booleanFalse');
        $this->assertValidKey(static fn () => null, 'closure');
        $this->assertValidKey(new Map(), 'map');
        $this->assertValidKey(null, 'nullValue');

        // -0 is canonicalized to +0 on insertion; assert via the string cast, because
        // assertSame(-0.0, 0.0) cannot distinguish the two.
        $m = new Map([[-0.0, 'negative zero']]);
        $keys = iterator_to_array($m->keys());
        self::assertCount(1, $keys, 'the map has exactly one key');
        self::assertSame('0', (string) $keys[0], 'the key -0.0 is canonicalized to +0');
    }

    private function assertValidKey(mixed $key, string $label): void
    {
        $m = new Map([[$key, $key]]);
        self::assertSame(1, $m->size, \sprintf('%s: `$m->size` is `1`', $label));
        self::assertTrue($m->has($key), \sprintf('%s: $m->has($key) must return true', $label));
        self::assertSame($key, $m->get($key), \sprintf('%s: $m->get($key) must return $key', $label));

        self::assertTrue($m->delete($key), \sprintf('%s: $m->delete($key) must return true', $label));
        self::assertSame(0, $m->size, \sprintf('%s: `$m->size` is `0` after delete', $label));
        self::assertFalse($m->has($key), \sprintf('%s: $m->has($key) must return false after delete', $label));

        $m->set($key, $key);
        self::assertSame(1, $m->size, \sprintf('%s: `$m->size` is `1` after set', $label));
        self::assertTrue($m->has($key), \sprintf('%s: $m->has($key) must return true after set', $label));
        self::assertSame($key, $m->get($key), \sprintf('%s: $m->get($key) must return $key after set', $label));
    }
}
