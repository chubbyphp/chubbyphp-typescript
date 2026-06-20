<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.toSorted tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeToSortedTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/toSorted/comparefn-called-after-get-elements.js
    // Reason: toSorted called generically on an array-like object with index getters

    /**
     * test/built-ins/Array/prototype/toSorted/comparefn-controls-sort.js.
     */
    public function testComparefnControlsSort(): void
    {
        $numericCompare = static fn (int $a, int $b): int => $a <=> $b;

        self::assertSame([1, 2, 3, 4], (new Arr(1, 2, 3, 4))->toSorted($numericCompare)->toArray(), 'The value of (new Arr(1, 2, 3, 4))->toSorted($numericCompare) is expected to be [1, 2, 3, 4]');
        self::assertSame([1, 2, 3, 4], (new Arr(4, 3, 2, 1))->toSorted($numericCompare)->toArray(), 'The value of (new Arr(4, 3, 2, 1))->toSorted($numericCompare) is expected to be [1, 2, 3, 4]');
        self::assertSame(
            [1, 2, 3, 11, 22, 33, 111, 222, 333],
            (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted($numericCompare)->toArray(),
            'The value of (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted($numericCompare) is expected to be [1, 2, 3, 11, 22, 33, 111, 222, 333]'
        );

        $reverseNumericCompare = static fn (int $a, int $b): int => $b <=> $a;

        self::assertSame([4, 3, 2, 1], (new Arr(1, 2, 3, 4))->toSorted($reverseNumericCompare)->toArray(), 'The value of (new Arr(1, 2, 3, 4))->toSorted($reverseNumericCompare) is expected to be [4, 3, 2, 1]');
        self::assertSame([4, 3, 2, 1], (new Arr(4, 3, 2, 1))->toSorted($reverseNumericCompare)->toArray(), 'The value of (new Arr(4, 3, 2, 1))->toSorted($reverseNumericCompare) is expected to be [4, 3, 2, 1]');
        self::assertSame(
            [333, 222, 111, 33, 22, 11, 3, 2, 1],
            (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted($reverseNumericCompare)->toArray(),
            'The value of (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted($reverseNumericCompare) is expected to be [333, 222, 111, 33, 22, 11, 3, 2, 1]'
        );
    }

    /**
     * test/built-ins/Array/prototype/toSorted/comparefn-default.js.
     */
    public function testComparefnDefault(): void
    {
        self::assertSame([1, 2, 3, 4], (new Arr(1, 2, 3, 4))->toSorted()->toArray(), 'The value of (new Arr(1, 2, 3, 4))->toSorted() is expected to be [1, 2, 3, 4]');
        self::assertSame([1, 2, 3, 4], (new Arr(4, 3, 2, 1))->toSorted()->toArray(), 'The value of (new Arr(4, 3, 2, 1))->toSorted() is expected to be [1, 2, 3, 4]');
        self::assertSame([1, 2, 'a', 'z'], (new Arr('a', 2, 1, 'z'))->toSorted()->toArray(), 'The value of (new Arr("a", 2, 1, "z"))->toSorted() is expected to be [1, 2, "a", "z"]');

        self::assertSame(
            [1, 11, 111, 2, 22, 222, 3, 33, 333],
            (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted()->toArray(),
            'The value of (new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted() is expected to be [1, 11, 111, 2, 22, 222, 3, 33, 333]'
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/toSorted/comparefn-not-a-function.js
    // Reason: comparefn given as non-callable; Arr::toSorted() is typed ?callable

    /**
     * test/built-ins/Array/prototype/toSorted/comparefn-stop-after-error.js.
     */
    public function testComparefnStopAfterError(): void
    {
        // The array-like part of the original test is not portable; only the
        // array part is ported here.
        $exception = new \Exception();
        $called = 0;

        try {
            (new Arr(1, 2, 3))->toSorted(static function () use (&$called, $exception): int {
                ++$called;

                if (1 === $called) {
                    throw $exception;
                }

                return 0;
            });

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e, 'toSorted is expected to rethrow the comparefn exception');
        }

        self::assertSame(1, $called, 'The value of $called is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSorted/frozen-this-value.js
    // Reason: Object.freeze and array-like objects

    /**
     * test/built-ins/Array/prototype/toSorted/holes-not-preserved.js.
     */
    public function testHolesNotPreserved(): void
    {
        // Adapted: the Array.prototype[3] = 2 part is not portable. The holes
        // become explicit own `undefined` (here: null) properties sorted to
        // the end, so the result is always dense.
        $arr = new Arr(5);
        $arr[0] = 3;
        $arr[2] = 4;
        $arr[4] = 1;

        $sorted = $arr->toSorted();

        self::assertSame(5, $sorted->length, 'The value of $sorted->length is expected to be 5');
        self::assertSame(1, $sorted[0], 'The value of $sorted[0] is expected to be 1');
        self::assertSame(3, $sorted[1], 'The value of $sorted[1] is expected to be 3');
        self::assertSame(4, $sorted[2], 'The value of $sorted[2] is expected to be 4');
        self::assertNull($sorted[3], 'The value of $sorted[3] is expected to be null');
        self::assertNull($sorted[4], 'The value of $sorted[4] is expected to be null');

        self::assertTrue(isset($sorted[3]), 'isset($sorted[3]) is expected to be true (own null property, like JS own undefined)');
        self::assertTrue(isset($sorted[4]), 'isset($sorted[4]) is expected to be true (own null property, like JS own undefined)');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSorted/ignores-species.js
    // Reason: toSorted called generically on array-like objects with invalid lengths

    /**
     * test/built-ins/Array/prototype/toSorted/immutable.js.
     */
    public function testImmutable(): void
    {
        $arr = new Arr(2, 0, 1);
        $arr->toSorted();

        self::assertSame([2, 0, 1], $arr->toArray(), 'The value of $arr is expected to be [2, 0, 1]');
        self::assertNotSame($arr, $arr->toSorted(), 'The value of $arr->toSorted() is expected to not equal the value of `$arr`');
    }

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length-casted-to-zero.js
    // Reason: toSorted called generically on array-like objects with invalid lengths

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length-decreased-while-iterating.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length-exceeding-array-length-limit.js
    // Reason: array-like objects with length > 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length-increased-while-iterating.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length-tolength.js
    // Reason: length coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/toSorted/length.js
    // Reason: ToObject coercion of boolean this values

    // SKIPPED: test/built-ins/Array/prototype/toSorted/name.js
    // Reason: ToObject coercion of boolean this values

    // SKIPPED: test/built-ins/Array/prototype/toSorted/not-a-constructor.js
    // Reason: ToObject coercion of boolean this values

    // SKIPPED: test/built-ins/Array/prototype/toSorted/property-descriptor.js
    // Reason: ToObject coercion of boolean this values

    // SKIPPED: test/built-ins/Array/prototype/toSorted/this-value-boolean.js
    // Reason: ToObject coercion of boolean this values

    // SKIPPED: test/built-ins/Array/prototype/toSorted/this-value-nullish.js
    // Reason: ToObject coercion of null/undefined this values

    /**
     * test/built-ins/Array/prototype/toSorted/zero-or-one-element.js.
     */
    public function testZeroOrOneElement(): void
    {
        $zero = new Arr();
        $zeroSorted = $zero->toSorted();
        self::assertNotSame($zero, $zeroSorted, 'The value of $zeroSorted is expected to not equal the value of `$zero`');
        self::assertSame($zero->toArray(), $zeroSorted->toArray(), 'The value of $zeroSorted is expected to equal the value of $zero');

        $one = new Arr(1);
        $oneSorted = $one->toSorted();
        self::assertNotSame($one, $oneSorted, 'The value of $oneSorted is expected to not equal the value of `$one`');
        self::assertSame($one->toArray(), $oneSorted->toArray(), 'The value of $oneSorted is expected to equal the value of $one');
    }
}
