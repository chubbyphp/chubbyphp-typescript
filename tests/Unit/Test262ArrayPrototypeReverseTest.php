<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.reverse tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeReverseTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/reverse/S15.4.4.8_A1_T1.js.
     */
    public function testS15448A1T1(): void
    {
        $x = new Arr();
        $reverse = $x->reverse();
        self::assertSame($x, $reverse, '$x = new Arr(); $x->reverse() === $x');

        $x = new Arr();
        $x[0] = 1;
        $reverse = $x->reverse();
        self::assertSame($x, $reverse, '$x = new Arr(); $x[0] = 1; $x->reverse() === $x');

        $x = new Arr(1, 2);
        $reverse = $x->reverse();
        self::assertSame($x, $reverse, '$x = new Arr(1,2); $x->reverse() === $x');
        self::assertSame(2, $x[0], '$x = new Arr(1,2); $x->reverse(); $x[0] === 2');
        self::assertSame(1, $x[1], '$x = new Arr(1,2); $x->reverse(); $x[1] === 1');
        self::assertSame(2, $x->length, '$x = new Arr(1,2); $x->reverse(); $x->length === 2');
    }

    /**
     * test/built-ins/Array/prototype/reverse/S15.4.4.8_A1_T2.js.
     */
    public function testS15448A1T2(): void
    {
        $x = new Arr();
        $x[0] = true;
        $x[2] = INF;
        $x[4] = null;
        $x[5] = null;
        $x[8] = 'NaN';
        $x[9] = '-1';

        $reverse = $x->reverse();
        self::assertSame($x, $reverse, '$x->reverse() === $x');
        self::assertSame('-1', $x[0], '$x->reverse(); $x[0] === "-1"');
        self::assertSame('NaN', $x[1], '$x->reverse(); $x[1] === "NaN"');
        self::assertNull($x[2], '$x->reverse(); $x[2] === null');
        self::assertNull($x[3], '$x->reverse(); $x[3] === null');
        self::assertNull($x[4], '$x->reverse(); $x[4] === null');
        self::assertNull($x[5], '$x->reverse(); $x[5] === null');
        self::assertNull($x[6], '$x->reverse(); $x[6] === null');
        self::assertSame(INF, $x[7], '$x->reverse(); $x[7] === INF');
        self::assertNull($x[8], '$x->reverse(); $x[8] === null');
        self::assertTrue($x[9], '$x->reverse(); $x[9] === true');

        $x->length = 9;

        $reverse = $x->reverse();
        self::assertSame($x, $reverse, '$x->length = 9; $x->reverse() === $x');
        self::assertNull($x[0], '$x->length = 9; $x->reverse(); $x[0] === null');
        self::assertSame(INF, $x[1], '$x->length = 9; $x->reverse(); $x[1] === INF');
        self::assertNull($x[2], '$x->length = 9; $x->reverse(); $x[2] === null');
        self::assertNull($x[3], '$x->length = 9; $x->reverse(); $x[3] === null');
        self::assertNull($x[4], '$x->length = 9; $x->reverse(); $x[4] === null');
        self::assertNull($x[5], '$x->length = 9; $x->reverse(); $x[5] === null');
        self::assertNull($x[6], '$x->length = 9; $x->reverse(); $x[6] === null');
        self::assertSame('NaN', $x[7], '$x->length = 9; $x->reverse(); $x[7] === "NaN"');
        self::assertSame('-1', $x[8], '$x->length = 9; $x->reverse(); $x[8] === "-1"');
    }

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A2_T1.js
    // Reason: reverse called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A2_T2.js
    // Reason: length coercion (float/Number object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A2_T3.js
    // Reason: length coercion (string/String object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A3_T3.js
    // Reason: array-like this value with negative length coercion

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A4_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/reverse/S15.4.4.8_A4_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/reverse/array-has-one-entry.js
    // Reason: Object.freeze

    // SKIPPED: test/built-ins/Array/prototype/reverse/call-with-boolean.js
    // Reason: reverse applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/reverse/get_if_present_with_delete.js
    // Reason: accessor property on an index

    // SKIPPED: test/built-ins/Array/prototype/reverse/length-exceeding-integer-limit-with-object.js
    // Reason: array-like this value with length above 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/reverse/length-exceeding-integer-limit-with-proxy.js
    // Reason: Proxy/Reflect

    // SKIPPED: test/built-ins/Array/prototype/reverse/length.js
    // Reason: TypedArrays/ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reverse/name.js
    // Reason: TypedArrays/ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reverse/not-a-constructor.js
    // Reason: TypedArrays/ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reverse/prop-desc.js
    // Reason: TypedArrays/ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reverse/resizable-buffer.js
    // Reason: TypedArrays/ArrayBuffer
}
