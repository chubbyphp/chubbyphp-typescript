<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.slice tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeSliceTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/slice/15.4.4.10-10-c-ii-1.js
    // Reason: read-only index property on Array.prototype; no prototype chain in PHP

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T1.js.
     */
    public function testS1544410A11T1(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(0, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T2.js.
     */
    public function testS1544410A11T2(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(3, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T3.js.
     */
    public function testS1544410A11T3(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(4, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T4.js.
     */
    public function testS1544410A11T4(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(5, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T5.js.
     */
    public function testS1544410A11T5(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(3, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(3, $arr[0], 'The value of $arr[0] is expected to be 3');
        self::assertSame(4, $arr[1], 'The value of $arr[1] is expected to be 4');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T6.js.
     */
    public function testS1544410A11T6(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(2, 4);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(2, $arr[0], 'The value of $arr[0] is expected to be 2');
        self::assertSame(3, $arr[1], 'The value of $arr[1] is expected to be 3');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.1_T7.js.
     */
    public function testS1544410A11T7(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(3, 6);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(3, $arr[0], 'The value of $arr[0] is expected to be 3');
        self::assertSame(4, $arr[1], 'The value of $arr[1] is expected to be 4');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.2_T1.js.
     */
    public function testS1544410A12T1(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-3, 3);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(1, $arr->length, 'The value of $arr->length is expected to be 1');
        self::assertSame(2, $arr[0], 'The value of $arr[0] is expected to be 2');
        self::assertNull($arr[1], 'The value of $arr[1] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.2_T2.js.
     */
    public function testS1544410A12T2(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-1, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(1, $arr->length, 'The value of $arr->length is expected to be 1');
        self::assertSame(4, $arr[0], 'The value of $arr[0] is expected to be 4');
        self::assertNull($arr[1], 'The value of $arr[1] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.2_T3.js.
     */
    public function testS1544410A12T3(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-5, 1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(1, $arr->length, 'The value of $arr->length is expected to be 1');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertNull($arr[1], 'The value of $arr[1] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.2_T4.js.
     */
    public function testS1544410A12T4(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-9, 5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(5, $arr->length, 'The value of $arr->length is expected to be 5');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(4, $arr[4], 'The value of $arr[4] is expected to be 4');
        self::assertNull($arr[5], 'The value of $arr[5] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.3_T1.js.
     */
    public function testS1544410A13T1(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(0, -2);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.3_T2.js.
     */
    public function testS1544410A13T2(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(1, -4);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.3_T3.js.
     */
    public function testS1544410A13T3(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(0, -5);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.3_T4.js.
     */
    public function testS1544410A13T4(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(4, -9);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.4_T1.js.
     */
    public function testS1544410A14T1(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-5, -2);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertNull($arr[3], 'The value of $arr[3] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.4_T2.js.
     */
    public function testS1544410A14T2(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-3, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(2, $arr[0], 'The value of $arr[0] is expected to be 2');
        self::assertSame(3, $arr[1], 'The value of $arr[1] is expected to be 3');
        self::assertNull($arr[2], 'The value of $arr[2] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.4_T3.js.
     */
    public function testS1544410A14T3(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-9, -1);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(4, $arr->length, 'The value of $arr->length is expected to be 4');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertNull($arr[4], 'The value of $arr[4] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.4_T4.js.
     */
    public function testS1544410A14T4(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-6, -6);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr->length, 'The value of $arr->length is expected to be 0');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.5_T1.js.
     */
    public function testS1544410A15T1(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(3, null);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(3, $arr[0], 'The value of $arr[0] is expected to be 3');
        self::assertSame(4, $arr[1], 'The value of $arr[1] is expected to be 4');
        self::assertNull($arr[2], 'The value of $arr[2] is expected to equal null');
    }

    /**
     * test/built-ins/Array/prototype/slice/S15.4.4.10_A1.5_T2.js.
     */
    public function testS1544410A15T2(): void
    {
        $x = new Arr(0, 1, 2, 3, 4);
        $arr = $x->slice(-2);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertSame(3, $arr[0], 'The value of $arr[0] is expected to be 3');
        self::assertSame(4, $arr[1], 'The value of $arr[1] is expected to be 4');
        self::assertNull($arr[2], 'The value of $arr[2] is expected to equal null');
    }

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.1_T1.js
    // Reason: start given as float (2.5); Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.1_T2.js
    // Reason: start given as NaN; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.1_T3.js
    // Reason: start given as Infinity; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.1_T4.js
    // Reason: start given as -Infinity; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.1_T5.js
    // Reason: start given as object with valueOf; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.2_T1.js
    // Reason: end given as float (4.5); Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.2_T2.js
    // Reason: end given as NaN; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.2_T3.js
    // Reason: end given as Infinity; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.2_T4.js
    // Reason: end given as -Infinity; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2.2_T5.js
    // Reason: end given as object with valueOf; Arr::slice() is typed int

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T1.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T2.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T3.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T4.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T5.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A2_T6.js
    // Reason: slice called with array-like `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A3_T1.js
    // Reason: array-like `this` with length > 2^32-1; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A3_T2.js
    // Reason: array-like `this` with length > 2^32-1; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A3_T3.js
    // Reason: array-like `this` with negative length; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/S15.4.4.10_A4_T1.js
    // Reason: elements inherited from Array.prototype; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/call-with-boolean.js
    // Reason: slice called on a boolean primitive; ToObject coercion is JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/coerced-start-end-grow.js
    // Reason: TypedArrays backed by resizable ArrayBuffers; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/coerced-start-end-shrink.js
    // Reason: TypedArrays backed by resizable ArrayBuffers; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-ctor-non-object.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-ctor-poisoned.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-non-array-invalid-len.js
    // Reason: array-like `this` with invalid length getter; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-non-array.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-proto-from-ctor-realm-array.js
    // Reason: realms and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-proto-from-ctor-realm-non-array.js
    // Reason: realms and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-proxied-array-invalid-len.js
    // Reason: Proxy with invalid length; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-proxy.js
    // Reason: Proxy and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-revoked-proxy.js
    // Reason: revoked Proxy; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-abrupt.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-neg-zero.js
    // Reason: @@species and -0; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-non-ctor.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-null.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-poisoned.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species-undef.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/create-species.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/length-exceeding-integer-limit-proxied-array.js
    // Reason: Proxy with length near 2^53-1; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/slice/length-exceeding-integer-limit.js
    // Reason: array-like with length near 2^53-1; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/slice/length.js
    // Reason: `length` property of the function; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/name.js
    // Reason: `name` property of the function; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/not-a-constructor.js
    // Reason: [[Construct]] internal method; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/prop-desc.js
    // Reason: property descriptor of Array.prototype.slice; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/resizable-buffer.js
    // Reason: TypedArrays backed by resizable ArrayBuffers; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/target-array-non-extensible.js
    // Reason: @@species and non-extensible objects; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/target-array-with-non-configurable-property.js
    // Reason: @@species and property descriptors; JS-only

    // SKIPPED: test/built-ins/Array/prototype/slice/target-array-with-non-writable-property.js
    // Reason: @@species and property descriptors; JS-only
}
