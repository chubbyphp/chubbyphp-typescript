<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.push tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypePushTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/push/S15.4.4.7_A1_T1.js.
     */
    public function testS15447A1T1(): void
    {
        $x = new Arr();
        $push = $x->push(1);
        self::assertSame(1, $push, '$x = new Arr(); $x->push(1) === 1');
        self::assertSame(1, $x[0], '$x = new Arr(); $x->push(1); $x[0] === 1');

        $push = $x->push();
        self::assertSame(1, $push, '$x = new Arr(); $x->push(1); $x->push() === 1');
        self::assertNull($x[1], '$x = new Arr(); $x->push(1); $x->push(); $x[1] === null');

        $push = $x->push(-1);
        self::assertSame(2, $push, '$x = new Arr(); $x->push(1); $x->push(); $x->push(-1) === 2');
        self::assertSame(-1, $x[1], '$x = new Arr(); $x->push(1); $x->push(-1); $x[1] === -1');
        self::assertSame(2, $x->length, '$x = new Arr(); $x->push(1); $x->push(); $x->push(-1); $x->length === 2');
    }

    /**
     * test/built-ins/Array/prototype/push/S15.4.4.7_A1_T2.js.
     */
    public function testS15447A1T2(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, '$x = new Arr(); $x->length === 0');

        $x[0] = 0;
        $push = $x->push(true, INF, 'NaN', '1', -1);
        self::assertSame(6, $push, '$x = new Arr(); $x[0] = 0; $x->push(true, INF, "NaN", "1", -1) === 6');
        self::assertSame(0, $x[0], '$x[0] === 0');
        self::assertTrue($x[1], '$x[1] === true');
        self::assertSame(INF, $x[2], '$x[2] === INF');
        self::assertSame('NaN', $x[3], '$x[3] === "NaN"');
        self::assertSame('1', $x[4], '$x[4] === "1"');
        self::assertSame(-1, $x[5], '$x[5] === -1');
        self::assertSame(6, $x->length, '$x->length === 6');
    }

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A2_T1.js
    // Reason: push called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A2_T2.js
    // Reason: length coercion (NaN/Infinity/float/Number object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A2_T3.js
    // Reason: ToPrimitive(length) via valueOf/toString on a plain object this value

    /**
     * test/built-ins/Array/prototype/push/S15.4.4.7_A3.js.
     */
    public function testS15447A3(): void
    {
        $x = new Arr();
        $x->length = 4294967295;

        $push = $x->push();
        self::assertSame(4294967295, $push, 'The value of push is expected to be 4294967295');

        // Deviation from JS: Array.prototype.push throws a RangeError when the
        // new length would exceed 2^32-1; Arr::push() does not validate the new
        // length, so the element is appended and the length grows past the cap.
        $push = $x->push('x');
        self::assertSame(4294967296, $push, '$x->push("x") returns 4294967296 (JS throws RangeError)');
        self::assertSame('x', $x->at(4294967295), 'The value of $x->at(4294967295) is expected to be "x"');
        self::assertSame(4294967296, $x->length, 'The value of $x->length is expected to be 4294967296 (JS keeps 4294967295)');
    }

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A4_T1.js
    // Reason: array-like this value with length 4294967296; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A4_T2.js
    // Reason: array-like this value with length 4294967295

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A4_T3.js
    // Reason: array-like this value with negative length coercion

    // SKIPPED: test/built-ins/Array/prototype/push/S15.4.4.7_A5_T1.js
    // Reason: elements inherited from Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/push/call-with-boolean.js
    // Reason: push applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/push/clamps-to-integer-limit.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/push/length-near-integer-limit-set-failure.js
    // Reason: Object.defineProperty non-writable index on an array-like

    // SKIPPED: test/built-ins/Array/prototype/push/length-near-integer-limit.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/push/length.js

    // SKIPPED: test/built-ins/Array/prototype/push/name.js

    // SKIPPED: test/built-ins/Array/prototype/push/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/push/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/push/set-length-array-is-frozen.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/push/set-length-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/push/set-length-zero-array-is-frozen.js
    // Reason: Object.freeze

    // SKIPPED: test/built-ins/Array/prototype/push/set-length-zero-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/push/throws-if-integer-limit-exceeded.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/push/throws-with-string-receiver.js
    // Reason: push applied to a string primitive this value
}
