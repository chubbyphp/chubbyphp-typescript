<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array constructor tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayTest extends TestCase
{
    /**
     * test/built-ins/Array/15.4.5.1-5-1.js.
     */
    public function test1545151(): void
    {
        $a = new Arr();
        $a[4294967295] = 'not an array element';

        self::assertSame('not an array element', $a[4294967295], 'The value of $a[4294967295] is expected to be "not an array element"');
    }

    /**
     * test/built-ins/Array/15.4.5.1-5-2.js.
     */
    public function test1545152(): void
    {
        $a = new Arr(0, 1, 2);
        $a[4294967295] = 'not an array element';

        self::assertSame(3, $a->length, 'The value of $a->length is expected to be 3');
    }

    // SKIPPED: test/built-ins/Array/15.4.5-1.js

    // SKIPPED: test/built-ins/Array/constructor.js

    // SKIPPED: test/built-ins/Array/is-a-constructor.js

    // SKIPPED: test/built-ins/Array/length.js

    // SKIPPED: test/built-ins/Array/name.js

    // SKIPPED: test/built-ins/Array/prop-desc.js

    /**
     * test/built-ins/Array/property-cast-boolean-primitive.js.
     */
    public function testPropertyCastBooleanPrimitive(): void
    {
        $x = new Arr();

        $x[true] = 1;
        self::assertNull($x[1], 'The value of $x[1] is expected to equal null');
        self::assertSame(1, $x['true'], 'The value of $x["true"] is expected to be 1');

        $x[false] = 0;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(0, $x['false'], 'The value of $x["false"] is expected to be 0');
    }

    /**
     * test/built-ins/Array/property-cast-nan-infinity.js.
     */
    public function testPropertyCastNanInfinity(): void
    {
        $x = new Arr();

        // In Arr, non-finite float offsets are ignored (normalizeOffset does not convert them)
        $x[NAN] = 1;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(1, $x['NAN'], 'The value of x["NAN"] is expected to be 1');

        $y = new Arr();
        $y[INF] = 1;
        self::assertNull($y[0], 'The value of $y[0] is expected to equal null');
        self::assertSame(1, $y['INF'], 'The value of $y["INF"] is expected to be 1');

        $z = new Arr();
        $z[-INF] = 1;
        self::assertNull($z[0], 'The value of $z[0] is expected to equal null');
        self::assertSame(1, $z['-INF'], 'The value of $z["-INF"] is expected to be 1');
    }

    /**
     * test/built-ins/Array/property-cast-number.js.
     */
    public function testPropertyCastNumber(): void
    {
        $x = new Arr();
        $x[4294967296] = 1;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(1, $x[4294967296], 'The value of $x["4294967296"] is expected to be 1');

        $y = new Arr();
        $y[4294967297] = 1;
        if (isset($y[1])) {
            throw new \Exception('#3: $y = []; $y[4294967297] = 1; $y[1] === null. Actual: '.$y[1]);
        }

        // CHECK#4
        if (1 !== $y['4294967297']) {
            throw new \Exception('#4: y = []; y[4294967297] = 1; y["4294967297"] === 1. Actual: '.$y['4294967297']);
        }

        // CHECK#5
        $z = new Arr();
        $z[1.1] = 1;
        if (isset($z[1])) {
            throw new \Exception('#5: z = []; z[1.1] = 1; z[1] === undefined. Actual: '.$z[1]);
        }

        // CHECK#6
        if (1 !== $z['1.1']) {
            throw new \Exception('#6: z = []; z[1.1] = 1; z["1.1"] === 1. Actual: '.$z['1.1']);
        }
    }

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-one.js

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-two.js

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-zero.js

    // SKIPPED: test/built-ins/Array/proto.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.2_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.3_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A2.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A2.2_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A3.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.2_T1.js

    /**
     * test/built-ins/Array/S15.4.2.1_A1.3_T1.js.
     */
    public function testS15421A13T1(): void
    {
        $x = new Arr(2);

        self::assertNotSame(1, $x->length, 'The value of $x->length is not 1');
        self::assertNotSame(2, $x[0], 'The value of $x[0] is not 2');
    }

    /**
     * test/built-ins/Array/S15.4.2.1_A2.1_T1.js.
     */
    public function testS15421A21T1(): void
    {
        self::assertSame(0, (new Arr())->length, 'The value of new Arr()->length is expected to be 0');
        self::assertSame(4, (new Arr(0, 1, 0, 1))->length, 'The value of new Arr(0, 1, 0, 1)->length is expected to be 4');

        self::assertSame(2, (new Arr(null, null))->length, 'The value of new Arr(null, null)->length is expected to be 2');
    }

    /**
     * test/built-ins/Array/S15.4.2.1_A2.2_T1.js.
     */
    public function testS15421A22T1(): void
    {
        $x = new Arr(...range(0, 99));

        for ($i = 0; $i < 100; ++$i) {
            $result = true;
            if ($x[$i] !== $i) {
                $result = false;
            }
        }

        self::assertTrue($result, 'The value of result is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.5.1_A1.2_T2.js

    /**
     * test/built-ins/Array/S15.4.5.1_A2.1_T1.js.
     */
    public function testS15451A21T1(): void
    {
        $x = new Arr();
        $x[4294967295] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[4294967295], 'The value of $x[4294967295] is expected to be 1');

        $x = new Arr();
        $x[-1] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[-1], 'The value of x[-1] is expected to be 1');

        $x = new Arr();
        $x[true] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[true], 'The value of $x[true] is expected to be 1');
    }

    /**
     * test/built-ins/Array/S15.4.5.1_A2.2_T1.js.
     */
    public function testS15451A22T1(): void
    {
        $x = new Arr(100);
        $x[0] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');

        $x[98] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');

        $x[99] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');
    }

    /**
     * test/built-ins/Array/S15.4.5.1_A2.3_T1.js.
     */
    public function testS15451A23T1(): void
    {
        $x = new Arr(100);
        $x[100] = 1;
        self::assertSame(101, $x->length, 'The value of $x->length is expected to be 101');

        $x[199] = 1;
        self::assertSame(200, $x->length, 'The value of $x->length is expected to be 200');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A1_T1.js.
     */
    public function testS15452A1T1(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x[0] = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[1] = 1;
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');

        $x[2147483648] = 1;
        self::assertSame(2147483649, $x->length, 'The value of $x->length is expected to be 2147483649');

        $x[4294967294] = 1;
        self::assertSame(4294967295, $x->length, 'The value of $x->length is expected to be 4294967295');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A1_T2.js.
     */
    public function testS15452A1T2(): void
    {
        $x = new Arr();
        $x[4294967295] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $y = new Arr();
        $y[1] = 1;
        $y[4294967295] = 1;
        self::assertSame(2, $y->length, 'The value of $y->length is expected to be 2');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A2_T1.js.
     */
    public function testS15452A2T1(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x[0] = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[1] = 1;
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');

        $x[9] = 1;
        self::assertSame(10, $x->length, 'The value of $x->length is expected to be 10');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T1.js.
     */
    public function testS15452A3T1(): void
    {
        $x = new Arr();
        $x->length = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[5] = 1;
        $x->length = 10;
        self::assertSame(10, $x->length, 'The value of $x->length is expected to be 10');
        self::assertSame(1, $x[5], 'The value of $x[5] is expected to be 1');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T2.js.
     */
    public function testS15452A3T2(): void
    {
        $x = new Arr();
        $x[1] = 1;
        $x[3] = 3;
        $x[5] = 5;
        $x->length = 4;

        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertNull($x[5], 'The value of $x[5] is expected to equal null');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');

        $x->length = 6;
        self::assertNull($x[5], 'The value of $x[5] is expected to equal null');

        $x->length = 0;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');

        $x->length = 1;
        self::assertNull($x[1], 'The value of $x[1] is expected to equal null');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T3.js.
     */
    public function testS15452A3T3(): void
    {
        $x = new Arr();
        $x->length = 4294967295;
        self::assertSame(4294967295, $x->length, 'The value of $x->length is expected to be 4294967295');

        try {
            $x = new Arr();
            $x->length = 4294967296;

            throw new \Exception('#2.1:$x = new Arr(); $x->length = 4294967296 throw RangeError. Actual: $x->length === '.$x->length);
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/S15.4_A1.1_T10.js.
     */
    public function testS154A11T10(): void
    {
        $x = new Arr();
        $k = 1;
        for ($i = 0; $i < 32; ++$i) {
            $k *= 2;
            $x[$k - 2] = $k;
        }

        $k = 1;
        for ($i = 0; $i < 32; ++$i) {
            $k *= 2;
            self::assertSame($k, $x[$k - 2], 'The value of $x[k - 2] is expected to equal the value of $k');
        }
    }

    /**
     * test/built-ins/Array/S15.4_A1.1_T4.js.
     */
    public function testS154A11T4(): void
    {
        $x = new Arr();
        $x['0'] = 0;
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');

        $y = new Arr();
        $y['1'] = 1;
        self::assertSame(1, $y[1], 'The value of $y[1] is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T5.js
    // Reason: $x[] = 1 and $x[null] = 1 are the same, therefore this JS feature cannot be implemented

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T6.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T7.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T8.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T9.js

    // SKIPPED: test/built-ins/Array/Symbol.species/length.js

    // SKIPPED: test/built-ins/Array/Symbol.species/return-value.js

    // SKIPPED: test/built-ins/Array/Symbol.species/symbol-species.js

    // SKIPPED: test/built-ins/Array/Symbol.species/symbol-species-name.js
}
