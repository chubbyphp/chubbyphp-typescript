<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.indexOf tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeIndexOfTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-1.js
    // Reason: this-coercion of undefined; Arr methods always have an Arr instance

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-10.js
    // Reason: applied to the Math object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-11.js
    // Reason: applied to Date object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-12.js
    // Reason: applied to RegExp object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-13.js
    // Reason: applied to the JSON object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-14.js
    // Reason: applied to Error object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-15.js
    // Reason: applied to Arguments object (array-like this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-2.js
    // Reason: this-coercion of null

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-3.js
    // Reason: applied to boolean primitive (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-4.js
    // Reason: applied to Boolean object (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-5.js
    // Reason: applied to number primitive (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-6.js
    // Reason: applied to Number object (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-7.js
    // Reason: applied to string primitive (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-8.js
    // Reason: applied to String object (ToObject coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-1-9.js
    // Reason: applied to Function object (array-like this-coercion)

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-10-1.js.
     */
    public function test154414101(): void
    {
        $a = new Arr();
        $a[100] = 1;
        $a[99999] = '';
        $a[10] = new \stdClass();
        $a[5555] = 5.5;
        $a[123456] = 'str';
        $a[5] = 1E+309; // Infinity

        self::assertSame(100, $a->indexOf(1), '$a->indexOf(1) must return 100');
        self::assertSame(99999, $a->indexOf(''), '$a->indexOf("") must return 99999');
        self::assertSame(123456, $a->indexOf('str'), '$a->indexOf("str") must return 123456');
        self::assertSame(5, $a->indexOf(1E+309), '$a->indexOf(1E+309) must return 5');
        self::assertSame(5555, $a->indexOf(5.5), '$a->indexOf(5.5) must return 5555');

        self::assertSame(-1, $a->indexOf(true), '$a->indexOf(true) must return -1');
        self::assertSame(-1, $a->indexOf(5), '$a->indexOf(5) must return -1');
        self::assertSame(-1, $a->indexOf('str1'), '$a->indexOf("str1") must return -1');
        self::assertSame(-1, $a->indexOf(null), '$a->indexOf(null) must return -1');
        self::assertSame(-1, $a->indexOf(new \stdClass()), '$a->indexOf(new \stdClass()) must return -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-10-2.js
    // Reason: accessor property (getter) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-1.js
    // Reason: 'length' of array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-10.js
    // Reason: inherited accessor 'length' on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-11.js
    // Reason: accessor 'length' without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-12.js
    // Reason: accessor 'length' overriding inherited accessor

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-13.js
    // Reason: inherited accessor 'length' without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-14.js
    // Reason: array-like object without 'length'

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-17.js
    // Reason: applied to Arguments object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-18.js
    // Reason: applied to String object with prototype-chain trick

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-19.js
    // Reason: applied to Function object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-2.js
    // Reason: elements inherited from Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-3.js
    // Reason: 'length' inherited via prototype chain on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-4.js
    // Reason: overriding Array.prototype.length

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-5.js
    // Reason: 'length' descriptor tricks on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-6.js
    // Reason: inherited data 'length' on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-7.js
    // Reason: accessor 'length' on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-8.js
    // Reason: accessor 'length' overriding inherited data property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-2-9.js
    // Reason: accessor 'length' overriding inherited accessor

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-1.js
    // Reason: 'length' coercion (undefined) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-10.js
    // Reason: 'length' coercion (NaN) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-11.js
    // Reason: 'length' coercion (numeric string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-12.js
    // Reason: 'length' coercion (negative numeric string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-13.js
    // Reason: 'length' coercion (decimal string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-14.js
    // Reason: 'length' coercion (+/-Infinity string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-15.js
    // Reason: 'length' coercion (exponential string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-16.js
    // Reason: 'length' coercion (hex string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-17.js
    // Reason: 'length' coercion (leading-zeros string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-18.js
    // Reason: 'length' coercion (non-numeric string) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-19.js
    // Reason: 'length' coercion via toString on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-2.js
    // Reason: 'length' coercion (boolean) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-20.js
    // Reason: 'length' coercion via valueOf on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-21.js
    // Reason: 'length' coercion via valueOf/toString on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-22.js
    // Reason: 'length' coercion throwing TypeError on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-23.js
    // Reason: 'length' coercion via inherited valueOf on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-24.js
    // Reason: 'length' coercion (positive non-integer) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-25.js
    // Reason: 'length' coercion (negative non-integer) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-28.js
    // Reason: array-like 'length' of 2^32 (Arr caps length at 2^32-1)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-29.js
    // Reason: array-like 'length' of 2^32+1 (Arr caps length at 2^32-1)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-3.js
    // Reason: 'length' value 0 on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-4.js
    // Reason: 'length' value +0 on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-5.js
    // Reason: 'length' value -0 on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-6.js
    // Reason: 'length' positive number on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-7.js
    // Reason: 'length' negative number on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-8.js
    // Reason: 'length' Infinity on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-3-9.js
    // Reason: 'length' -Infinity on array-like object (this-coercion)

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-4-1.js.
     */
    public function test15441441(): void
    {
        $i = (new Arr())->indexOf(42);

        self::assertSame(-1, $i, 'The value of $i is expected to be -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-10.js
    // Reason: 'length' -6e-1 on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-11.js
    // Reason: 'length' empty string on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-2.js
    // Reason: 'length' null on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-3.js
    // Reason: 'length' false on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-4.js
    // Reason: generic array-like object with length 0 (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-5.js
    // Reason: 'length' string '0' on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-6.js
    // Reason: 'length' coercion via valueOf on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-7.js
    // Reason: 'length' coercion via toString on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-8.js
    // Reason: 'length' coercion of empty array on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-4-9.js
    // Reason: 'length' 0.1 on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-1.js
    // Reason: fromIndex given as string; Arr::indexOf() fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-10.js.
     */
    public function test154414510(): void
    {
        $targetObj = new \stdClass();

        self::assertSame(-1, (new Arr(0, $targetObj, 2))->indexOf($targetObj, 2), '(new Arr(0, $targetObj, 2))->indexOf($targetObj, 2) must return -1');
        self::assertSame(2, (new Arr(0, 1, $targetObj))->indexOf($targetObj, 2), '(new Arr(0, 1, $targetObj))->indexOf($targetObj, 2) must return 2');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-11.js.
     */
    public function test154414511(): void
    {
        $targetObj = new \stdClass();

        self::assertSame(-1, (new Arr(0, $targetObj, 2))->indexOf($targetObj, -1), '(new Arr(0, $targetObj, 2))->indexOf($targetObj, -1) must return -1');
        self::assertSame(2, (new Arr(0, 1, $targetObj))->indexOf($targetObj, -1), '(new Arr(0, 1, $targetObj))->indexOf($targetObj, -1) must return 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-12.js
    // Reason: fromIndex Infinity; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-13.js
    // Reason: fromIndex -Infinity; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-14.js
    // Reason: fromIndex NaN; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-15.js
    // Reason: fromIndex string "-1"; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-16.js
    // Reason: fromIndex string "Infinity"; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-17.js
    // Reason: fromIndex string "-Infinity"; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-18.js
    // Reason: fromIndex string "3E0"; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-19.js
    // Reason: fromIndex hex string; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-2.js
    // Reason: fromIndex floating point number; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-20.js
    // Reason: fromIndex string with leading zeros; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-21.js
    // Reason: fromIndex object with toString; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-22.js
    // Reason: fromIndex object with valueOf; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-23.js
    // Reason: fromIndex object with valueOf/toString; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-24.js
    // Reason: fromIndex object coercion throwing TypeError; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-25.js
    // Reason: fromIndex object with inherited valueOf; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-26.js
    // Reason: side effects of 'length' getter vs fromIndex valueOf ordering

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-27.js
    // Reason: side effects of 'length' coercion vs fromIndex valueOf ordering

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-28.js
    // Reason: ToObject(this) exception ordering vs fromIndex valueOf

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-29.js
    // Reason: 'length' getter exception ordering vs fromIndex valueOf

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-3.js
    // Reason: fromIndex boolean; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-30.js
    // Reason: 'length' valueOf exception ordering vs fromIndex valueOf

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-31.js
    // Reason: fromIndex positive non-integer 2.5; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-32.js
    // Reason: fromIndex negative non-integer -1.5; Arr::indexOf() fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-33.js.
     */
    public function test154414533(): void
    {
        self::assertSame(0, (new Arr(0, 1, 2, 3, 4))->indexOf(0, 0), '(new Arr(0, 1, 2, 3, 4))->indexOf(0, 0) must return 0');
        self::assertSame(2, (new Arr(0, 1, 2, 3, 4))->indexOf(2, 1), '(new Arr(0, 1, 2, 3, 4))->indexOf(2, 1) must return 2');
        self::assertSame(2, (new Arr(0, 1, 2, 3, 4))->indexOf(2, 2), '(new Arr(0, 1, 2, 3, 4))->indexOf(2, 2) must return 2');
        self::assertSame(4, (new Arr(0, 1, 2, 3, 4))->indexOf(4, 2), '(new Arr(0, 1, 2, 3, 4))->indexOf(4, 2) must return 4');
        self::assertSame(4, (new Arr(0, 1, 2, 3, 4))->indexOf(4, 4), '(new Arr(0, 1, 2, 3, 4))->indexOf(4, 4) must return 4');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-4.js.
     */
    public function test15441454(): void
    {
        $a = new Arr(1, 2, 3);

        // JS `undefined` fromIndex maps to an omitted argument in PHP (resolves to 0)
        self::assertSame(0, $a->indexOf(1), '$a->indexOf(1) must return 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-5-5.js
    // Reason: fromIndex null; Arr::indexOf() fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-6.js.
     */
    public function test15441456(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4);
        // 'fromIndex' will be set as 0 if not passed by default

        self::assertSame($arr->indexOf(0, 0), $arr->indexOf(0), '$arr->indexOf(0) is expected to equal $arr->indexOf(0, 0)');
        self::assertSame($arr->indexOf(2, 0), $arr->indexOf(2), '$arr->indexOf(2) is expected to equal $arr->indexOf(2, 0)');
        self::assertSame($arr->indexOf(4, 0), $arr->indexOf(4), '$arr->indexOf(4) is expected to equal $arr->indexOf(4, 0)');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-7.js.
     */
    public function test15441457(): void
    {
        self::assertSame(0, (new Arr(true))->indexOf(true, 0), '(new Arr(true))->indexOf(true, 0) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-8.js.
     */
    public function test15441458(): void
    {
        self::assertSame(0, (new Arr(true))->indexOf(true, +0), '(new Arr(true))->indexOf(true, +0) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-5-9.js.
     */
    public function test15441459(): void
    {
        // PHP integers have no -0; -0 is simply 0
        self::assertSame(0, (new Arr(true))->indexOf(true, -0), '(new Arr(true))->indexOf(true, -0) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-6-1.js.
     */
    public function test15441461(): void
    {
        $a = new Arr(1, 2, 3);

        self::assertSame(-1, $a->indexOf(1, 5), '$a->indexOf(1, 5) must return -1');
        self::assertSame(-1, $a->indexOf(1, 3), '$a->indexOf(1, 3) must return -1');
        self::assertSame(-1, (new Arr())->indexOf(1, 0), '(new Arr())->indexOf(1, 0) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-7-1.js.
     */
    public function test15441471(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3))->indexOf(1, 2), '(new Arr(1, 2, 3))->indexOf(1, 2) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-7-2.js.
     */
    public function test15441472(): void
    {
        self::assertSame(2, (new Arr(1, 2, 3))->indexOf(3, 2), '(new Arr(1, 2, 3))->indexOf(3, 2) must return 2');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-7-3.js.
     */
    public function test15441473(): void
    {
        self::assertSame(-1, (new Arr())->indexOf(1, 0), '(new Arr())->indexOf(1, 0) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-7-4.js.
     */
    public function test15441474(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3))->indexOf(1, 1), '(new Arr(1, 2, 3))->indexOf(1, 1) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-7-5.js.
     */
    public function test15441475(): void
    {
        self::assertSame(1, (new Arr(1, 2, 3))->indexOf(2, 1), '(new Arr(1, 2, 3))->indexOf(2, 1) must return 1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-8-1.js.
     */
    public function test15441481(): void
    {
        $a = new Arr(1, 2, 3);

        self::assertSame(-1, $a->indexOf(2, -1), '$a->indexOf(2, -1) must return -1');
        self::assertSame(1, $a->indexOf(2, -2), '$a->indexOf(2, -2) must return 1');
        self::assertSame(0, $a->indexOf(1, -3), '$a->indexOf(1, -3) must return 0');
        // JS asserts a.indexOf(1, -5.3) === 0 (truncated to -5); Arr::indexOf() fromIndex is
        // typed int, so the truncated value is used directly
        self::assertSame(0, $a->indexOf(1, -5), '$a->indexOf(1, -5) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-8-2.js.
     */
    public function test15441482(): void
    {
        self::assertSame(3, (new Arr(1, 2, 3, 4))->indexOf(4, -1), '(new Arr(1, 2, 3, 4))->indexOf(4, -1) must return 3');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-8-3.js.
     */
    public function test15441483(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3, 4))->indexOf(1, -3), '(new Arr(1, 2, 3, 4))->indexOf(1, -3) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-8-4.js.
     */
    public function test15441484(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3, 4))->indexOf(0, -4), '(new Arr(1, 2, 3, 4))->indexOf(0, -4) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-1.js.
     */
    public function test15441491(): void
    {
        // JS `undefined` and `null` elements both map to PHP null
        $obj = new \stdClass();
        $false = false;
        $a = new Arr($obj, 'true', null, 0, $false, null, 1, 'str', 0, 1, true, false, true, false);

        self::assertSame(10, $a->indexOf(true), '$a[10] = true');
        self::assertSame(4, $a->indexOf(false), '$a[4] = $false');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-10.js.
     */
    public function test154414910(): void
    {
        $nan = NAN;
        $a = new Arr('NaN', null, 0, false, null, new \stdClass(), 'false', $nan, NAN);

        self::assertSame(-1, $a->indexOf(NAN), 'NaN is equal to nothing, including itself.');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-11.js
    // Reason: accessor property (getter) adding elements during iteration

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-2.js.
     */
    public function test15441492(): void
    {
        $obj = new \stdClass();
        $one = 1;
        $float = -(4 / 3);
        $a = new Arr(false, null, null, '0', $obj, -1.3333333333333, 'str', -0.0, true, +0, $one, 1, 0, false, $float, -(4 / 3));

        self::assertSame(14, $a->indexOf(-(4 / 3)), '$a[14] = $float === -(4/3)');
        self::assertSame(7, $a->indexOf(0), '$a[7] = -0.0, 0 === -0.0');
        self::assertSame(7, $a->indexOf(-0.0), '$a[7] = -0.0, -0.0 === -0.0');
        self::assertSame(10, $a->indexOf(1), '$a[10] = $one === 1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-3.js.
     */
    public function test15441493(): void
    {
        $obj = new \stdClass();
        $szFalse = 'false';
        $a = new Arr('false1', null, 0, false, null, 1, $obj, 0, $szFalse, 'false');

        self::assertSame(8, $a->indexOf('false'), '$a[8] = $szFalse');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-4.js.
     */
    public function test15441494(): void
    {
        $obj = new \stdClass();
        $undefined1 = null;
        $undefined2 = null;
        $a = new Arr(true, 0, false, null, 1, 'undefined', $obj, 1, $undefined2, $undefined1, null);

        // JS expects index 8 because `null` (index 3) !== `undefined`; PHP conflates JS
        // undefined and null into null, so the JS null at index 3 is the first match
        self::assertSame(3, $a->indexOf(null), '$a[3] = null (JS null and undefined conflate to PHP null)');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-5.js.
     */
    public function test15441495(): void
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = $obj1;
        $a = new Arr(false, null, 0, false, null, new \stdClass(), 'false', $obj2, $obj1, $obj3);

        self::assertSame(8, $a->indexOf($obj3), '$a[8] = $obj1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-6.js.
     */
    public function test15441496(): void
    {
        $obj = new \stdClass();
        $null = null;
        $a = new Arr(true, null, 0, false, $null, 1, 'str', 0, 1, $obj, true, false, null);

        // JS expects index 4 because `undefined` (index 1) !== `null`; PHP conflates JS
        // undefined and null into null, so the JS undefined at index 1 is the first match
        self::assertSame(1, $a->indexOf(null), '$a[1] = null (JS null and undefined conflate to PHP null)');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-7.js.
     */
    public function test15441497(): void
    {
        $a = new Arr(0, 1, 2, 3);
        $a[2] = $a;

        self::assertSame(2, $a->indexOf($a), '$a->indexOf($a) must return 2');
        self::assertSame(3, $a->indexOf(3), '$a->indexOf(3) must return 3');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-8.js.
     */
    public function test15441498(): void
    {
        $b = new Arr('0,1');
        $a = new Arr(0, $b, '0,1', 3);

        self::assertSame(2, $a->indexOf($b->toString()), '$a->indexOf($b->toString()) must return 2');
        self::assertSame(2, $a->indexOf('0,1'), '$a->indexOf("0,1") must return 2');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-9.js.
     */
    public function test15441499(): void
    {
        $a = new Arr(0, 1);
        $a[4294967294] = 2; // 2^32-2 - is max array element
        $a[4294967295] = 3; // 2^32-1 added as non-array element property
        $a[4294967296] = 4; // 2^32   added as non-array element property
        $a[4294967297] = 5; // 2^32+1 added as non-array element property

        // start searching near the end so in case implementation actually tries to test all missing elements!!

        self::assertSame(4294967294, $a->indexOf(2, 4294967290), '$a->indexOf(2, 4294967290) must return 4294967294');
        self::assertSame(-1, $a->indexOf(3, 4294967290), '$a->indexOf(3, 4294967290) must return -1');
        self::assertSame(-1, $a->indexOf(4, 4294967290), '$a->indexOf(4, 4294967290) must return -1');
        self::assertSame(-1, $a->indexOf(5, 4294967290), '$a->indexOf(5, 4294967290) must return -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-1.js
    // Reason: 'length' getter side effects (Object.defineProperty)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-10.js
    // Reason: getter adding Array.prototype index properties during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-11.js
    // Reason: getter deleting own property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-12.js
    // Reason: getter deleting own property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-13.js
    // Reason: getter deleting Object.prototype property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-14.js
    // Reason: getter deleting Array.prototype property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-15.js
    // Reason: prototype-chain fallback after deleting own property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-16.js
    // Reason: prototype-chain fallback after deleting own property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-17.js
    // Reason: getter decreasing array length during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-18.js
    // Reason: prototype index property visited after length decrease

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-19.js
    // Reason: non-configurable property descriptor behavior

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-2.js
    // Reason: fromIndex valueOf side effects; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-3.js
    // Reason: fromIndex valueOf side effects; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-4.js
    // Reason: 'length' getter side effects (Object.defineProperty)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-5.js
    // Reason: fromIndex valueOf side effects; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-6.js
    // Reason: fromIndex valueOf side effects; Arr::indexOf() fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-7.js
    // Reason: getter adding own property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-8.js
    // Reason: getter adding own property during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-a-9.js
    // Reason: getter adding Object.prototype property during iteration

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-1.js.
     */
    public function test1544149B1(): void
    {
        // JS `undefined` search maps to PHP null; the hole at index 1 must not match
        $arr = new Arr(3);
        $arr[0] = 0;
        $arr[2] = 2;

        self::assertSame(-1, $arr->indexOf(null), '$arr->indexOf(null) must return -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-1.js
    // Reason: element retrieval on array-like object (this-coercion)

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-10.js
    // Reason: accessor properties (getters) on array-like object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-11.js
    // Reason: accessor property overriding inherited data property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-12.js
    // Reason: accessor property overriding inherited data property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-13.js
    // Reason: accessor property overriding inherited accessor property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-14.js
    // Reason: accessor property overriding inherited accessor property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-15.js
    // Reason: elements inherited from Array.prototype accessors

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-16.js
    // Reason: elements inherited from Object.prototype accessors

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-17.js
    // Reason: accessor property without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-18.js
    // Reason: accessor property without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-19.js
    // Reason: accessor property without get function

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-2.js.
     */
    public function test1544149BI2(): void
    {
        self::assertSame(0, (new Arr(true, true, true))->indexOf(true), '(new Arr(true, true, true))->indexOf(true) must return 0');
        self::assertSame(1, (new Arr(false, true, true))->indexOf(true), '(new Arr(false, true, true))->indexOf(true) must return 1');
        self::assertSame(2, (new Arr(false, false, true))->indexOf(true), '(new Arr(false, false, true))->indexOf(true) must return 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-20.js
    // Reason: accessor property without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-21.js
    // Reason: inherited accessor property without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-22.js
    // Reason: inherited accessor property without get function

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-25.js
    // Reason: applied to Arguments object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-26.js
    // Reason: applied to Arguments object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-27.js
    // Reason: applied to Arguments object

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-28.js
    // Reason: getter side effects across iterations

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-29.js
    // Reason: getter side effects across iterations

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-3.js
    // Reason: overriding Array.prototype index properties

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-30.js
    // Reason: getter throwing during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-31.js
    // Reason: getter throwing during iteration

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-4.js
    // Reason: overriding Object.prototype index properties

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-5.js
    // Reason: data property overriding inherited accessor property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-6.js
    // Reason: data property overriding inherited accessor property

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-7.js
    // Reason: elements inherited from Array.prototype

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-8.js
    // Reason: elements inherited from Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-i-9.js
    // Reason: accessor properties (getters) on an Array

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-1.js.
     */
    public function test1544149BII1(): void
    {
        self::assertSame(-1, (new Arr('true'))->indexOf(true), '(new Arr("true"))->indexOf(true) must return -1');
        self::assertSame(-1, (new Arr('0'))->indexOf(0), '(new Arr("0"))->indexOf(0) must return -1');
        self::assertSame(-1, (new Arr(false))->indexOf(0), '(new Arr(false))->indexOf(0) must return -1');
        self::assertSame(-1, (new Arr(null))->indexOf(0), '(new Arr(null))->indexOf(0) must return -1');
        self::assertSame(-1, (new Arr(new Arr()))->indexOf(0), '(new Arr(new Arr()))->indexOf(0) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-10.js.
     */
    public function test1544149BII10(): void
    {
        self::assertSame(1, (new Arr(false, true))->indexOf(true), '(new Arr(false, true))->indexOf(true) must return 1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-11.js.
     */
    public function test1544149BII11(): void
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = $obj2;

        self::assertSame(2, (new Arr(new \stdClass(), $obj1, $obj2))->indexOf($obj3), '(new Arr(new \stdClass(), $obj1, $obj2))->indexOf($obj3) must return 2');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-2.js.
     */
    public function test1544149BII2(): void
    {
        // JS `undefined` element and search both map to PHP null
        self::assertSame(0, (new Arr(null))->indexOf(), '(new Arr(null))->indexOf() must return 0');
        self::assertSame(0, (new Arr(null))->indexOf(null), '(new Arr(null))->indexOf(null) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-3.js.
     */
    public function test1544149BII3(): void
    {
        self::assertSame(0, (new Arr(null))->indexOf(null), '(new Arr(null))->indexOf(null) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-4.js.
     */
    public function test1544149BII4(): void
    {
        self::assertSame(-1, (new Arr(+NAN, NAN, -NAN))->indexOf(NAN), '(new Arr(+NAN, NAN, -NAN))->indexOf(NAN) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-5.js.
     */
    public function test1544149BII5(): void
    {
        self::assertSame(-1, (new Arr(+NAN, NAN, -NAN))->indexOf(-NAN), '(new Arr(+NAN, NAN, -NAN))->indexOf(-NAN) must return -1');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-6.js.
     */
    public function test1544149BII6(): void
    {
        $a = new Arr();
        $a[0] = +0;

        self::assertSame(0, $a->indexOf(-0.0), '$a->indexOf(-0.0) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-7.js.
     */
    public function test1544149BII7(): void
    {
        $a = new Arr();
        $a[0] = -0.0;

        self::assertSame(0, $a->indexOf(+0), '$a->indexOf(+0) must return 0');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-8.js.
     */
    public function test1544149BII8(): void
    {
        self::assertSame(2, (new Arr(-1, 0, 1))->indexOf(1), '(new Arr(-1, 0, 1))->indexOf(1) must return 2');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-ii-9.js.
     */
    public function test1544149BII9(): void
    {
        self::assertSame(3, (new Arr('', 'ab', 'bca', 'abc'))->indexOf('abc'), '(new Arr("", "ab", "bca", "abc"))->indexOf("abc") must return 3');
    }

    /**
     * test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-iii-1.js.
     */
    public function test1544149BIII1(): void
    {
        self::assertSame(1, (new Arr(1, 2, 2, 1, 2))->indexOf(2), '(new Arr(1, 2, 2, 1, 2))->indexOf(2) must return 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/15.4.4.14-9-b-iii-2.js
    // Reason: accessor properties (getters) tracking element access

    // SKIPPED: test/built-ins/Array/prototype/indexOf/call-with-boolean.js
    // Reason: this-coercion of boolean primitive

    // SKIPPED: test/built-ins/Array/prototype/indexOf/calls-only-has-on-prototype-after-length-zeroed.js
    // Reason: Proxy traps and fromIndex valueOf side effects

    // SKIPPED: test/built-ins/Array/prototype/indexOf/coerced-searchelement-fromindex-grow.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/indexOf/coerced-searchelement-fromindex-shrink.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    /**
     * test/built-ins/Array/prototype/indexOf/fromindex-zero-conversion.js.
     */
    public function testFromindexZeroConversion(): void
    {
        // JS asserts 1 / [true].indexOf(true, -0) === +Infinity (the result is +0, not -0);
        // PHP integers have no -0, so the result is plain int 0
        self::assertSame(0, (new Arr(true))->indexOf(true, -0), '(new Arr(true))->indexOf(true, -0) must return 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/length-near-integer-limit.js
    // Reason: array-like object with length near 2^53-1 (Arr caps length at 2^32-1)

    /**
     * test/built-ins/Array/prototype/indexOf/length-zero-returns-minus-one.js.
     */
    public function testLengthZeroReturnsMinusOne(): void
    {
        // The JS test passes a fromIndex object whose valueOf throws to prove length is
        // checked first; Arr::indexOf() fromIndex is typed int, so a plain int is used
        self::assertSame(-1, (new Arr())->indexOf(1), '(new Arr())->indexOf(1) must return -1');
        self::assertSame(-1, (new Arr())->indexOf(2, 0), '(new Arr())->indexOf(2, 0) must return -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/indexOf/length.js

    // SKIPPED: test/built-ins/Array/prototype/indexOf/name.js

    // SKIPPED: test/built-ins/Array/prototype/indexOf/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/indexOf/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/indexOf/resizable-buffer-special-float-values.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/indexOf/resizable-buffer.js
    // Reason: TypedArrays backed by resizable ArrayBuffers
}
