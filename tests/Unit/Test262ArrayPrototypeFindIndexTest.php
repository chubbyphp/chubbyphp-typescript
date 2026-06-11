<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.findIndex tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFindIndexTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/findIndex/array-altered-during-loop.js.
     */
    public function testArrayAlteredDuringLoop(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $results = new Arr();

        $arr->findIndex(static function ($kValue) use ($arr, $results) {
            if (0 === $results->length) {
                $arr->splice(1, 1);
            }
            $results->push($kValue);

            return false;
        });

        // Arr deviation: JS visits the now-missing index 2 and passes undefined,
        // Arr skips missing indexes entirely, so the predicate is called twice.
        self::assertSame(2, $results->length, 'predicate called twice');
        self::assertSame('Shoes', $results[0], 'The value of $results[0] is expected to be "Shoes"');
        self::assertSame('Bike', $results[1], 'The value of $results[1] is expected to be "Bike"');

        $results = new Arr();
        $arr = new Arr('Skateboard', 'Barefoot');
        $arr->findIndex(static function ($kValue) use ($arr, $results) {
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

    // SKIPPED: test/built-ins/Array/prototype/findIndex/call-with-boolean.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/callbackfn-resize-arraybuffer.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/length.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/name.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/not-a-constructor.js

    /**
     * test/built-ins/Array/prototype/findIndex/predicate-call-parameters.js.
     */
    public function testPredicateCallParameters(): void
    {
        $arr = new Arr('Mike', 'Rick', 'Leo');

        $results = [];

        $arr->findIndex(static function (...$args) use (&$results) {
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
     * test/built-ins/Array/prototype/findIndex/predicate-call-this-non-strict.js.
     */
    public function testPredicateCallThisNonStrict(): void
    {
        $result = null;

        Arr::of(1)->findIndex(function () use (&$result) {
            $result = $this;

            return false;
        });

        self::assertSame($this, $result, 'The value of $result is expected to be this');

        $o = new \stdClass();
        Arr::of(1)->findIndex(function () use (&$result) {
            $result = $this;

            return false;
        }, $o);

        self::assertSame($o, $result, 'The value of $result is expected to be o');
    }

    // SKIPPED: test/built-ins/Array/prototype/findIndex/predicate-call-this-strict.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP closures

    /**
     * test/built-ins/Array/prototype/findIndex/predicate-called-for-each-array-property.js.
     */
    public function testPredicateCalledForEachArrayProperty(): void
    {
        $arr = new Arr(4);
        $arr[0] = null;
        $arr[3] = 'foo';
        $called = 0;

        $arr->findIndex(static function () use (&$called) {
            ++$called;

            return false;
        });

        // Arr deviation: JS visits holes and passes undefined (4 calls),
        // Arr skips holes via array_key_exists, so only indexes 0 and 3 are visited.
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/findIndex/predicate-is-not-callable-throws.js.
     */
    public function testPredicateIsNotCallableThrows(): void
    {
        foreach ([new \stdClass(), null, true, 1, '', [], new Arr()] as $nonCallable) {
            try {
                (new Arr())->findIndex($nonCallable);

                throw new \Exception('Should not be reached');
            } catch (\TypeError $e) {
                self::addToAssertionCount(1);
            }
        }
    }

    /**
     * test/built-ins/Array/prototype/findIndex/predicate-not-called-on-empty-array.js.
     */
    public function testPredicateNotCalledOnEmptyArray(): void
    {
        $called = false;

        $predicate = static function () use (&$called) {
            $called = true;

            return true;
        };

        $result = (new Arr())->findIndex($predicate);

        self::assertFalse($called, '[].findIndex(predicate) does not call predicate');
        self::assertSame(-1, $result, '[].findIndex(predicate) returned -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/findIndex/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/resizable-buffer-grow-mid-iteration.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/resizable-buffer-shrink-mid-iteration.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/resizable-buffer.js

    /**
     * test/built-ins/Array/prototype/findIndex/return-abrupt-from-predicate-call.js.
     */
    public function testReturnAbruptFromPredicateCall(): void
    {
        $exception = new \Exception();

        $predicate = static function () use ($exception): never {
            throw $exception;
        };

        try {
            Arr::of(1)->findIndex($predicate);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/findIndex/return-abrupt-from-property.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/return-abrupt-from-this-length-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/return-abrupt-from-this-length.js

    // SKIPPED: test/built-ins/Array/prototype/findIndex/return-abrupt-from-this.js

    /**
     * test/built-ins/Array/prototype/findIndex/return-index-predicate-result-is-true.js.
     */
    public function testReturnIndexPredicateResultIsTrue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->findIndex(static function () use (&$called) {
            ++$called;

            return true;
        });

        self::assertSame(0, $result, 'The value of $result is expected to be 0');
        self::assertSame(1, $called, 'predicate was called once');

        $called = 0;
        $result = $arr->findIndex(static function ($val) use (&$called) {
            ++$called;

            return 'Bike' === $val;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertSame(2, $result, 'The value of $result is expected to be 2');

        $result = $arr->findIndex(static fn () => 'string');
        self::assertSame(0, $result, 'coerced string');

        $result = $arr->findIndex(static fn () => new \stdClass());
        self::assertSame(0, $result, 'coerced object');

        // Symbol('') has no PHP equivalent; the truthy-object case above covers it.

        $result = $arr->findIndex(static fn () => 1);
        self::assertSame(0, $result, 'coerced number');

        $result = $arr->findIndex(static fn () => -1);
        self::assertSame(0, $result, 'coerced negative number');
    }

    /**
     * test/built-ins/Array/prototype/findIndex/return-negative-one-if-predicate-returns-false-value.js.
     */
    public function testReturnNegativeOneIfPredicateReturnsFalseValue(): void
    {
        $arr = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $arr->findIndex(static function () use (&$called) {
            ++$called;

            return false;
        });

        self::assertSame(3, $called, 'predicate was called three times');
        self::assertSame(-1, $result, 'The value of $result is expected to be -1');

        $result = $arr->findIndex(static fn () => '');
        self::assertSame(-1, $result, 'coerced string');

        $result = $arr->findIndex(static fn () => null);
        self::assertSame(-1, $result, 'coerced undefined');

        $result = $arr->findIndex(static fn () => null);
        self::assertSame(-1, $result, 'coerced null');

        $result = $arr->findIndex(static fn () => 0);
        self::assertSame(-1, $result, 'coerced 0');

        // The `return NaN` sub-check is not portable: PHP coerces NAN to true
        // (with a warning), unlike JS where NaN is falsy.
    }
}
