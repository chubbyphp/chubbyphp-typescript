<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.getOrInsertComputed tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeGetOrInsertComputedTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/append-new-values-normalizes-zero-key.js.
     */
    public function testAppendNewValuesNormalizesZeroKey(): void
    {
        $map = new Map();
        $map->getOrInsertComputed(-0.0, static fn (): int => 42);

        self::assertSame(42, $map->get(0), '$map->get(0) must return 42 after getOrInsertComputed(-0.0, () => 42)');

        // assertSame(-0.0, 0.0) is true in PHP, so the string cast proves the stored key is +0, not -0.
        $keys = iterator_to_array($map->keys());
        self::assertCount(1, $keys, 'map contains exactly one key');
        self::assertSame('0', (string) $keys[0], 'the -0.0 key is stored canonicalized as +0 (stringifies to "0", not "-0")');

        $map = new Map();
        $map->getOrInsertComputed(0.0, static fn (): int => 43);

        self::assertSame(43, $map->get(0), '$map->get(0) must return 43 after getOrInsertComputed(0.0, () => 43)');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/append-new-values.js.
     *
     * Adapted: PHP has no Symbol; a \stdClass object key stands in for Symbol(2).
     */
    public function testAppendNewValues(): void
    {
        $s = new \stdClass();
        $map = new Map([[4, 4], ['foo3', 3], [$s, 2]]);

        $map->getOrInsertComputed(null, static fn (): int => 42);
        $map->getOrInsertComputed(1, static fn (): string => 'valid');

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
     * test/built-ins/Map/prototype/getOrInsertComputed/append-value-if-key-is-not-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists.
     */
    public function testAppendValueIfKeyIsNotPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        $item = 'bar';
        $map->getOrInsertComputed($item, static fn (): int => 0);
        self::assertSame(0, $map->get($item), '$map->get("bar") must return 0');

        $item = 1;
        $map->getOrInsertComputed($item, static fn (): int => 42);
        self::assertSame(42, $map->get($item), '$map->get(1) must return 42');

        $item = NAN;
        $map->getOrInsertComputed($item, static fn (): int => 1);
        self::assertSame(1, $map->get($item), '$map->get(NAN) must return 1 (SameValueZero matches NaN)');

        $item = new \stdClass();
        $map->getOrInsertComputed($item, static fn (): int => 2);
        self::assertSame(2, $map->get($item), '$map->get($item) must return 2 for the object key');

        $item = new Arr();
        $map->getOrInsertComputed($item, static fn (): int => 3);
        self::assertSame(3, $map->get($item), '$map->get($item) must return 3 for the Arr key (JS [])');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        $map->getOrInsertComputed($item, static fn (): int => 4);
        self::assertSame(4, $map->get($item), '$map->get($item) must return 4 for the second object key');

        $item = null;
        $map->getOrInsertComputed($item, static fn (): int => 5);
        self::assertSame(5, $map->get($item), '$map->get(null) must return 5');

        self::assertSame(7, $map->size, 'all 7 distinct keys were appended');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/callbackfn-throws.js.
     */
    public function testCallbackfnThrows(): void
    {
        $map = new Map();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('throw in callback');

        $map->getOrInsertComputed(1, static function (): never {
            throw new \RuntimeException('throw in callback');
        });
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/canonical-key-passed-to-callback.js.
     */
    public function testCanonicalKeyPassedToCallback(): void
    {
        foreach ([-0.0, 0.0] as $key) {
            $map = new Map();

            $canonicalKey = null;
            $map->getOrInsertComputed($key, static function (mixed $keyArg) use (&$canonicalKey): void {
                $canonicalKey = $keyArg;
            });

            // assertSame(-0.0, 0.0) is true in PHP, so the string cast proves the callback received +0.
            self::assertIsFloat($canonicalKey, 'callback must receive a float key');
            self::assertSame('0', (string) $canonicalKey, 'callback must receive the canonicalized +0 key (stringifies to "0", not "-0")');
        }
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/check-callback-fn-args.js.
     *
     * Adapted: the JS `this === undefined` check is covered by using a static closure,
     * which has no bound $this in PHP.
     */
    public function testCheckCallbackFnArgs(): void
    {
        $map = new Map();

        $args = null;
        $map->getOrInsertComputed(1, static function (mixed ...$receivedArgs) use (&$args): void {
            $args = $receivedArgs;
        });

        self::assertSame([1], $args, 'callback must receive exactly one argument: the key');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/check-state-after-callback-fn-throws.js.
     */
    public function testCheckStateAfterCallbackFnThrows(): void
    {
        $map = new Map();
        $map->set(0, 'zero');
        $map->set(1, 'one');
        $map->set(2, 'two');

        try {
            $map->getOrInsertComputed(3, static function (): never {
                throw new \RuntimeException('throw in callback');
            });
            self::fail('getOrInsertComputed must rethrow the callback exception');
        } catch (\RuntimeException $e) {
            self::assertSame('throw in callback', $e->getMessage());
        }

        // Check the values after throwing in callbackfn.
        self::assertSame('zero', $map->get(0), '$map->get(0) must still return "zero"');
        self::assertSame('one', $map->get(1), '$map->get(1) must still return "one"');
        self::assertSame('two', $map->get(2), '$map->get(2) must still return "two"');
        self::assertFalse($map->has(3), 'key 3 must not have been inserted');

        try {
            $map->getOrInsertComputed(3, static function () use ($map): never {
                $map->set(1, 'mutated');

                throw new \RuntimeException('throw in callback');
            });
            self::fail('getOrInsertComputed must rethrow the callback exception');
        } catch (\RuntimeException $e) {
            self::assertSame('throw in callback', $e->getMessage());
        }

        // Check the values after throwing in callbackfn, with mutation.
        self::assertSame('zero', $map->get(0), '$map->get(0) must still return "zero"');
        self::assertSame('mutated', $map->get(1), '$map->get(1) must return the mutated value');
        self::assertSame('two', $map->get(2), '$map->get(2) must still return "two"');
        self::assertFalse($map->has(3), 'key 3 must not have been inserted');

        try {
            $map->getOrInsertComputed(3, static function () use ($map): never {
                $map->set(3, 'mutated');

                throw new \RuntimeException('throw in callback');
            });
            self::fail('getOrInsertComputed must rethrow the callback exception');
        } catch (\RuntimeException $e) {
            self::assertSame('throw in callback', $e->getMessage());
        }

        // Check the values after throwing in callbackfn, with mutation.
        self::assertSame('zero', $map->get(0), '$map->get(0) must still return "zero"');
        self::assertSame('mutated', $map->get(1), '$map->get(1) must return the mutated value');
        self::assertSame('two', $map->get(2), '$map->get(2) must still return "two"');
        self::assertSame('mutated', $map->get(3), '$map->get(3) must keep the value set by the callback before it threw');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/different-types-function-callbackfn-does-not-throw.js.
     *
     * Adapted: the JS callable-type matrix (function expression, arrow function, function
     * declaration, new Function(), bound function) is mapped to PHP callable types: anonymous
     * function, static arrow function, internal function name string, static method array
     * callable and first-class callable syntax. JS `new Function()` returns undefined; PHP null
     * plays JS undefined.
     */
    public function testDifferentTypesFunctionCallbackfnDoesNotThrow(): void
    {
        $m = new Map();

        self::assertSame(1, $m->getOrInsertComputed(1, static fn (): int => 1), 'anonymous function callback must return 1');
        self::assertSame(1, $m->get(1), '$m->get(1) must return 1');

        self::assertSame(2, $m->getOrInsertComputed(2, static fn (): int => 2), 'static arrow function callback must return 2');
        self::assertSame(2, $m->get(2), '$m->get(2) must return 2');

        self::assertSame('eerht', $m->getOrInsertComputed('three', 'strrev'), 'function name string callback must return strrev("three")');
        self::assertSame('eerht', $m->get('three'), '$m->get("three") must return "eerht"');

        self::assertSame(4, $m->getOrInsertComputed(4, [self::class, 'computeFour']), 'static method array callback must return 4');
        self::assertSame(4, $m->get(4), '$m->get(4) must return 4');

        self::assertSame(5, $m->getOrInsertComputed(5, self::computeFive(...)), 'first-class callable callback must return 5');
        self::assertSame(5, $m->get(5), '$m->get(5) must return 5');

        // JS `new Function()` returns undefined; PHP null plays JS undefined.
        self::assertNull($m->getOrInsertComputed(6, static fn () => null), 'callback returning null must yield null');
        self::assertNull($m->get(6), '$m->get(6) must return null');
        self::assertTrue($m->has(6), 'key 6 must be present even though its value is null');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/does-not-evaluate-callbackfn-if-key-present.js.
     */
    public function testDoesNotEvaluateCallbackfnIfKeyPresent(): void
    {
        $map = new Map([[1, 0]]);

        $callbackCalls = 0;
        $callback = static function () use (&$callbackCalls): never {
            ++$callbackCalls;

            throw new \RuntimeException('Callbackfn should not be evaluated if key is present');
        };

        self::assertSame(0, $map->getOrInsertComputed(1, $callback), '$map->getOrInsertComputed(1, $callback) must return the stored 0');

        $map->set(2, 1);
        self::assertSame(1, $map->getOrInsertComputed(2, $callback), '$map->getOrInsertComputed(2, $callback) must return the stored 1');

        $map->set(3, 2);
        self::assertSame(2, $map->getOrInsertComputed(3, $callback), '$map->getOrInsertComputed(3, $callback) must return the stored 2');

        try {
            $map->getOrInsertComputed(4, $callback);
            self::fail('getOrInsertComputed must evaluate the callback for the missing key 4 and rethrow');
        } catch (\RuntimeException $e) {
            self::assertSame('Callbackfn should not be evaluated if key is present', $e->getMessage());
        }

        self::assertSame(1, $callbackCalls, 'callback must have been evaluated exactly once');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/does-not-have-mapdata-internal-slot-set.js
    // Reason: rebinds `this` onto a Set via .call(); PHP methods are statically bound to Map instances

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: rebinds `this` onto a WeakMap via .call(); PHP methods are statically bound to Map instances

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/getOrInsertComputed.js.
     *
     * Adapted: the JS property descriptor checks (writable/enumerable/configurable) have no
     * PHP equivalent; only the "is a function" aspect is portable.
     */
    public function testGetOrInsertComputed(): void
    {
        self::assertTrue(method_exists(Map::class, 'getOrInsertComputed'), 'Map::getOrInsertComputed must exist');

        $map = new Map();
        self::assertIsCallable([$map, 'getOrInsertComputed'], '[$map, "getOrInsertComputed"] must be callable');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/not-a-constructor.js
    // Reason: `new m.getOrInsertComputed()`; PHP methods are not constructible values

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/not-a-function-callbackfn-throws.js
    // Reason: PHP's native `callable` parameter type already rejects non-callable arguments with an engine-level TypeError

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/overwrites-mutation-from-callbackfn.js.
     */
    public function testOverwritesMutationFromCallbackfn(): void
    {
        $map = new Map();
        $foo = 1;
        $bar = 2;
        $baz = 3;

        $map->getOrInsertComputed($foo, static function () use ($map, $foo): int {
            $map->set($foo, 0);

            return 3;
        });
        $map->getOrInsertComputed($bar, static function () use ($map, $bar): void {
            $map->set($bar, 1);
        });
        $map->getOrInsertComputed($baz, static function () use ($map, $baz): string {
            $map->set($baz, 2);

            return 'string';
        });

        self::assertSame(3, $map->get($foo), '$map->get($foo) must return the computed 3, overwriting the callback mutation');
        self::assertNull($map->get($bar), '$map->get($bar) must return the computed null (JS undefined), overwriting the callback mutation');
        self::assertSame('string', $map->get($baz), '$map->get($baz) must return the computed "string", overwriting the callback mutation');

        // The entry keeps the insertion position established by the callback's own set().
        self::assertSame([1, 2, 3], iterator_to_array($map->keys()), 'keys must stay in the callback insertion order');
        self::assertSame(3, $map->size, 'each key must exist exactly once');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/returns-value-if-key-is-not-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists.
     */
    public function testReturnsValueIfKeyIsNotPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        $item = 'bar';
        self::assertSame(0, $map->getOrInsertComputed($item, static fn (): int => 0), 'getOrInsertComputed("bar", () => 0) must return 0');

        $item = 1;
        self::assertSame(42, $map->getOrInsertComputed($item, static fn (): int => 42), 'getOrInsertComputed(1, () => 42) must return 42');

        $item = NAN;
        self::assertSame(1, $map->getOrInsertComputed($item, static fn (): int => 1), 'getOrInsertComputed(NAN, () => 1) must return 1');

        $item = new \stdClass();
        self::assertSame(2, $map->getOrInsertComputed($item, static fn (): int => 2), 'getOrInsertComputed($item, () => 2) must return 2 for the object key');

        $item = new Arr();
        self::assertSame(3, $map->getOrInsertComputed($item, static fn (): int => 3), 'getOrInsertComputed($item, () => 3) must return 3 for the Arr key (JS [])');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        self::assertSame(4, $map->getOrInsertComputed($item, static fn (): int => 4), 'getOrInsertComputed($item, () => 4) must return 4 for the second object key');

        $item = null;
        self::assertSame(5, $map->getOrInsertComputed($item, static fn (): int => 5), 'getOrInsertComputed(null, () => 5) must return 5');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/returns-value-if-key-is-present-different-key-types.js.
     *
     * Adapted key-type matrix: PHP has no Symbol (a second distinct object stands in for
     * Symbol('item')); an Arr instance stands in for the JS [] object key; JS null and
     * undefined are distinct keys, but PHP null plays JS undefined, so only a single null
     * key exists. Additionally asserts that a key explicitly mapped to null (JS undefined)
     * is PRESENT: getOrInsertComputed returns the stored null without evaluating the callback.
     */
    public function testReturnsValueIfKeyIsPresentDifferentKeyTypes(): void
    {
        $map = new Map();

        $item = 'bar';
        $map->set($item, 0);
        self::assertSame(0, $map->getOrInsertComputed($item, static fn (): int => 1), 'getOrInsertComputed("bar", () => 1) must return the stored 0');

        $item = 1;
        $map->set($item, 42);
        self::assertSame(42, $map->getOrInsertComputed($item, static fn (): int => 43), 'getOrInsertComputed(1, () => 43) must return the stored 42');

        $item = NAN;
        $map->set($item, 1);
        self::assertSame(1, $map->getOrInsertComputed($item, static fn (): int => 2), 'getOrInsertComputed(NAN, () => 2) must return the stored 1');

        $item = new \stdClass();
        $map->set($item, 2);
        self::assertSame(2, $map->getOrInsertComputed($item, static fn (): int => 3), 'getOrInsertComputed($item, () => 3) must return the stored 2');

        $item = new Arr();
        $map->set($item, 3);
        self::assertSame(3, $map->getOrInsertComputed($item, static fn (): int => 4), 'getOrInsertComputed($item, () => 4) must return the stored 3');

        // JS Symbol('item') key: adapted to another distinct object.
        $item = new \stdClass();
        $map->set($item, 4);
        self::assertSame(4, $map->getOrInsertComputed($item, static fn (): int => 5), 'getOrInsertComputed($item, () => 5) must return the stored 4');

        $item = null;
        $map->set($item, 5);
        self::assertSame(5, $map->getOrInsertComputed($item, static fn (): int => 6), 'getOrInsertComputed(null, () => 6) must return the stored 5');

        // A key explicitly mapped to null (JS undefined) is present; the callback must not run.
        $map->set('undef', null);
        self::assertNull($map->getOrInsertComputed('undef', static function (): never {
            throw new \RuntimeException('callback must not be evaluated for a present key');
        }), 'getOrInsertComputed("undef", cb) must return the stored null, not a computed value');
        self::assertSame(8, $map->size, 'no getOrInsertComputed call on a present key appended an entry');
    }

    /**
     * test/built-ins/Map/prototype/getOrInsertComputed/returns-value-normalized-zero-key.js.
     */
    public function testReturnsValueNormalizedZeroKey(): void
    {
        $map = new Map();

        $map->set(0.0, 42);
        self::assertSame(42, $map->getOrInsertComputed(-0.0, static fn (): int => 1), '$map->getOrInsertComputed(-0.0, () => 1) must return the 42 stored under +0');

        $map = new Map();
        $map->set(-0.0, 43);
        self::assertSame(43, $map->getOrInsertComputed(0.0, static fn (): int => 1), '$map->getOrInsertComputed(0.0, () => 1) must return the 43 stored under the canonicalized -0 key');
    }

    // SKIPPED: test/built-ins/Map/prototype/getOrInsertComputed/this-not-object-throw.js
    // Reason: rebinds `this` onto primitives via .call(); PHP methods are statically bound to Map instances

    public static function computeFour(): int
    {
        return 4;
    }

    public static function computeFive(): int
    {
        return 5;
    }
}
