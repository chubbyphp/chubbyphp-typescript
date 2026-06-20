<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.toSpliced tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeToSplicedTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/toSpliced/deleteCount-clamped-between-zero-and-remaining-count.js.
     */
    public function testDeleteCountClampedBetweenZeroAndRemainingCount(): void
    {
        self::assertSame(
            [0, 1, 2, 3, 4, 5],
            (new Arr(0, 1, 2, 3, 4, 5))->toSpliced(2, -1)->toArray(),
            'toSpliced(2, -1) must return [0, 1, 2, 3, 4, 5]'
        );

        self::assertSame(
            [0, 1, 2, 3, 4, 5],
            (new Arr(0, 1, 2, 3, 4, 5))->toSpliced(-4, -1)->toArray(),
            'toSpliced(-4, -1) must return [0, 1, 2, 3, 4, 5]'
        );

        self::assertSame(
            [0, 1],
            (new Arr(0, 1, 2, 3, 4, 5))->toSpliced(2, 6)->toArray(),
            'toSpliced(2, 6) must return [0, 1]'
        );

        self::assertSame(
            [0, 1],
            (new Arr(0, 1, 2, 3, 4, 5))->toSpliced(-4, 6)->toArray(),
            'toSpliced(-4, 6) must return [0, 1]'
        );
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/deleteCount-missing.js.
     */
    public function testDeleteCountMissing(): void
    {
        $result = (new Arr('first', 'second', 'third'))->toSpliced(1);

        self::assertSame(['first'], $result->toArray(), 'toSpliced(1) must return ["first"]');
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/deleteCount-undefined.js.
     */
    public function testDeleteCountUndefined(): void
    {
        // JS: toSpliced(1, undefined); undefined deleteCount coerces to 0
        // -> explicit null deleteCount in Arr.
        $result = (new Arr('first', 'second', 'third'))->toSpliced(1, null);

        self::assertSame(
            ['first', 'second', 'third'],
            $result->toArray(),
            'toSpliced(1, null) must return ["first", "second", "third"]'
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/discarded-element-not-read.js
    // Reason: array-like object with accessor properties

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/elements-read-in-order.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/frozen-this-value.js
    // Reason: frozen objects / array-like this

    /**
     * test/built-ins/Array/prototype/toSpliced/holes-not-preserved.js.
     */
    public function testHolesNotPreserved(): void
    {
        // toSpliced converts holes to undefined (here: null) own properties in
        // the result, so the result is always dense. The Array.prototype[3] = 3
        // part of the JS test has no PHP equivalent, so the hole at index 3
        // reads back as null instead of 3.
        $arr = new Arr(5);
        $arr[0] = 0;
        $arr[2] = 2;
        $arr[4] = 4;

        $spliced = $arr->toSpliced(0, 0);
        self::assertSame(
            [0, null, 2, null, 4],
            $spliced->toArray(),
            'toSpliced(0, 0) must return [0, null, 2, null, 4]'
        );
        self::assertTrue(isset($spliced[1]), 'hole at index 1 is materialized as own null property');
        self::assertTrue(isset($spliced[3]), 'hole at index 3 is materialized as own null property');

        $spliced = $arr->toSpliced(0, 0, -1);
        self::assertSame(
            [-1, 0, null, 2, null, 4],
            $spliced->toArray(),
            'toSpliced(0, 0, -1) must return [-1, 0, null, 2, null, 4]'
        );
        self::assertTrue(isset($spliced[2]), 'hole at index 2 is materialized as own null property');
        self::assertTrue(isset($spliced[4]), 'hole at index 4 is materialized as own null property');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/ignores-species.js
    // Reason: @@species

    /**
     * test/built-ins/Array/prototype/toSpliced/immutable.js.
     */
    public function testImmutable(): void
    {
        $arr = new Arr(2, 0, 1);
        $arr->toSpliced(0, 0, -1);

        self::assertSame([2, 0, 1], $arr->toArray(), 'The value of $arr is expected to be [2, 0, 1]');
        self::assertNotSame($arr, $arr->toSpliced(0, 0, -1), 'toSpliced(0, 0, -1) must not return the original array');
        self::assertNotSame($arr, $arr->toSpliced(0, 1, -1), 'toSpliced(0, 1, -1) must not return the original array');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-casted-to-zero.js
    // Reason: toSpliced applied to array-like objects with invalid length

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-clamped-to-2pow53minus1.js
    // Reason: array-like objects with length beyond 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-decreased-while-iterating.js
    // Reason: accessor properties on indexes / Array.prototype manipulation

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-exceeding-array-length-limit.js
    // Reason: array-like objects with length beyond 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-increased-while-iterating.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length-tolength.js
    // Reason: array-like objects with length coercion

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/length.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/mutate-while-iterating.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/name.js
    // Reason: start given as -Infinity; Arr::toSpliced() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/not-a-constructor.js
    // Reason: start given as -Infinity; Arr::toSpliced() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/property-descriptor.js
    // Reason: start given as -Infinity; Arr::toSpliced() start is typed int

    /**
     * test/built-ins/Array/prototype/toSpliced/start-and-deleteCount-missing.js.
     */
    public function testStartAndDeleteCountMissing(): void
    {
        // JS: arr.toSpliced(); start is required in Arr. With zero arguments
        // JS uses actualStart = 0 and actualDeleteCount = 0, which maps to
        // toSpliced(0, null) (explicit null deleteCount means 0).
        $arr = new Arr('first', 'second', 'third');
        $result = $arr->toSpliced(0, null);

        self::assertSame($arr->toArray(), $result->toArray(), 'The result is expected to equal the original array');
        self::assertNotSame($arr, $result, 'The result must not be the original array');
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/start-and-deleteCount-undefineds.js.
     */
    public function testStartAndDeleteCountUndefineds(): void
    {
        // JS: arr.toSpliced(undefined, undefined); undefined start coerces to 0,
        // undefined deleteCount coerces to 0 -> explicit null deleteCount in Arr.
        $arr = new Arr('first', 'second', 'third');
        $result = $arr->toSpliced(0, null);

        self::assertSame($arr->toArray(), $result->toArray(), 'The result is expected to equal the original array');
        self::assertNotSame($arr, $result, 'The result must not be the original array');
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/start-bigger-than-length.js.
     */
    public function testStartBiggerThanLength(): void
    {
        $result = (new Arr(0, 1, 2, 3, 4))->toSpliced(10, 1, 5, 6);

        self::assertSame(
            [0, 1, 2, 3, 4, 5, 6],
            $result->toArray(),
            'toSpliced(10, 1, 5, 6) must return [0, 1, 2, 3, 4, 5, 6]'
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/start-neg-infinity-is-zero.js
    // Reason: start given as -Infinity; Arr::toSpliced() start is typed int

    /**
     * test/built-ins/Array/prototype/toSpliced/start-neg-less-than-minus-length-is-zero.js.
     */
    public function testStartNegLessThanMinusLengthIsZero(): void
    {
        $result = (new Arr(0, 1, 2, 3, 4))->toSpliced(-20, 2);

        self::assertSame([2, 3, 4], $result->toArray(), 'toSpliced(-20, 2) must return [2, 3, 4]');
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/start-neg-subtracted-from-length.js.
     */
    public function testStartNegSubtractedFromLength(): void
    {
        $result = (new Arr(0, 1, 2, 3, 4))->toSpliced(-3, 2);

        self::assertSame([0, 1, 4], $result->toArray(), 'toSpliced(-3, 2) must return [0, 1, 4]');
    }

    /**
     * test/built-ins/Array/prototype/toSpliced/start-undefined-and-deleteCount-missing.js.
     */
    public function testStartUndefinedAndDeleteCountMissing(): void
    {
        // JS: arr.toSpliced(undefined); undefined start coerces to 0, missing
        // deleteCount defaults to len - start -> single-argument toSpliced(0).
        $result = (new Arr('first', 'second', 'third'))->toSpliced(0);

        self::assertSame([], $result->toArray(), 'toSpliced(0) must return []');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/this-value-boolean.js
    // Reason: toSpliced applied to boolean primitives / Boolean.prototype manipulation

    // SKIPPED: test/built-ins/Array/prototype/toSpliced/this-value-nullish.js
    // Reason: toSpliced applied to null/undefined this (ToObject coercion)

    /**
     * test/built-ins/Array/prototype/toSpliced/unmodified.js.
     */
    public function testUnmodified(): void
    {
        $arr = new Arr(1, 2, 3);
        $spliced = $arr->toSpliced(1, 0);

        self::assertNotSame($arr, $spliced, 'The spliced array must not be the original array');
        self::assertSame($arr->toArray(), $spliced->toArray(), 'The spliced array is expected to equal the original array');
    }
}
