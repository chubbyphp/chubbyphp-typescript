<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.shift tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeShiftTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/shift/S15.4.4.9_A1.1_T1.js.
     */
    public function testS15449A11T1(): void
    {
        $x = new Arr();
        $shift = $x->shift();
        self::assertNull($shift, '$x = new Arr(); $x->shift() === null');
        self::assertSame(0, $x->length, '$x = new Arr(); $x->shift(); $x->length === 0');

        $x = new Arr(1, 2, 3);
        $x->length = 0;
        $shift = $x->shift();
        self::assertNull($shift, '$x = new Arr(1,2,3); $x->length = 0; $x->shift() === null');
        self::assertSame(0, $x->length, '$x = new Arr(1,2,3); $x->length = 0; $x->shift(); $x->length === 0');
    }

    /**
     * test/built-ins/Array/prototype/shift/S15.4.4.9_A1.2_T1.js.
     */
    public function testS15449A12T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $shift = $x->shift();
        self::assertSame(0, $shift, '$x = new Arr(0,1,2,3); $x->shift() === 0');
        self::assertSame(3, $x->length, '$x = new Arr(0,1,2,3); $x->shift(); $x->length === 3');
        self::assertSame(1, $x[0], '$x = new Arr(0,1,2,3); $x->shift(); $x[0] === 1');
        self::assertSame(2, $x[1], '$x = new Arr(0,1,2,3); $x->shift(); $x[1] === 2');

        $x = new Arr();
        $x[0] = 0;
        $x[3] = 3;
        $shift = $x->shift();
        self::assertSame(0, $shift, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift() === 0');
        self::assertSame(3, $x->length, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift(); $x->length === 3');
        self::assertNull($x[0], '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift(); $x[0] === null');
        self::assertNull($x[12], '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift(); $x[12] === null');

        $x->length = 1;
        $shift = $x->shift();
        self::assertNull($shift, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift(); $x->length = 1; $x->shift() === null');
        self::assertSame(0, $x->length, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->shift(); $x->length = 1; $x->shift(); $x->length === 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A2_T1.js
    // Reason: shift called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A2_T2.js
    // Reason: length coercion (NaN/-Infinity/-0/float/Number object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A2_T3.js
    // Reason: length coercion on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A2_T4.js
    // Reason: shift called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A2_T5.js
    // Reason: ToPrimitive(length) via valueOf/toString on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A3_T3.js
    // Reason: array-like this value with negative length coercion

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A4_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/shift/S15.4.4.9_A4_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/shift/call-with-boolean.js
    // Reason: shift applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/shift/length.js

    // SKIPPED: test/built-ins/Array/prototype/shift/name.js

    // SKIPPED: test/built-ins/Array/prototype/shift/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/shift/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/shift/set-length-array-is-frozen.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/shift/set-length-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/shift/set-length-zero-array-is-frozen.js
    // Reason: Object.freeze

    // SKIPPED: test/built-ins/Array/prototype/shift/set-length-zero-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/shift/throws-when-this-value-length-is-writable-false.js
    // Reason: shift applied to string/function/non-writable-length this values
}
