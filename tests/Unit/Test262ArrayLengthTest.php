<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array length tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayLengthTest extends TestCase
{
    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-1.js.
     */
    public function test154513D1(): void
    {
        try {
            $a = new Arr();
            $a->length = 4294967296;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e);
            self::assertSame('Invalid array length: 4294967296', $e->getMessage());
        }
    }

    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-2.js.
     */
    public function test154513D2(): void
    {
        try {
            $a = new Arr();
            $a->length = 4294967297;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e);
            self::assertSame('Invalid array length: 4294967297', $e->getMessage());
        }
    }

    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-3.js.
     */
    public function test154513D3(): void
    {
        $a = new Arr();
        $a->length = 4294967295;
        self::assertSame(4294967295, $a->length);
    }

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-coercion-order.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-coercion-order-set.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-error.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-no-value-order.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-overflow-order.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-overflow-realm.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T1.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T2.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T3.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.2_T1.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.1_T1.js.
     */
    public function testS15422A21T1(): void
    {
        $x = new Arr(0);
        self::assertSame(0, $x->length);

        $x = new Arr(1);
        self::assertSame(1, $x->length);

        $x = new Arr(4294967295);
        self::assertSame(4294967295, $x->length);
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T1.js.
     */
    public function testS15422A22T1(): void
    {
        try {
            new Arr(-1);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(4294967296);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(4294967297);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T2.js.
     */
    public function testS15422A22T2(): void
    {
        try {
            new Arr(NAN);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(INF);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(-INF);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T3.js.
     */
    public function testS15422A22T3(): void
    {
        try {
            new Arr(1.5);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(PHP_FLOAT_MAX);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(PHP_FLOAT_MIN);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T1.js.
     */
    public function testS15422A23T1(): void
    {
        $x = new Arr(null);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertNull($x[0], 'The value of $x[0] is expected to be null');
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T2.js.
     */
    public function testS15422A23T2(): void
    {
        $x = new Arr(true);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertTrue($x[0], 'The value of $x[0] is expected to be true');

        $x = new Arr(false);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertFalse($x[0], 'The value of $x[0] is expected to be false');
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T3.js.
     */
    public function testS15422A23T3(): void
    {
        $x = new Arr('1');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame('1', $x[0], 'The value of $x[0] is expected to be "1"');

        $x = new Arr('0');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame('0', $x[0], 'The value of $x[0] is expected to be "0"');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A2.3_T4.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A2.3_T5.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/length/S15.4.4_A1.3_T1.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.1_T1.js.
     */
    public function testS15451A11T1(): void
    {
        try {
            $x = new Arr();
            $x->length = 4294967296;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = -1;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = 1.5;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.1_T2.js.
     */
    public function testS15451A11T2(): void
    {
        try {
            $x = new Arr();
            $x->length = NAN;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = INF;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = -INF;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.2_T1.js.
     */
    public function testS15451A12T1(): void
    {
        $x = new Arr(0, null, 2, null, 4);
        $x->length = 4;
        self::assertNull($x[4], 'The value of $x[4] is expected to equal null');

        $x->length = 3;
        self::assertNull($x[3], 'The value of $x[3] is expected to equal null');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.5.1_A1.2_T3.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.3_T1.js.
     */
    public function testS15451A13T1(): void
    {
        $x = new Arr();
        $x->length = true;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x = new Arr(null);
        $x->length = null;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x = new Arr(null);
        $x->length = false;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x = new Arr();
        $x->length = '1';
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.5.1_A1.3_T2.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/length/S15.4.5.2_A3_T4.js.
     */
    public function testS15452A3T4(): void
    {
        $x = new Arr(0, 1, 2);
        $x[4294967294] = 4294967294;
        $x->length = 2;

        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertNull($x[2], 'The value of $x[2] is expected to equal null');
        self::assertNull($x[4294967294], 'The value of $x[4294967294] is expected to equal null');
    }
}
