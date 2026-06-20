<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.toReversed tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeToReversedTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/toReversed/frozen-this-value.js
    // Reason: Object.freeze and array-like this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/get-descending-order.js
    // Reason: accessor properties on indexes

    /**
     * test/built-ins/Array/prototype/toReversed/holes-not-preserved.js.
     *
     * Adapted (the Array.prototype[3] = 3 inheritance part is JS-only):
     * toReversed() does NOT preserve holes - they become own `undefined`
     * (here: null) properties, so the result is always dense.
     */
    public function testHolesNotPreserved(): void
    {
        $arr = new Arr(5);
        $arr[0] = 0;
        $arr[2] = 2;
        $arr[4] = 4;

        $reversed = $arr->toReversed();
        self::assertSame(5, $reversed->length, 'The value of $reversed->length is expected to be 5');
        self::assertSame([4, null, 2, null, 0], $reversed->toArray(), '$reversed is expected to be [4, null, 2, null, 0]');
        self::assertTrue($reversed->offsetExists(1), '$reversed->offsetExists(1) is expected to be true (own null property, like JS own undefined)');
        self::assertTrue($reversed->offsetExists(3), '$reversed->offsetExists(3) is expected to be true (own null property, like JS own undefined)');
    }

    // SKIPPED: test/built-ins/Array/prototype/toReversed/ignores-species.js
    // Reason: @@species

    /**
     * test/built-ins/Array/prototype/toReversed/immutable.js.
     */
    public function testImmutable(): void
    {
        $arr = new Arr(0, 1, 2);
        $arr->toReversed();

        self::assertSame([0, 1, 2], $arr->toArray(), '$arr is expected to be [0, 1, 2]');
        self::assertNotSame($arr, $arr->toReversed(), '$arr->toReversed() is expected to not be $arr');
    }

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length-casted-to-zero.js
    // Reason: array-like this value with non-integer length coercion

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length-decreased-while-iterating.js
    // Reason: accessor property on an index and Array.prototype inheritance

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length-exceeding-array-length-limit.js
    // Reason: array-like this value with length 2^32; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length-increased-while-iterating.js
    // Reason: accessor property on an index

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length-tolength.js
    // Reason: array-like this value with length coercion via valueOf

    // SKIPPED: test/built-ins/Array/prototype/toReversed/length.js
    // Reason: toReversed applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/name.js
    // Reason: toReversed applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/not-a-constructor.js
    // Reason: toReversed applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/property-descriptor.js
    // Reason: toReversed applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/this-value-boolean.js
    // Reason: toReversed applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/toReversed/this-value-nullish.js
    // Reason: toReversed applied to null/undefined this value

    /**
     * test/built-ins/Array/prototype/toReversed/zero-or-one-element.js.
     */
    public function testZeroOrOneElement(): void
    {
        $zero = new Arr();
        $zeroReversed = $zero->toReversed();
        self::assertNotSame($zero, $zeroReversed, '$zeroReversed is expected to not be $zero');
        self::assertSame($zero->toArray(), $zeroReversed->toArray(), '$zeroReversed is expected to equal $zero');

        $one = new Arr(1);
        $one[0] = 1;
        $oneReversed = $one->toReversed();
        self::assertNotSame($one, $oneReversed, '$oneReversed is expected to not be $one');
        self::assertSame($one->toArray(), $oneReversed->toArray(), '$oneReversed is expected to equal $one');
    }
}
