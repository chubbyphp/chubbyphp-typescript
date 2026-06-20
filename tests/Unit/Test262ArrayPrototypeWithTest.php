<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.with tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeWithTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/with/frozen-this-value.js
    // Reason: index coercion of float/string/NaN; Arr::with() is typed int

    /**
     * test/built-ins/Array/prototype/with/holes-not-preserved.js.
     */
    public function testHolesNotPreserved(): void
    {
        // The JS test sets Array.prototype[3] = 3 so the hole at index 3 reads the
        // inherited value; prototype-chain behavior is not portable, so index 3
        // reads back as null here instead of 3.
        $arr = new Arr(5);
        $arr[0] = 0;
        $arr[2] = 2;
        $arr[4] = 4;

        $result = $arr->with(2, 6);

        self::assertSame([0, null, 6, null, 4], $result->toArray(), '[0, /* hole */, 2, /* hole */, 4].with(2, 6) must return [0, undefined, 6, undefined, 4]');
        self::assertTrue(isset($result[1]), '$result->offsetExists(1) is expected to be true');
        self::assertTrue(isset($result[3]), '$result->offsetExists(3) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/with/ignores-species.js
    // Reason: index coercion of float/string/NaN; Arr::with() is typed int

    /**
     * test/built-ins/Array/prototype/with/immutable.js.
     */
    public function testImmutable(): void
    {
        $arr = new Arr(0, 1, 2);
        $arr->with(1, 3);

        self::assertSame([0, 1, 2], $arr->toArray(), 'The value of $arr is expected to be [0, 1, 2]');
        self::assertNotSame($arr, $arr->with(1, 3), '$arr->with(1, 3) is expected to not equal the value of $arr');
        self::assertNotSame($arr, $arr->with(1, 1), '$arr->with(1, 1) is expected to not equal the value of $arr');
    }

    /**
     * test/built-ins/Array/prototype/with/index-bigger-or-eq-than-length.js.
     */
    public function testIndexBiggerOrEqThanLength(): void
    {
        // The Infinity index assertion is not portable: Arr::with() is typed int.
        foreach ([3, 10, 2 ** 53 + 2] as $index) {
            $thrown = false;

            try {
                (new Arr(0, 1, 2))->with($index, 7);
            } catch (RangeError) {
                $thrown = true;
            }

            self::assertTrue($thrown, \sprintf('[0, 1, 2].with(%d, 7) must throw a RangeError', $index));
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/with/index-casted-to-number.js
    // Reason: index coercion of float/string/NaN; Arr::with() is typed int

    /**
     * test/built-ins/Array/prototype/with/index-negative.js.
     */
    public function testIndexNegative(): void
    {
        $arr = new Arr(0, 1, 2);

        self::assertSame([0, 1, 4], $arr->with(-1, 4)->toArray(), '[0, 1, 2].with(-1, 4) must return [0, 1, 4]');
        self::assertSame([4, 1, 2], $arr->with(-3, 4)->toArray(), '[0, 1, 2].with(-3, 4) must return [4, 1, 2]');

        // -0 is not < 0 (PHP int -0 is 0)
        self::assertSame([4, 1, 2], $arr->with(-0, 4)->toArray(), '[0, 1, 2].with(-0, 4) must return [4, 1, 2]');
    }

    /**
     * test/built-ins/Array/prototype/with/index-smaller-than-minus-length.js.
     */
    public function testIndexSmallerThanMinusLength(): void
    {
        // The -Infinity index assertion is not portable: Arr::with() is typed int.
        self::assertSame([7, 1, 2], (new Arr(0, 1, 2))->with(-3, 7)->toArray(), '[0, 1, 2].with(-3, 7) must not throw');

        foreach ([-4, -10, -(2 ** 53) - 2] as $index) {
            $thrown = false;

            try {
                (new Arr(0, 1, 2))->with($index, 7);
            } catch (RangeError) {
                $thrown = true;
            }

            self::assertTrue($thrown, \sprintf('[0, 1, 2].with(%d, 7) must throw a RangeError', $index));
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/with/index-throw-completion.js
    // Reason: index coercion via valueOf; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/length-decreased-while-iterating.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/length-exceeding-array-length-limit.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/length-increased-while-iterating.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/length-tolength.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/length.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/name.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/negative-fractional-index-truncated-to-zero.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/no-get-replaced-index.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/not-a-constructor.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/property-descriptor.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/this-value-boolean.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int

    // SKIPPED: test/built-ins/Array/prototype/with/this-value-nullish.js
    // Reason: fractional index (-0.5) truncation; Arr::with() is typed int
}
