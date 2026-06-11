<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.unshift tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeUnshiftTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/unshift/S15.4.4.13_A1_T1.js.
     */
    public function testS154413A1T1(): void
    {
        $x = new Arr();
        $unshift = $x->unshift(1);
        self::assertSame(1, $unshift, '$x = new Arr(); $x->unshift(1) === 1');
        self::assertSame(1, $x[0], '$x = new Arr(); $x->unshift(1); $x[0] === 1');

        $unshift = $x->unshift();
        self::assertSame(1, $unshift, '$x = new Arr(); $x->unshift(1); $x->unshift() === 1');
        self::assertNull($x[1], '$x = new Arr(); $x->unshift(1); $x->unshift(); $x[1] === null');

        $unshift = $x->unshift(-1);
        self::assertSame(2, $unshift, '$x = new Arr(); $x->unshift(1); $x->unshift(); $x->unshift(-1) === 2');
        self::assertSame(-1, $x[0], '$x = new Arr(); $x->unshift(1); $x->unshift(-1); $x[0] === -1');
        self::assertSame(1, $x[1], '$x = new Arr(); $x->unshift(1); $x->unshift(-1); $x[1] === 1');
        self::assertSame(2, $x->length, '$x = new Arr(); $x->unshift(1); $x->unshift(); $x->unshift(-1); $x->length === 2');
    }

    /**
     * test/built-ins/Array/prototype/unshift/S15.4.4.13_A1_T2.js.
     */
    public function testS154413A1T2(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, '$x = new Arr(); $x->length === 0');

        $x[0] = 0;
        $unshift = $x->unshift(true, INF, 'NaN', '1', -1);
        self::assertSame(6, $unshift, '$x = new Arr(); $x[0] = 0; $x->unshift(true, INF, "NaN", "1", -1) === 6');
        self::assertSame(0, $x[5], '$x[5] === 0');
        self::assertTrue($x[0], '$x[0] === true');
        self::assertSame(INF, $x[1], '$x[1] === INF');
        self::assertSame('NaN', $x[2], '$x[2] === "NaN"');
        self::assertSame('1', $x[3], '$x[3] === "1"');
        self::assertSame(-1, $x[4], '$x[4] === -1');
        self::assertSame(6, $x->length, '$x->length === 6');
    }

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A2_T1.js
    // Reason: unshift called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A2_T2.js
    // Reason: length coercion (NaN/-Infinity/float/Number object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A2_T3.js
    // Reason: ToPrimitive(length) via valueOf/toString on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A3_T2.js
    // Reason: array-like this value with negative length coercion

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A4_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/unshift/S15.4.4.13_A4_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/unshift/call-with-boolean.js
    // Reason: unshift applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/unshift/clamps-to-integer-limit.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/unshift/length-near-integer-limit.js
    // Reason: array-like this value with getters and length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/unshift/length.js

    // SKIPPED: test/built-ins/Array/prototype/unshift/name.js

    // SKIPPED: test/built-ins/Array/prototype/unshift/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/unshift/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/unshift/read-only-property.js
    // Reason: accessor property on the this value

    // SKIPPED: test/built-ins/Array/prototype/unshift/set-length-array-is-frozen.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/unshift/set-length-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/unshift/set-length-zero-array-is-frozen.js
    // Reason: Object.freeze

    // SKIPPED: test/built-ins/Array/prototype/unshift/set-length-zero-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/unshift/throws-if-integer-limit-exceeded.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/unshift/throws-with-string-receiver.js
    // Reason: unshift applied to a string primitive this value
}
