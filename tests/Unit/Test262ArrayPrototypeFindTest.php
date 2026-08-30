<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.find tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFindTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/find/array-altered-during-loop.js.
     */
    public function testArrayAlteredDuringLoop(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $results = new Arr();

        $arr->find(static function ($kValue) use ($arr, $results) {
            if (0 === $results->length) {
                $arr->splice(1, 1);
            }
            $results->push($kValue);

            return false;
        });

        // find() visits the now-missing index 2 and passes undefined (here: null)
        self::assertSame(3, $results->length, 'predicate called three times');
        self::assertSame('Shoes', $results[0], 'The value of $results[0] is expected to be "Shoes"');
        self::assertSame('Bike', $results[1], 'The value of $results[1] is expected to be "Bike"');
        self::assertNull($results[2], 'The value of $results[2] is expected to be null');

        $results = new Arr();
        $arr = new Arr('Skateboard', 'Barefoot');
        $arr->find(static function ($kValue) use ($arr, $results) {
            if (0 === $results->length) {
                $arr->push('Motorcycle');
                $arr[1] = 'Magic Carpet';
            }

            $results->push($kValue);

            return false;
        });

        self::assertSame(2, $results->length, 'predicate called twice');
        self::assertSame('Skateboard', $results[0], 'The value of $results[0] is expected to be "Skateboard"');
        self::assertSame('Magic Carpet', $results[1], 'The value of $results[1] is expected to be "Magic Carpet"');
    }

    // SKIPPED: test/built-ins/Array/prototype/find/call-with-boolean.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/callbackfn-resize-arraybuffer.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/length.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/name.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/not-a-constructor.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/find/predicate-call-parameters.js.
     */
    public function testPredicateCallParameters(): void
    {
        $arr = new Arr('Mike', 'Rick', 'Leo');

        $results = [];

        $arr->find(static function (...$args) use (&$results) {
            $results[] = $args;

            return false;
        });

        self::assertCount(3, $results, 'The value of $results length is expected to be 3');

        $result = $results[0];
        self::assertSame('Mike', $result[0], 'The value of $result[0] is expected to be "Mike"');
        self::assertSame(0, $result[1], 'The value of $result[1] is expected to be 0');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');

        $result = $results[1];
        self::assertSame('Rick', $result[0], 'The value of $result[0] is expected to be "Rick"');
        self::assertSame(1, $result[1], 'The value of $result[1] is expected to be 1');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');

        $result = $results[2];
        self::assertSame('Leo', $result[0], 'The value of $result[0] is expected to be "Leo"');
        self::assertSame(2, $result[1], 'The value of $result[1] is expected to be 2');
        self::assertSame($arr, $result[2], 'The value of $result[2] is expected to equal the value of `arr`');
        self::assertCount(3, $result, 'The value of $result length is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/find/predicate-call-this-non-strict.js.
     */
    public function testPredicateCallThisNonStrict(): void
    {
        Arr::of(1)->find(function () use (&$result) {
            $result = $this;

            return false;
        });

        self::assertSame($this, $result, 'The value of $result is expected to be this');

        $o = new \stdClass();
        Arr::of(1)->find(function () use (&$result) {
            $result = $this;

            return false;
        }, $o);

        self::assertSame($o, $result, 'The value of $result is expected to be o');
    }

    // SKIPPED: test/built-ins/Array/prototype/find/predicate-call-this-strict.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/find/predicate-called-for-each-array-property.js.
     */
    public function testPredicateCalledForEachArrayProperty(): void
    {
        $arr = new Arr(4);
        $arr[0] = null;
        $arr[3] = 'foo';
        $called = 0;

        $arr->find(static function () use (&$called) {
            ++$called;

            return false;
        });

        // find() visits holes and passes undefined (here: null), so all 4
        // indexes are visited
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/find/predicate-is-not-callable-throws.js.
     */
    public function testPredicateIsNotCallableThrows(): void
    {
        foreach ([new \stdClass(), null, true, 1, '', [], new Arr()] as $nonCallable) {
            try {
                (new Arr())->find($nonCallable);

                throw new \Exception('Should not be reached');
            } catch (\TypeError $e) {
                self::addToAssertionCount(1);
            }
        }
    }

    /**
     * test/built-ins/Array/prototype/find/predicate-not-called-on-empty-array.js.
     */
    public function testPredicateNotCalledOnEmptyArray(): void
    {
        $called = false;

        $predicate = static function () use (&$called) {
            $called = true;

            return true;
        };

        $result = (new Arr())->find($predicate);

        self::assertFalse($called, '[].find(predicate) does not call predicate');
        self::assertNull($result, '[].find(predicate) returned null');
    }

    // SKIPPED: test/built-ins/Array/prototype/find/prop-desc.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/resizable-buffer-grow-mid-iteration.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/resizable-buffer-shrink-mid-iteration.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/resizable-buffer.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/find/return-abrupt-from-predicate-call.js.
     */
    public function testReturnAbruptFromPredicateCall(): void
    {
        $exception = new \Exception();

        $predicate = static function () use ($exception): never {
            throw $exception;
        };

        try {
            Arr::of(1)->find($predicate);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/find/return-abrupt-from-property.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/return-abrupt-from-this-length-as-symbol.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/return-abrupt-from-this-length.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    // SKIPPED: test/built-ins/Array/prototype/find/return-abrupt-from-this.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/find/return-found-value-predicate-result-is-true.js.
     */
    public function testReturnFoundValuePredicateResultIsTrue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->find(static function () use (&$called) {
            ++$called;

            return true;
        });

        self::assertSame('Shoes', $result, 'The value of $result is expected to be "Shoes"');
        self::assertSame(1, $called, 'predicate was called once');

        $called = 0;
        $result = $arr->find(static function ($val) use (&$called) {
            ++$called;

            return 'Bike' === $val;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertSame('Bike', $result, 'The value of $result is expected to be "Bike"');

        $result = $arr->find(static fn () => 'string');
        self::assertSame('Shoes', $result, 'coerced string');

        $result = $arr->find(static fn () => new \stdClass());
        self::assertSame('Shoes', $result, 'coerced object');

        // Symbol('') has no PHP equivalent; the truthy-object case above covers it.

        $result = $arr->find(static fn () => 1);
        self::assertSame('Shoes', $result, 'coerced number');

        $result = $arr->find(static fn () => -1);
        self::assertSame('Shoes', $result, 'coerced negative number');
    }

    /**
     * test/built-ins/Array/prototype/find/return-undefined-if-predicate-returns-false-value.js.
     */
    public function testReturnUndefinedIfPredicateReturnsFalseValue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->find(static function () use (&$called) {
            ++$called;

            return false;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertNull($result, 'The value of $result is expected to be null');

        $result = $arr->find(static fn () => '');
        self::assertNull($result, 'coerced string');

        $result = $arr->find(static fn () => null);
        self::assertNull($result, 'coerced undefined');

        $result = $arr->find(static fn () => null);
        self::assertNull($result, 'coerced null');

        $result = $arr->find(static fn () => 0);
        self::assertNull($result, 'coerced 0');

        // The `return NaN` sub-check is not portable: PHP coerces NAN to true
        // (with a warning), unlike JS where NaN is falsy.
    }
}
