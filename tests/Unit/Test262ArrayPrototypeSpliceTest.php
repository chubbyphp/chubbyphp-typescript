<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.splice tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeSpliceTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/splice/15.4.4.12-9-a-1.js.
     */
    public function test1544129A1(): void
    {
        $arrObj = new Arr(1, 2, 3);
        $newArrObj = $arrObj->splice(-2, 1);

        self::assertSame(1, $newArrObj->length, 'The value of $newArrObj->length is expected to be 1');
        self::assertSame(2, $newArrObj[0], 'The value of $newArrObj[0] is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/splice/15.4.4.12-9-c-ii-1.js
    // Reason: relies on Array.prototype index manipulation and property attribute checks

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T1.js.
     */
    public function testS154412A11T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(0, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame(3, $x[0], 'The value of $x[0] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T2.js.
     */
    public function testS154412A11T2(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(0, 3, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(4, $x[0], 'The value of $x[0] is expected to be 4');
        self::assertSame(5, $x[1], 'The value of $x[1] is expected to be 5');
        self::assertSame(3, $x[2], 'The value of $x[2] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T3.js.
     */
    public function testS154412A11T3(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(0, 4);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(4, $arr->length, 'The value of $arr->length is expected to be 4');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T4.js.
     */
    public function testS154412A11T4(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(1, 3, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(4, $x[1], 'The value of $x[1] is expected to be 4');
        self::assertSame(5, $x[2], 'The value of $x[2] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T5.js.
     */
    public function testS154412A11T5(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(0, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(4, $arr->length, 'The value of $arr->length is expected to be 4');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.1_T6.js.
     */
    public function testS154412A11T6(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(1, 4, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(4, $x[1], 'The value of $x[1] is expected to be 4');
        self::assertSame(5, $x[2], 'The value of $x[2] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.2_T1.js.
     */
    public function testS154412A12T1(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(-2, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.2_T2.js.
     */
    public function testS154412A12T2(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(-1, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.2_T3.js.
     */
    public function testS154412A12T3(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(-2, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(2, $x[0], 'The value of $x[0] is expected to be 2');
        self::assertSame(3, $x[1], 'The value of $x[1] is expected to be 3');
        self::assertSame(0, $x[2], 'The value of $x[2] is expected to be 0');
        self::assertSame(1, $x[3], 'The value of $x[3] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.2_T4.js.
     */
    public function testS154412A12T4(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(-1, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(2, $x[1], 'The value of $x[1] is expected to be 2');
        self::assertSame(3, $x[2], 'The value of $x[2] is expected to be 3');
        self::assertSame(1, $x[3], 'The value of $x[3] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.2_T5.js.
     */
    public function testS154412A12T5(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(-3, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(2, $x[0], 'The value of $x[0] is expected to be 2');
        self::assertSame(3, $x[1], 'The value of $x[1] is expected to be 3');
        self::assertSame(0, $x[2], 'The value of $x[2] is expected to be 0');
        self::assertSame(1, $x[3], 'The value of $x[3] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.3_T1.js.
     */
    public function testS154412A13T1(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(0, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.3_T2.js.
     */
    public function testS154412A13T2(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(2, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.3_T3.js.
     */
    public function testS154412A13T3(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(0, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(2, $x[0], 'The value of $x[0] is expected to be 2');
        self::assertSame(3, $x[1], 'The value of $x[1] is expected to be 3');
        self::assertSame(0, $x[2], 'The value of $x[2] is expected to be 0');
        self::assertSame(1, $x[3], 'The value of $x[3] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.3_T4.js.
     */
    public function testS154412A13T4(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(2, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.3_T5.js.
     */
    public function testS154412A13T5(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->splice(3, -1, 2, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T1.js.
     */
    public function testS154412A14T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-4, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame(3, $x[0], 'The value of $x[0] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T2.js.
     */
    public function testS154412A14T2(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-4, 3, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(4, $x[0], 'The value of $x[0] is expected to be 4');
        self::assertSame(5, $x[1], 'The value of $x[1] is expected to be 5');
        self::assertSame(3, $x[2], 'The value of $x[2] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T3.js.
     */
    public function testS154412A14T3(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-5, 4);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(4, $arr->length, 'The value of $arr->length is expected to be 4');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T4.js.
     */
    public function testS154412A14T4(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-3, 3, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(4, $x[1], 'The value of $x[1] is expected to be 4');
        self::assertSame(5, $x[2], 'The value of $x[2] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T5.js.
     */
    public function testS154412A14T5(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-9, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(4, $arr->length, 'The value of $arr->length is expected to be 4');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.4_T6.js.
     */
    public function testS154412A14T6(): void
    {
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(-3, 4, 4, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(3, $x->length, 'The value of $x->length is expected to be 3');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(4, $x[1], 'The value of $x[1] is expected to be 4');
        self::assertSame(5, $x[2], 'The value of $x[2] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.5_T1.js.
     */
    public function testS154412A15T1(): void
    {
        // JS: x.splice(undefined, undefined); undefined start coerces to 0,
        // undefined deleteCount coerces to 0 -> explicit null deleteCount in Arr.
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(0, null);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A1.5_T2.js.
     */
    public function testS154412A15T2(): void
    {
        // JS: x.splice(1, undefined); undefined deleteCount coerces to 0
        // -> explicit null deleteCount in Arr.
        $x = new Arr(0, 1, 2, 3);
        $arr = $x->splice(1, null);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');
    }

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.1_T1.js
    // Reason: start given as float 1.5; Arr::splice() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.1_T2.js
    // Reason: start given as NaN; Arr::splice() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.1_T3.js
    // Reason: start given as Infinity; Arr::splice() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.1_T4.js
    // Reason: start given as -Infinity; Arr::splice() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.1_T5.js
    // Reason: start given as object with valueOf; Arr::splice() start is typed int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.2_T1.js
    // Reason: deleteCount given as float 3.5; Arr::splice() deleteCount is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.2_T2.js
    // Reason: deleteCount given as NaN; Arr::splice() deleteCount is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.2_T3.js
    // Reason: deleteCount given as Infinity; Arr::splice() deleteCount is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.2_T4.js
    // Reason: deleteCount given as -Infinity; Arr::splice() deleteCount is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2.2_T5.js
    // Reason: deleteCount given as object with valueOf; Arr::splice() deleteCount is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2_T1.js
    // Reason: splice applied to an array-like object

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2_T2.js
    // Reason: splice applied to an array-like object

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2_T3.js
    // Reason: splice applied to an array-like object

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A2_T4.js
    // Reason: splice applied to an array-like object

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A3_T1.js
    // Reason: array-like object with length 2^32

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A3_T3.js
    // Reason: array-like object with negative length

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A4_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A4_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A4_T3.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    /**
     * test/built-ins/Array/prototype/splice/S15.4.4.12_A6.1_T1.js.
     */
    public function testS154412A61T1(): void
    {
        $a = new Arr(0, 1, 2);

        $a->splice(1, 2, 4);

        self::assertSame(2, $a->length, 'The value of $a->length is expected to be 2');
        self::assertSame(0, $a[0], 'The value of $a[0] is expected to be 0');
        self::assertSame(4, $a[1], 'The value of $a[1] is expected to be 4');
    }

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A6.1_T2.js
    // Reason: read-only length via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/splice/S15.4.4.12_A6.1_T3.js
    // Reason: getter-only length on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/splice/call-with-boolean.js
    // Reason: splice applied to boolean primitive; also requires zero-argument splice()

    /**
     * test/built-ins/Array/prototype/splice/called_with_one_argument.js.
     */
    public function testCalledWithOneArgument(): void
    {
        $array = new Arr('first', 'second', 'third');

        $result = $array->splice(1);

        self::assertSame(1, $array->length, 'array length updated');
        self::assertSame('first', $array[0], 'array[0] unchanged');

        self::assertSame(2, $result->length, 'result array length correct');
        self::assertSame('second', $result[0], 'result[0] correct');
        self::assertSame('third', $result[1], 'result[1] correct');
    }

    // SKIPPED: test/built-ins/Array/prototype/splice/clamps-length-to-integer-limit.js
    // Reason: array-like objects with length beyond 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/splice/create-ctor-non-object.js
    // Reason: constructor property lookup / ArraySpeciesCreate

    // SKIPPED: test/built-ins/Array/prototype/splice/create-ctor-poisoned.js
    // Reason: constructor property lookup / ArraySpeciesCreate

    // SKIPPED: test/built-ins/Array/prototype/splice/create-non-array-invalid-len.js
    // Reason: array-like object with length 2^32

    // SKIPPED: test/built-ins/Array/prototype/splice/create-non-array.js
    // Reason: constructor property lookup / ArraySpeciesCreate

    // SKIPPED: test/built-ins/Array/prototype/splice/create-proto-from-ctor-realm-array.js
    // Reason: realms / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-proto-from-ctor-realm-non-array.js
    // Reason: realms / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-proxy.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-revoked-proxy.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-abrupt.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-length-exceeding-integer-limit.js
    // Reason: Proxy / @@species / length beyond 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-neg-zero.js
    // Reason: @@species / -0 has no integer representation in PHP

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-non-ctor.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-null.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-poisoned.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-undef-invalid-len.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species-undef.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/create-species.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/length-and-deleteCount-exceeding-integer-limit.js
    // Reason: array-like objects with length beyond 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/splice/length-exceeding-integer-limit-shrink-array.js
    // Reason: array-like objects with length beyond 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/splice/length-near-integer-limit-grow-array.js
    // Reason: array-like objects with length near 2^53-1

    // SKIPPED: test/built-ins/Array/prototype/splice/length.js

    // SKIPPED: test/built-ins/Array/prototype/splice/name.js

    // SKIPPED: test/built-ins/Array/prototype/splice/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/splice/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/splice/property-traps-order-with-species.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/set_length_no_args.js
    // Reason: array-like object with length accessors; also requires zero-argument splice()

    // SKIPPED: test/built-ins/Array/prototype/splice/target-array-non-extensible.js
    // Reason: non-extensible objects / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/target-array-with-non-configurable-property.js
    // Reason: property descriptors / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/target-array-with-non-writable-property.js
    // Reason: property descriptors / @@species

    // SKIPPED: test/built-ins/Array/prototype/splice/throws-if-integer-limit-exceeded.js
    // Reason: array-like objects with length beyond 2^53-1
}
