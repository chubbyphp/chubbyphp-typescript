<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.pop tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypePopTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/pop/S15.4.4.6_A1.1_T1.js.
     */
    public function testS15446A11T1(): void
    {
        $x = new Arr();
        $pop = $x->pop();
        self::assertNull($pop, '$x = new Arr(); $x->pop() === null');
        self::assertSame(0, $x->length, '$x = new Arr(); $x->pop(); $x->length === 0');

        $x = new Arr(1, 2, 3);
        $x->length = 0;
        $pop = $x->pop();
        self::assertNull($pop, '$x = new Arr(1,2,3); $x->length = 0; $x->pop() === null');
        self::assertSame(0, $x->length, '$x = new Arr(1,2,3); $x->length = 0; $x->pop(); $x->length === 0');
    }

    /**
     * test/built-ins/Array/prototype/pop/S15.4.4.6_A1.2_T1.js.
     */
    public function testS15446A12T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $pop = $x->pop();
        self::assertSame(3, $pop, '$x = new Arr(0,1,2,3); $x->pop() === 3');
        self::assertSame(3, $x->length, '$x = new Arr(0,1,2,3); $x->pop(); $x->length === 3');
        self::assertNull($x[3], '$x = new Arr(0,1,2,3); $x->pop(); $x[3] === null');
        self::assertSame(2, $x[2], '$x = new Arr(0,1,2,3); $x->pop(); $x[2] === 2');

        $x = new Arr();
        $x[0] = 0;
        $x[3] = 3;
        $pop = $x->pop();
        self::assertSame(3, $pop, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop() === 3');
        self::assertSame(3, $x->length, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop(); $x->length === 3');
        self::assertNull($x[3], '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop(); $x[3] === null');
        self::assertNull($x[2], '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop(); $x[2] === null');

        $x->length = 1;
        $pop = $x->pop();
        self::assertSame(0, $pop, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop(); $x->length = 1; $x->pop() === 0');
        self::assertSame(0, $x->length, '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->pop(); $x->length = 1; $x->pop(); $x->length === 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A2_T1.js
    // Reason: pop called generically on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A2_T2.js
    // Reason: length coercion (NaN/Infinity/-0/Number object) on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A2_T3.js
    // Reason: length coercion on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A2_T4.js
    // Reason: ToPrimitive(length) via valueOf/toString on a plain object this value

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A3_T1.js
    // Reason: array-like this value with length 4294967296; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A3_T2.js
    // Reason: array-like this value with length 4294967297; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A3_T3.js
    // Reason: array-like this value with negative length coercion

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A4_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/S15.4.4.6_A4_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/call-with-boolean.js
    // Reason: pop applied to a boolean primitive this value

    // SKIPPED: test/built-ins/Array/prototype/pop/clamps-to-integer-limit.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/pop/length-near-integer-limit.js
    // Reason: array-like this value with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/pop/length.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/name.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/not-a-constructor.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/prop-desc.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/set-length-array-is-frozen.js
    // Reason: Object.freeze and accessor on Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/pop/set-length-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/pop/set-length-zero-array-is-frozen.js
    // Reason: Object.freeze

    // SKIPPED: test/built-ins/Array/prototype/pop/set-length-zero-array-length-is-non-writable.js
    // Reason: Object.defineProperty non-writable length

    // SKIPPED: test/built-ins/Array/prototype/pop/throws-with-string-receiver.js
    // Reason: pop applied to a string primitive this value
}
