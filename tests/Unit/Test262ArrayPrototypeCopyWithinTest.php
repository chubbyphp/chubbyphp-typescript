<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.copyWithin tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeCopyWithinTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/copyWithin/call-with-boolean.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/coerced-values-end.js
    // Reason: end coercion of null/NaN/boolean/string/float; Arr::copyWithin() is typed ?int
    // and its null $end intentionally means "until length" (JS undefined), not 0 (JS null)

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/coerced-values-start-change-start.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/coerced-values-start-change-target.js

    /**
     * test/built-ins/Array/prototype/copyWithin/coerced-values-start.js.
     */
    public function testCoercedValuesStart(): void
    {
        // Only the `undefined` start assertion is portable: JS coerces `undefined` to 0,
        // mapped here to an explicit 0 because Arr::copyWithin() requires int $start.
        // The remaining coercion assertions are not portable due to strict int types.
        self::assertSame([0, 0, 1, 2], (new Arr(0, 1, 2, 3))->copyWithin(1, 0)->toArray(), '[0, 1, 2, 3].copyWithin(1, undefined) must return [0, 0, 1, 2]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/coerced-values-target.js.
     */
    public function testCoercedValuesTarget(): void
    {
        // Only the `undefined` target assertion is portable: JS coerces `undefined` to 0,
        // mapped here to an explicit 0 because Arr::copyWithin() requires int $target.
        // The remaining coercion assertions are not portable due to strict int types.
        self::assertSame([1, 2, 3, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1)->toArray(), '[0, 1, 2, 3].copyWithin(undefined, 1) must return [1, 2, 3, 3]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/fill-holes.js.
     */
    public function testFillHoles(): void
    {
        $arr = new Arr(5);
        $arr[0] = 0;
        $arr[1] = 1;
        $arr[4] = 1;

        $arr->copyWithin(0, 1, 4);

        self::assertSame(5, $arr->length, 'The value of $arr->length is expected to be 5');
        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(1, $arr[4], 'The value of $arr[4] is expected to be 1');
        self::assertFalse(isset($arr[1]), '$arr->offsetExists(1) is expected to be false');
        self::assertFalse(isset($arr[2]), '$arr->offsetExists(2) is expected to be false');
        self::assertFalse(isset($arr[3]), '$arr->offsetExists(3) is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/length-near-integer-limit.js
    // Reason: array-like with length near 2^53; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/length.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/name.js

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-end.js.
     */
    public function testNegativeEnd(): void
    {
        self::assertSame([1, 2, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1, -1)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1, -1) must return [1, 2, 2, 3]');

        self::assertSame([0, 1, 0, 1, 2], (new Arr(0, 1, 2, 3, 4))->copyWithin(2, 0, -1)->toArray(), '[0, 1, 2, 3, 4].copyWithin(2, 0, -1) must return [0, 1, 0, 1, 2]');

        self::assertSame([0, 2, 2, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(1, 2, -2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(1, 2, -2) must return [0, 2, 2, 3, 4]');

        self::assertSame([2, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, -2, -1)->toArray(), '[0, 1, 2, 3].copyWithin(0, -2, -1) must return [2, 1, 2, 3]');

        self::assertSame([0, 1, 3, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(2, -2, -1)->toArray(), '[0, 1, 2, 3, 4].copyWithin(2, -2, -1) must return [0, 1, 3, 3, 4]');

        self::assertSame([0, 2, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(-3, -2, -1)->toArray(), '[0, 1, 2, 3].copyWithin(-3, -2, -1) must return [0, 2, 2, 3]');

        self::assertSame([0, 1, 2, 2, 3], (new Arr(0, 1, 2, 3, 4))->copyWithin(-2, -3, -1)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-2, -3, -1) must return [0, 1, 2, 2, 3]');

        self::assertSame([3, 1, 2, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(-5, -2, -1)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-5, -2, -1) must return [3, 1, 2, 3, 4]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-out-of-bounds-end.js.
     */
    public function testNegativeOutOfBoundsEnd(): void
    {
        // The -Infinity end assertions are not portable: Arr::copyWithin() is typed ?int.
        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1, -10)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1, -10) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, -2, -10)->toArray(), '[0, 1, 2, 3].copyWithin(0, -2, -10) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, -9, -10)->toArray(), '[0, 1, 2, 3].copyWithin(0, -9, -10) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(-3, -2, -10)->toArray(), '[0, 1, 2, 3].copyWithin(-3, -2, -10) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(-7, -8, -9)->toArray(), '[0, 1, 2, 3].copyWithin(-7, -8, -9) must return [0, 1, 2, 3]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-out-of-bounds-start.js.
     */
    public function testNegativeOutOfBoundsStart(): void
    {
        // The -Infinity start assertions are not portable: Arr::copyWithin() is typed int.
        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, -10)->toArray(), '[0, 1, 2, 3].copyWithin(0, -10) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 0, 1, 2], (new Arr(0, 1, 2, 3, 4))->copyWithin(2, -10)->toArray(), '[0, 1, 2, 3, 4].copyWithin(2, -10) must return [0, 1, 0, 1, 2]');

        self::assertSame([0, 1, 2, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(10, -10)->toArray(), '[0, 1, 2, 3, 4].copyWithin(10, -10) must return [0, 1, 2, 3, 4]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(-9, -10)->toArray(), '[0, 1, 2, 3].copyWithin(-9, -10) must return [0, 1, 2, 3]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-out-of-bounds-target.js.
     */
    public function testNegativeOutOfBoundsTarget(): void
    {
        // The -Infinity target assertions are not portable: Arr::copyWithin() is typed int.
        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(-10, 0)->toArray(), '[0, 1, 2, 3].copyWithin(-10, 0) must return [0, 1, 2, 3]');

        self::assertSame([2, 3, 4, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(-10, 2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-10, 2) must return [2, 3, 4, 3, 4]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-start.js.
     */
    public function testNegativeStart(): void
    {
        self::assertSame([3, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, -1)->toArray(), '[0, 1, 2, 3].copyWithin(0, -1) must return [3, 1, 2, 3]');

        self::assertSame([0, 1, 3, 4, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(2, -2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(2, -2) must return [0, 1, 3, 4, 4]');

        self::assertSame([0, 3, 4, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(1, -2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(1, -2) must return [0, 3, 4, 3, 4]');

        self::assertSame([0, 1, 2, 2], (new Arr(0, 1, 2, 3))->copyWithin(-1, -2)->toArray(), '[0, 1, 2, 3].copyWithin(-1, -2) must return [0, 1, 2, 2]');

        self::assertSame([0, 1, 2, 2, 3], (new Arr(0, 1, 2, 3, 4))->copyWithin(-2, -3)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-2, -3) must return [0, 1, 2, 2, 3]');

        self::assertSame([3, 4, 2, 3, 4], (new Arr(0, 1, 2, 3, 4))->copyWithin(-5, -2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-5, -2) must return [3, 4, 2, 3, 4]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/negative-target.js.
     */
    public function testNegativeTarget(): void
    {
        self::assertSame([0, 1, 2, 0], (new Arr(0, 1, 2, 3))->copyWithin(-1, 0)->toArray(), '[0, 1, 2, 3].copyWithin(-1, 0) must return [0, 1, 2, 0]');

        self::assertSame([0, 1, 2, 2, 3], (new Arr(0, 1, 2, 3, 4))->copyWithin(-2, 2)->toArray(), '[0, 1, 2, 3, 4].copyWithin(-2, 2) must return [0, 1, 2, 2, 3]');

        self::assertSame([0, 1, 2, 2], (new Arr(0, 1, 2, 3))->copyWithin(-1, 2)->toArray(), '[0, 1, 2, 3].copyWithin(-1, 2) must return [0, 1, 2, 2]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/non-negative-out-of-bounds-end.js.
     */
    public function testNonNegativeOutOfBoundsEnd(): void
    {
        // The Infinity end assertions are not portable: Arr::copyWithin() is typed ?int.
        self::assertSame([1, 2, 3, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1, 6)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1, 6) must return [1, 2, 3, 3]');

        self::assertSame([0, 3, 4, 5, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 3, 6)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(1, 3, 6) must return [0, 3, 4, 5, 4, 5]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/non-negative-out-of-bounds-target-and-start.js.
     */
    public function testNonNegativeOutOfBoundsTargetAndStart(): void
    {
        // The Infinity target/start assertions are not portable: Arr::copyWithin() is typed int.
        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(6, 0)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(6, 0) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(7, 0)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(7, 0) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(6, 2)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(6, 2) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(7, 2)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(7, 2) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(0, 6)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(0, 6) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(0, 7)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(0, 7) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(2, 6)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(2, 6) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 7)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(1, 7) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(6, 6)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(6, 6) must return [0, 1, 2, 3, 4, 5]');

        self::assertSame([0, 1, 2, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(10, 10)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(10, 10) must return [0, 1, 2, 3, 4, 5]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/non-negative-target-and-start.js.
     */
    public function testNonNegativeTargetAndStart(): void
    {
        self::assertSame(['a', 'b', 'c', 'd', 'e', 'f'], (new Arr('a', 'b', 'c', 'd', 'e', 'f'))->copyWithin(0, 0)->toArray(), '["a", "b", "c", "d", "e", "f"].copyWithin(0, 0) must return ["a", "b", "c", "d", "e", "f"]');

        self::assertSame(['c', 'd', 'e', 'f', 'e', 'f'], (new Arr('a', 'b', 'c', 'd', 'e', 'f'))->copyWithin(0, 2)->toArray(), '["a", "b", "c", "d", "e", "f"].copyWithin(0, 2) must return ["c", "d", "e", "f", "e", "f"]');

        self::assertSame(['a', 'b', 'c', 'a', 'b', 'c'], (new Arr('a', 'b', 'c', 'd', 'e', 'f'))->copyWithin(3, 0)->toArray(), '["a", "b", "c", "d", "e", "f"].copyWithin(3, 0) must return ["a", "b", "c", "a", "b", "c"]');

        self::assertSame([0, 4, 5, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 4)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(1, 4) must return [0, 4, 5, 3, 4, 5]');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/non-negative-target-start-and-end.js.
     */
    public function testNonNegativeTargetStartAndEnd(): void
    {
        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 0, 0)->toArray(), '[0, 1, 2, 3].copyWithin(0, 0, 0) must return [0, 1, 2, 3]');

        self::assertSame([0, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 0, 2)->toArray(), '[0, 1, 2, 3].copyWithin(0, 0, 2) must return [0, 1, 2, 3]');

        self::assertSame([1, 1, 2, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1, 2)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1, 2) must return [1, 1, 2, 3]');

        self::assertSame([0, 0, 1, 3], (new Arr(0, 1, 2, 3))->copyWithin(1, 0, 2)->toArray(), '[0, 1, 2, 3].copyWithin(1, 0, 2) must return [0, 0, 1, 3]');

        self::assertSame([0, 3, 4, 3, 4, 5], (new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 3, 5)->toArray(), '[0, 1, 2, 3, 4, 5].copyWithin(1, 3, 5) must return [0, 3, 4, 3, 4, 5]');
    }

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/resizable-buffer.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-delete-proxy-target.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-delete-target.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-end-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-end.js
    // Reason: end coercion via valueOf; Arr::copyWithin() is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-get-start-value.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-has-start.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-set-target-value.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-start-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-start.js
    // Reason: start coercion via valueOf; Arr::copyWithin() is typed int

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-target-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-target.js
    // Reason: target coercion via valueOf; Arr::copyWithin() is typed int

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-this-length-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-this-length.js

    // SKIPPED: test/built-ins/Array/prototype/copyWithin/return-abrupt-from-this.js

    /**
     * test/built-ins/Array/prototype/copyWithin/return-this.js.
     */
    public function testReturnThis(): void
    {
        // The `Array.prototype.copyWithin.call({length: 0}, 0, 0)` portion is not portable (array-like this).
        $arr = new Arr();
        $result = $arr->copyWithin(0, 0);

        self::assertSame($arr, $result, 'The value of $result is expected to equal the value of $arr');
    }

    /**
     * test/built-ins/Array/prototype/copyWithin/undefined-end.js.
     */
    public function testUndefinedEnd(): void
    {
        self::assertSame([1, 2, 3, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1, null)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1, undefined) must return [1, 2, 3, 3]');

        self::assertSame([1, 2, 3, 3], (new Arr(0, 1, 2, 3))->copyWithin(0, 1)->toArray(), '[0, 1, 2, 3].copyWithin(0, 1) must return [1, 2, 3, 3]');
    }
}
