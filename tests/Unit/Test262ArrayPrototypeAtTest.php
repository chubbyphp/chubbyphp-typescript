<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.at tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeAtTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/at/coerced-index-resize.js

    // SKIPPED: test/built-ins/Array/prototype/at/index-argument-tointeger.js
    // Reason: index coercion via valueOf; Arr::at() is typed int

    // SKIPPED: test/built-ins/Array/prototype/at/index-non-numeric-argument-tointeger-invalid.js

    // SKIPPED: test/built-ins/Array/prototype/at/index-non-numeric-argument-tointeger.js
    // Reason: index coercion of false/null/undefined/string; Arr::at() is typed int

    // SKIPPED: test/built-ins/Array/prototype/at/length.js

    // SKIPPED: test/built-ins/Array/prototype/at/name.js

    // SKIPPED: test/built-ins/Array/prototype/at/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/at/return-abrupt-from-this.js

    /**
     * test/built-ins/Array/prototype/at/returns-item-relative-index.js.
     */
    public function testReturnsItemRelativeIndex(): void
    {
        $a = new Arr(6);
        $a[0] = 1;
        $a[1] = 2;
        $a[2] = 3;
        $a[3] = 4;
        $a[5] = 5;

        self::assertSame(1, $a->at(0), '$a->at(0) must return 1');
        self::assertSame(5, $a->at(-1), '$a->at(-1) must return 5');
        self::assertNull($a->at(-2), '$a->at(-2) returns null');
        self::assertSame(4, $a->at(-3), '$a->at(-3) must return 4');
        self::assertSame(3, $a->at(-4), '$a->at(-4) must return 3');
    }

    /**
     * test/built-ins/Array/prototype/at/returns-item.js.
     */
    public function testReturnsItem(): void
    {
        $a = new Arr(6);
        $a[0] = 1;
        $a[1] = 2;
        $a[2] = 3;
        $a[3] = 4;
        $a[5] = 5;

        self::assertSame(1, $a->at(0), '$a->at(0) must return 1');
        self::assertSame(2, $a->at(1), '$a->at(1) must return 2');
        self::assertSame(3, $a->at(2), '$a->at(2) must return 3');
        self::assertSame(4, $a->at(3), '$a->at(3) must return 4');
        self::assertNull($a->at(4), '$a->at(4) returns null');
        self::assertSame(5, $a->at(5), '$a->at(5) must return 5');
    }

    /**
     * test/built-ins/Array/prototype/at/returns-undefined-for-holes-in-sparse-arrays.js.
     */
    public function testReturnsUndefinedForHolesInSparseArrays(): void
    {
        $a = new Arr(7);
        $a[0] = 0;
        $a[1] = 1;
        $a[3] = 3;
        $a[4] = 4;
        $a[6] = 6;

        self::assertSame(0, $a->at(0), '$a->at(0) must return 0');
        self::assertSame(1, $a->at(1), '$a->at(1) must return 1');
        self::assertNull($a->at(2), '$a->at(2) returns null');
        self::assertSame(3, $a->at(3), '$a->at(3) must return 3');
        self::assertSame(4, $a->at(4), '$a->at(4) must return 4');
        self::assertNull($a->at(5), '$a->at(5) returns null');
        self::assertSame(6, $a->at(6), '$a->at(6) must return 6');
        self::assertSame(0, $a->at(-0), '$a->at(-0) must return 0');
        self::assertSame(6, $a->at(-1), '$a->at(-1) must return 6');
        self::assertNull($a->at(-2), '$a->at(-2) returns null');
        self::assertSame(4, $a->at(-3), '$a->at(-3) must return 4');
        self::assertSame(3, $a->at(-4), '$a->at(-4) must return 3');
        self::assertNull($a->at(-5), '$a->at(-5) returns null');
        self::assertSame(1, $a->at(-6), '$a->at(-6) must return 1');
    }

    /**
     * test/built-ins/Array/prototype/at/returns-undefined-for-out-of-range-index.js.
     */
    public function testReturnsUndefinedForOutOfRangeIndex(): void
    {
        $a = new Arr();

        self::assertNull($a->at(-2), '$a->at(-2) returns null'); // wrap around the end
        self::assertNull($a->at(0), '$a->at(0) returns null');
        self::assertNull($a->at(1), '$a->at(1) returns null');
    }

    // SKIPPED: test/built-ins/Array/prototype/at/typed-array-resizable-buffer.js
}
