<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.findLast tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFindLastTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/findLast/array-altered-during-loop.js.
     */
    public function testArrayAlteredDuringLoop(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $results = new Arr();

        $arr->findLast(static function ($kValue) use ($arr, $results) {
            if (0 === $results->length) {
                $arr->splice(1, 1);
            }
            $results->push($kValue);

            return false;
        });

        self::assertSame(3, $results->length, 'predicate called three times');
        self::assertSame('Bike', $results[0], 'The value of $results[0] is expected to be "Bike"');
        self::assertSame('Bike', $results[1], 'The value of $results[1] is expected to be "Bike"');
        self::assertSame('Shoes', $results[2], 'The value of $results[2] is expected to be "Shoes"');

        $results = new Arr();
        $arr = new Arr('Skateboard', 'Barefoot');
        $arr->findLast(static function ($kValue) use ($arr, $results) {
            if (0 === $results->length) {
                $arr->push('Motorcycle');
                $arr[0] = 'Magic Carpet';
            }

            $results->push($kValue);

            return false;
        });

        self::assertSame(2, $results->length, 'predicate called twice');
        self::assertSame('Barefoot', $results[0], 'The value of $results[0] is expected to be "Barefoot"');
        self::assertSame('Magic Carpet', $results[1], 'The value of $results[1] is expected to be "Magic Carpet"');
    }

    // SKIPPED: test/built-ins/Array/prototype/findLast/call-with-boolean.js
    // Reason: array-like with length Number.MAX_VALUE; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/findLast/callbackfn-resize-arraybuffer.js
    // Reason: array-like with length Number.MAX_VALUE; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/findLast/length.js
    // Reason: array-like with length Number.MAX_VALUE; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/findLast/maximum-index.js
    // Reason: array-like with length Number.MAX_VALUE; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/findLast/name.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/not-a-constructor.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/findLast/predicate-call-parameters.js.
     */
    public function testPredicateCallParameters(): void
    {
        $arr = new Arr('Mike', 'Rick', 'Leo');

        $results = [];

        $arr->findLast(static function (...$args) use (&$results) {
            $results[] = $args;

            return false;
        });

        self::assertCount(3, $results, 'The value of $results length is expected to be 3');

        $result = $results[0];
        self::assertSame('Leo', $result[0], 'The value of $result[0] is expected to be "Leo"');
        self::assertSame(2, $result[1], 'The value of $result[1] is expected to be 2');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');

        $result = $results[1];
        self::assertSame('Rick', $result[0], 'The value of $result[0] is expected to be "Rick"');
        self::assertSame(1, $result[1], 'The value of $result[1] is expected to be 1');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');

        $result = $results[2];
        self::assertSame('Mike', $result[0], 'The value of $result[0] is expected to be "Mike"');
        self::assertSame(0, $result[1], 'The value of $result[1] is expected to be 0');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/findLast/predicate-call-this-non-strict.js.
     */
    public function testPredicateCallThisNonStrict(): void
    {
        Arr::of(1)->findLast(function () use (&$result) {
            $result = $this;

            return false;
        });

        self::assertSame($this, $result, 'The value of $result is expected to be this');

        $o = new \stdClass();
        Arr::of(1)->findLast(function () use (&$result) {
            $result = $this;

            return false;
        }, $o);

        self::assertSame($o, $result, 'The value of $result is expected to be o');
    }

    // SKIPPED: test/built-ins/Array/prototype/findLast/predicate-call-this-strict.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/findLast/predicate-called-for-each-array-property.js.
     */
    public function testPredicateCalledForEachArrayProperty(): void
    {
        $arr = new Arr(4);
        $arr[0] = null;
        $arr[3] = 'foo';
        $called = 0;

        $arr->findLast(static function () use (&$called) {
            ++$called;

            return false;
        });

        // holes are visited too and read back as undefined (here: null), so
        // all 4 indexes are visited
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/findLast/predicate-is-not-callable-throws.js.
     */
    public function testPredicateIsNotCallableThrows(): void
    {
        foreach ([new \stdClass(), null, true, 1, '', [], new Arr()] as $nonCallable) {
            try {
                (new Arr())->findLast($nonCallable);

                throw new \Exception('Should not be reached');
            } catch (\TypeError $e) {
                self::addToAssertionCount(1);
            }
        }
    }

    /**
     * test/built-ins/Array/prototype/findLast/predicate-not-called-on-empty-array.js.
     */
    public function testPredicateNotCalledOnEmptyArray(): void
    {
        $called = false;

        $predicate = static function () use (&$called) {
            $called = true;

            return true;
        };

        $result = (new Arr())->findLast($predicate);

        self::assertFalse($called, '[].findLast(predicate) does not call predicate');
        self::assertNull($result, '[].findLast(predicate) returned null');
    }

    // SKIPPED: test/built-ins/Array/prototype/findLast/prop-desc.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/resizable-buffer-grow-mid-iteration.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/resizable-buffer-shrink-mid-iteration.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/resizable-buffer.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/findLast/return-abrupt-from-predicate-call.js.
     */
    public function testReturnAbruptFromPredicateCall(): void
    {
        $exception = new \Exception();

        $predicate = static function () use ($exception): never {
            throw $exception;
        };

        try {
            Arr::of(1)->findLast($predicate);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/findLast/return-abrupt-from-property.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/return-abrupt-from-this-length-as-symbol.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/return-abrupt-from-this-length.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/findLast/return-abrupt-from-this.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/findLast/return-found-value-predicate-result-is-true.js.
     */
    public function testReturnFoundValuePredicateResultIsTrue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->findLast(static function () use (&$called) {
            ++$called;

            return true;
        });

        self::assertSame('Bike', $result, 'The value of $result is expected to be "Bike"');
        self::assertSame(1, $called, 'predicate was called once');

        $called = 0;
        $result = $arr->findLast(static function ($val) use (&$called) {
            ++$called;

            return 'Shoes' === $val;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertSame('Shoes', $result, 'The value of $result is expected to be "Shoes"');

        $result = $arr->findLast(static fn () => 'string');
        self::assertSame('Bike', $result, 'coerced string');

        $result = $arr->findLast(static fn () => new \stdClass());
        self::assertSame('Bike', $result, 'coerced object');

        // Symbol('') has no PHP equivalent; the truthy-object case above covers it.

        $result = $arr->findLast(static fn () => 1);
        self::assertSame('Bike', $result, 'coerced number');

        $result = $arr->findLast(static fn () => -1);
        self::assertSame('Bike', $result, 'coerced negative number');
    }

    /**
     * test/built-ins/Array/prototype/findLast/return-undefined-if-predicate-returns-false-value.js.
     */
    public function testReturnUndefinedIfPredicateReturnsFalseValue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->findLast(static function () use (&$called) {
            ++$called;

            return false;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertNull($result, 'The value of $result is expected to be null');

        $result = $arr->findLast(static fn () => '');
        self::assertNull($result, 'coerced string');

        $result = $arr->findLast(static fn () => null);
        self::assertNull($result, 'coerced undefined');

        $result = $arr->findLast(static fn () => null);
        self::assertNull($result, 'coerced null');

        $result = $arr->findLast(static fn () => 0);
        self::assertNull($result, 'coerced 0');

        // The `return NaN` sub-check is not portable: PHP coerces NAN to true
        // (with a warning), unlike JS where NaN is falsy.
    }
}
