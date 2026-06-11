<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.fill tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFillTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/fill/call-with-boolean.js

    /**
     * test/built-ins/Array/prototype/fill/coerced-indexes.js.
     */
    public function testCoercedIndexes(): void
    {
        // Only the `undefined` start/end assertions are portable: JS `undefined` maps to
        // omitting the argument or passing null as $end. The remaining coercion assertions
        // (null/boolean/NaN/string/float start or end) are not portable because
        // Arr::fill() is typed (int $start, ?int $end). Note: JS `fill(1, 0, null)`
        // coerces null end to 0; Arr's null $end intentionally means "until length"
        // (JS `undefined`) instead.
        self::assertSame([1, 1], (new Arr(0, 0))->fill(1)->toArray(), '[0, 0].fill(1, undefined) must return [1, 1]');

        self::assertSame([1, 1], (new Arr(0, 0))->fill(1, 0)->toArray(), '[0, 0].fill(1, 0, undefined) must return [1, 1]');

        self::assertSame([1, 1], (new Arr(0, 0))->fill(1, 0, null)->toArray(), '[0, 0].fill(1, 0, undefined) must return [1, 1]');
    }

    /**
     * test/built-ins/Array/prototype/fill/fill-values-custom-start-and-end.js.
     */
    public function testFillValuesCustomStartAndEnd(): void
    {
        self::assertSame([0, 8, 0], (new Arr(0, 0, 0))->fill(8, 1, 2)->toArray(), '[0, 0, 0].fill(8, 1, 2) must return [0, 8, 0]');

        self::assertSame([0, 0, 8, 8, 0], (new Arr(0, 0, 0, 0, 0))->fill(8, -3, 4)->toArray(), '[0, 0, 0, 0, 0].fill(8, -3, 4) must return [0, 0, 8, 8, 0]');

        self::assertSame([0, 0, 0, 8, 0], (new Arr(0, 0, 0, 0, 0))->fill(8, -2, -1)->toArray(), '[0, 0, 0, 0, 0].fill(8, -2, -1) must return [0, 0, 0, 8, 0]');

        self::assertSame([0, 0, 0, 0, 0], (new Arr(0, 0, 0, 0, 0))->fill(8, -1, -3)->toArray(), '[0, 0, 0, 0, 0].fill(8, -1, -3) must return [0, 0, 0, 0, 0]');

        $sparse = new Arr(5);
        $sparse[4] = 0;
        $sparse->fill(8, 1, 3);

        self::assertSame([null, 8, 8, null, 0], $sparse->toArray(), '[, , , , 0].fill(8, 1, 3) must return [, 8, 8, , 0]');
        self::assertFalse(isset($sparse[0]), 'The hole at index 0 is expected to be preserved');
        self::assertTrue(isset($sparse[1]), 'Index 1 is expected to be filled');
        self::assertTrue(isset($sparse[2]), 'Index 2 is expected to be filled');
        self::assertFalse(isset($sparse[3]), 'The hole at index 3 is expected to be preserved');
        self::assertTrue(isset($sparse[4]), 'Index 4 is expected to keep its value');
    }

    /**
     * test/built-ins/Array/prototype/fill/fill-values-relative-end.js.
     */
    public function testFillValuesRelativeEnd(): void
    {
        self::assertSame([8, 0, 0], (new Arr(0, 0, 0))->fill(8, 0, 1)->toArray(), '[0, 0, 0].fill(8, 0, 1) must return [8, 0, 0]');

        self::assertSame([8, 8, 0], (new Arr(0, 0, 0))->fill(8, 0, -1)->toArray(), '[0, 0, 0].fill(8, 0, -1) must return [8, 8, 0]');

        self::assertSame([8, 8, 8], (new Arr(0, 0, 0))->fill(8, 0, 5)->toArray(), '[0, 0, 0].fill(8, 0, 5) must return [8, 8, 8]');
    }

    /**
     * test/built-ins/Array/prototype/fill/fill-values-relative-start.js.
     */
    public function testFillValuesRelativeStart(): void
    {
        self::assertSame([0, 8, 8], (new Arr(0, 0, 0))->fill(8, 1)->toArray(), '[0, 0, 0].fill(8, 1) must return [0, 8, 8]');

        self::assertSame([0, 0, 0], (new Arr(0, 0, 0))->fill(8, 4)->toArray(), '[0, 0, 0].fill(8, 4) must return [0, 0, 0]');

        self::assertSame([0, 0, 8], (new Arr(0, 0, 0))->fill(8, -1)->toArray(), '[0, 0, 0].fill(8, -1) must return [0, 0, 8]');
    }

    /**
     * test/built-ins/Array/prototype/fill/fill-values.js.
     */
    public function testFillValues(): void
    {
        self::assertSame([], (new Arr())->fill(8)->toArray(), '[].fill(8) must return []');

        // JS `[0, 0].fill()` fills with `undefined`; Arr::fill() requires $value, so null is passed explicitly.
        self::assertSame([null, null], (new Arr(0, 0))->fill(null)->toArray(), '[0, 0].fill() must return [undefined, undefined]');

        self::assertSame([8, 8, 8], (new Arr(0, 0, 0))->fill(8)->toArray(), '[0, 0, 0].fill(8) must return [8, 8, 8]');
    }

    // SKIPPED: test/built-ins/Array/prototype/fill/length-near-integer-limit.js
    // Reason: array-like with length near 2^53; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/fill/length.js

    // SKIPPED: test/built-ins/Array/prototype/fill/name.js

    // SKIPPED: test/built-ins/Array/prototype/fill/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/fill/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/fill/resizable-buffer.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-end-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-end.js
    // Reason: end coercion via valueOf; Arr::fill() is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-setting-property-value.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-start-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-start.js
    // Reason: start coercion via valueOf; Arr::fill() is typed int

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-this-length-as-symbol.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-this-length.js

    // SKIPPED: test/built-ins/Array/prototype/fill/return-abrupt-from-this.js

    /**
     * test/built-ins/Array/prototype/fill/return-this.js.
     */
    public function testReturnThis(): void
    {
        // The `Array.prototype.fill.call({length: 0})` portion is not portable (array-like this).
        $arr = new Arr();
        $result = $arr->fill(1);

        self::assertSame($arr, $result, 'The value of $result is expected to equal the value of $arr');
    }

    // SKIPPED: test/built-ins/Array/prototype/fill/typed-array-resize.js
}
