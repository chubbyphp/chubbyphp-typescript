<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.reduceRight tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeReduceRightTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-1.js
    // Reason: this coercion (call on undefined)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-10.js
    // Reason: this coercion (call on the Math object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-11.js
    // Reason: this coercion (call on a Date object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-12.js
    // Reason: this coercion (call on a RegExp object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-13.js
    // Reason: this coercion (call on the JSON object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-14.js
    // Reason: this coercion (call on an Error object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-15.js
    // Reason: this coercion (call on the Arguments object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-2.js
    // Reason: this coercion (call on null)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-3.js
    // Reason: this coercion (call on a boolean primitive)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-4.js
    // Reason: this coercion (call on a Boolean object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-5.js
    // Reason: this coercion (call on a number primitive)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-6.js
    // Reason: this coercion (call on a Number object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-7.js
    // Reason: this coercion (call on a string primitive)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-8.js
    // Reason: this coercion (call on a String object)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-1-9.js
    // Reason: this coercion (call on a Function object)

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-1.js.
     */
    public function test154422101(): void
    {
        $callbackfn = static fn (): int => 1;

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $srcArr->reduceRight($callbackfn);

        self::assertSame(1, $srcArr[0], 'The value of $srcArr[0] is expected to be 1');
        self::assertSame(2, $srcArr[1], 'The value of $srcArr[1] is expected to be 2');
        self::assertSame(3, $srcArr[2], 'The value of $srcArr[2] is expected to be 3');
        self::assertSame(4, $srcArr[3], 'The value of $srcArr[3] is expected to be 4');
        self::assertSame(5, $srcArr[4], 'The value of $srcArr[4] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-2.js.
     */
    public function test154422102(): void
    {
        $callbackfn = static fn (string $prevVal, string $curVal): string => $prevVal.$curVal;

        $srcArr = new Arr('1', '2', '3', '4', '5');

        self::assertSame('54321', $srcArr->reduceRight($callbackfn), '$srcArr->reduceRight($callbackfn) is expected to be "54321"');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-3.js
    // Reason: subclassed Array

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-4.js
    // Reason: subclassed Array

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-5.js.
     */
    public function test154422105(): void
    {
        $callbackfn = static fn (string $prevVal, string $curVal): string => $prevVal.$curVal;

        $srcArr = new Arr('1', '2', '3', '4', '5');

        self::assertSame('654321', $srcArr->reduceRight($callbackfn, '6'), '$srcArr->reduceRight($callbackfn, "6") is expected to be "654321"');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-6.js
    // Reason: subclassed Array

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-7.js
    // Reason: subclassed Array

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-10-8.js.
     */
    public function test154422108(): void
    {
        $callCnt = 0;

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use (&$callCnt): mixed {
            ++$callCnt;

            return $curVal;
        };

        $srcArr = new Arr('1', '2', '3', '4', '5');
        $srcArr['i'] = 10;
        $srcArr[true] = 11;
        $srcArr->reduceRight($callbackfn);

        self::assertSame(4, $callCnt, 'The value of $callCnt is expected to be 4');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-1.js
    // Reason: array-like object with own 'length' data property

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-10.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-11.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-12.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-13.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-14.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-17.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-18.js
    // Reason: String object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-19.js
    // Reason: Function object as this

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-2.js.
     */
    public function test15442222(): void
    {
        $accessed = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx, Arr $obj) use (&$accessed): bool {
            $accessed = true;

            return 2 === $obj->length;
        };

        self::assertTrue((new Arr(12, 11))->reduceRight($callbackfn, 11), '(new Arr(12, 11))->reduceRight($callbackfn, 11) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-3.js
    // Reason: prototype-chain 'length' on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-4.js
    // Reason: Array.prototype.length override

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-5.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-6.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-7.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-8.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-2-9.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-1.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-10.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-11.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-12.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-13.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-14.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-15.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-16.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-17.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-18.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-19.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-2.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-20.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-21.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-22.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-23.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-24.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-25.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-3.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-4.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-5.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-6.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-7.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-3-9.js

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-1.js.
     */
    public function test15442241(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing argument on purpose
        $arr->reduceRight();
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-11.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-12.js.
     */
    public function test154422412(): void
    {
        $initialValue = 0;

        $callbackfn = static fn (int $accum, int $val): int => $accum + $val;

        self::assertSame(20, (new Arr(11, 9))->reduceRight($callbackfn, $initialValue), '(new Arr(11, 9))->reduceRight($callbackfn, $initialValue) is expected to be 20');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-15.js
    // Reason: 'length' and index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-2.js
    // Reason: JS ReferenceError for an unreferenced identifier has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-3.js.
     */
    public function test15442243(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->reduceRight(null);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-4.js.
     */
    public function test15442244(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->reduceRight(true);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-5.js.
     */
    public function test15442245(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->reduceRight(5);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-6.js.
     */
    public function test15442246(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->reduceRight('abc');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-7.js.
     */
    public function test15442247(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->reduceRight(new \stdClass());
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-8.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-4-9.js
    // Reason: 'length' toString coercion side effects on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-1.js.
     */
    public function test15442251(): void
    {
        $cb = static function (): void {};

        $this->expectException(\TypeError::class);

        (new Arr())->reduceRight($cb);
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-10.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-11.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-12.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-13.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-2.js.
     */
    public function test15442252(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr (null is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = null;

        $cb = static function (): void {};

        $this->expectException(\TypeError::class);

        $f->reduceRight($cb);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-3.js.
     */
    public function test15442253(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr (false is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = false;

        $cb = static function (): void {};

        $this->expectException(\TypeError::class);

        $f->reduceRight($cb);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-4.js.
     */
    public function test15442254(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the Arr.
        $f = new Arr(1, 2, 3);
        $f->length = 0;

        $cb = static function (): void {};

        $this->expectException(\TypeError::class);

        $f->reduceRight($cb);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-5.js.
     */
    public function test15442255(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr ('0' is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = '0';

        $cb = static function (): void {};

        $this->expectException(\TypeError::class);

        $f->reduceRight($cb);
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-6.js
    // Reason: length valueOf coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-7.js
    // Reason: length toString coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-8.js
    // Reason: length array coercion; Arr length only accepts int-like values

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-5-9.js.
     */
    public function test15442259(): void
    {
        $initialValue = 10;

        self::assertSame($initialValue, (new Arr())->reduceRight(static function (): void {}, $initialValue), '(new Arr())->reduceRight(static function (): void {}, $initialValue) is expected to be 10');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-1.js.
     */
    public function test15442271(): void
    {
        $cb = static function (): void {};

        self::assertSame(1, (new Arr())->reduceRight($cb, 1), '(new Arr())->reduceRight($cb, 1) is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-10.js.
     */
    public function test154422710(): void
    {
        $str = 'initialValue is present';

        self::assertSame($str, (new Arr())->reduceRight(static function (): void {}, $str), '(new Arr())->reduceRight(static function (): void {}, $str) is expected to be $str');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-11.js.
     */
    public function test154422711(): void
    {
        $str = 'initialValue is not present';

        self::assertSame($str, Arr::of($str)->reduceRight(static function (): void {}), 'Arr::of($str)->reduceRight(static function (): void {}) is expected to be $str');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-2.js.
     */
    public function test15442272(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr (null is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = null;

        $cb = static function (): void {};

        self::assertSame(1, $f->reduceRight($cb, 1), '$f->reduceRight($cb, 1) is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-3.js.
     */
    public function test15442273(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr (false is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = false;

        $cb = static function (): void {};

        self::assertSame(1, $f->reduceRight($cb, 1), '$f->reduceRight($cb, 1) is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-4.js.
     */
    public function test15442274(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the Arr.
        $f = new Arr(1, 2, 3);
        $f->length = 0;

        $cb = static function (): void {};

        self::assertSame(1, $f->reduceRight($cb, 1), '$f->reduceRight($cb, 1) is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-5.js.
     */
    public function test15442275(): void
    {
        // Adapted: JS subclasses Array; here the length is set directly on the
        // Arr ('0' is coerced to length 0).
        $f = new Arr(1, 2, 3);
        $f->length = '0';

        $cb = static function (): void {};

        self::assertSame(1, $f->reduceRight($cb, 1), '$f->reduceRight($cb, 1) is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-6.js
    // Reason: length valueOf coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-7.js
    // Reason: length toString coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-8.js
    // Reason: length array coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-7-9.js
    // Reason: length array coercion; Arr length only accepts int-like values

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-1.js
    // Reason: index accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-2.js
    // Reason: index accessor property modifying 'length' on an Array

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-3.js
    // Reason: index accessor properties (getter call counting)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-ii-1.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-ii-2.js
    // Reason: 'length' accessor property side effects on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-1.js.
     */
    public function test1544228BIII11(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult): void {
            if (0 === $idx) {
                $testResult = (1 === $prevVal);
            }
        };

        // JS array-like object adapted to an Arr.
        (new Arr(0, 1))->reduceRight($callbackfn);

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-19.js
    // Reason: index accessor property without getter / Object.prototype pollution

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-2.js.
     */
    public function test1544228BIII12(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult): void {
            if (1 === $idx) {
                $testResult = (2 === $prevVal);
            }
        };

        (new Arr(0, 1, 2))->reduceRight($callbackfn);

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-20.js
    // Reason: index accessor property without getter / Array.prototype pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-28.js
    // Reason: String object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-29.js
    // Reason: Function object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-3.js
    // Reason: prototype-chain data properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-30.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-31.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-32.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-33.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-7.js
    // Reason: prototype-chain data properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-b-iii-1-9.js
    // Reason: index accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-1.js.
     */
    public function test1544228C1(): void
    {
        $callbackfn = static function (): void {};

        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->reduceRight($callbackfn);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-2.js.
     */
    public function test1544228C2(): void
    {
        $callbackfn = static function (): void {};

        $arr = new Arr(10);
        $arr[9] = 1;
        $arr->length = 5;

        $this->expectException(\TypeError::class);

        $arr->reduceRight($callbackfn);
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-3.js.
     */
    public function test1544228C3(): void
    {
        $callbackfn = static function (): void {};

        $arr = new Arr(1, 2, 3, 4, 5);
        unset($arr[0], $arr[1], $arr[2], $arr[3], $arr[4]);

        $this->expectException(\TypeError::class);

        $arr->reduceRight($callbackfn);
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-5.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-6.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-7.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-8-c-8.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-1.js.
     */
    public function test15442291(): void
    {
        $arr = new Arr(5);
        $arr[0] = '1';
        $arr[1] = 2;
        $arr[3] = 4;
        $arr[4] = '5';

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use ($arr): mixed {
            $arr[5] = 6;
            $arr[2] = 3;

            // JS '+' concatenates when either operand is a string.
            return \is_string($prevVal) || \is_string($curVal) ? $prevVal.$curVal : $prevVal + $curVal;
        };

        self::assertSame('54321', $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be "54321"');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-2.js.
     */
    public function test15442292(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $prevVal, int $curVal) use ($arr): int {
            $arr[3] = -2;
            $arr[0] = -1;

            return $prevVal + $curVal;
        };

        self::assertSame(13, $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be 13');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-3.js.
     */
    public function test15442293(): void
    {
        $arr = new Arr('1', 2, 3, 4, 5);

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use ($arr): mixed {
            unset($arr[1], $arr[4]);

            // JS '+' concatenates when either operand is a string.
            return \is_string($prevVal) || \is_string($curVal) ? $prevVal.$curVal : $prevVal + $curVal;
        };

        // two elements deleted
        self::assertSame('121', $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be "121"');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-4.js.
     */
    public function test15442294(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $prevVal, int $curVal) use ($arr): int {
            $arr->length = 2;

            return $prevVal + $curVal;
        };

        self::assertSame(12, $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be 12');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-5.js.
     */
    public function test15442295(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): int {
            ++$callCnt;

            return 2;
        };

        $arr = Arr::of(1);

        self::assertSame(1, $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be 1');
        self::assertSame(0, $callCnt, 'The value of $callCnt is expected to be 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-6.js
    // Reason: Array.prototype index pollution

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-7.js.
     */
    public function test15442297(): void
    {
        $o = new \stdClass();
        $o->arr = new Arr('1', 2, 3, 4, 5);

        // Adapted: JS deletes the 'arr' property; the project CS forbids unset() on
        // properties, so it is cleared by assigning null instead.
        $callbackfn = static function (mixed $prevVal, mixed $curVal) use ($o): mixed {
            $o->arr = null;

            // JS '+' concatenates when either operand is a string.
            return \is_string($prevVal) || \is_string($curVal) ? $prevVal.$curVal : $prevVal + $curVal;
        };

        $arr = $o->arr;

        self::assertSame('141', $arr->reduceRight($callbackfn), '$o->arr->reduceRight($callbackfn) is expected to be "141"');
        self::assertNull($o->arr, 'The value of $o->arr is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-8.js.
     */
    public function test15442298(): void
    {
        $callbackAccessed = false;

        $callbackfn = static function () use (&$callbackAccessed): void {
            $callbackAccessed = true;
        };

        // Adapted: the JS test uses an index getter on an array-like object of
        // length 0; with Arr only the callback invocation is observable.
        $obj = new Arr();

        self::assertSame('initialValue', $obj->reduceRight($callbackfn, 'initialValue'), '$obj->reduceRight($callbackfn, "initialValue") is expected to be "initialValue"');
        self::assertFalse($callbackAccessed, 'The value of $callbackAccessed is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-9.js.
     */
    public function test15442299(): void
    {
        $called = 0;

        $arr = new Arr(0, 1, 2, 3, 4);

        // Adapted: the JS test decreases the length from an index getter at index
        // 4; here the callback decreases it on the first (idx 4) call instead.
        $callbackfn = static function (mixed $preVal, mixed $val, int $idx) use (&$called, $arr): void {
            ++$called;
            if (4 === $idx) {
                $arr->length = 2;
            }
        };

        $arr->reduceRight($callbackfn, 'initialValue');

        self::assertSame(3, $called, 'The value of $called is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-1.js.
     */
    public function test1544229B1(): void
    {
        $callbackfn = static function (): void {};

        $arr = new Arr(10);

        self::assertSame(5, $arr->reduceRight($callbackfn, 5), '$arr->reduceRight($callbackfn, 5) is expected to be 5');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-10.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-11.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-12.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-13.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-14.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-15.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-16.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-17.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-18.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-19.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-2.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-20.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-21.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-22.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-23.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-24.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-25.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-26.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-27.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-28.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-29.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-3.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-4.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-5.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-6.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-7.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-8.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-b-9.js
    // Reason: index accessor properties

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-1.js.
     */
    public function test1544229C1(): void
    {
        $callCnt = 0;

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use (&$callCnt): mixed {
            ++$callCnt;

            return $curVal;
        };

        $arr = new Arr(10);
        $arr[0] = null; // explicitly assigning a value
        $arr[1] = null;

        self::assertNull($arr->reduceRight($callbackfn), 'The value of $arr->reduceRight($callbackfn) is expected to be null');
        self::assertSame(1, $callCnt, 'The value of $callCnt is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-1.js
    // Reason: array-like object with 'length' smaller than its indexed properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-19.js
    // Reason: index accessor property without getter / Object.prototype pollution

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-2.js.
     */
    public function test1544229CI2(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult): void {
            if (1 === $idx) {
                $testResult = (1 === $curVal);
            }
        };

        (new Arr(0, 1, 2))->reduceRight($callbackfn, 'initialValue');

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-20.js
    // Reason: index accessor property without getter / Array.prototype pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-28.js
    // Reason: String object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-29.js
    // Reason: Function object as this

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-3.js
    // Reason: prototype-chain data properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-30.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-31.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-32.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-33.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-7.js
    // Reason: prototype-chain data properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-i-9.js
    // Reason: index accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-1.js.
     */
    public function test1544229CII1(): void
    {
        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx, Arr $obj): mixed {
            if ($idx + 1 < $obj->length && $obj[$idx] === $curVal && $obj[$idx + 1] === $prevVal) {
                return $curVal;
            }

            return false;
        };

        $arr = new Arr(0, 1, true, null, new \stdClass(), 'five');

        self::assertSame(0, $arr->reduceRight($callbackfn), '$arr->reduceRight($callbackfn) is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-10.js.
     */
    public function test1544229CII10(): void
    {
        $called = 0;

        $callbackfn = static function (mixed $prevVal) use (&$called): mixed {
            ++$called;

            return $prevVal;
        };

        self::assertSame(100, (new Arr(11, 12))->reduceRight($callbackfn, 100), '(new Arr(11, 12))->reduceRight($callbackfn, 100) is expected to be 100');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-11.js.
     */
    public function test1544229CII11(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, int $curVal) use (&$testResult): bool {
            if (100 === $prevVal) {
                $testResult = true;
            }

            return $curVal > 10;
        };

        self::assertTrue(Arr::of(11)->reduceRight($callbackfn, 100), 'Arr::of(11)->reduceRight($callbackfn, 100) is expected to be true');
        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-12.js.
     */
    public function test1544229CII12(): void
    {
        $testResult = false;
        $arr = new Arr(11, 12, 13);
        $initVal = 6.99;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult, $initVal): bool {
            if (2 === $idx) {
                $testResult = ($prevVal === $initVal);
            }

            $args = \func_get_args();

            return $curVal > 10 && $args[3][$idx] === $curVal;
        };

        self::assertTrue($arr->reduceRight($callbackfn, $initVal), '$arr->reduceRight($callbackfn, $initVal) is expected to be true');
        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-13.js.
     */
    public function test1544229CII13(): void
    {
        $arr = new Arr(11, 12, 13);
        $initVal = 6.99;
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx, Arr $obj) use (&$testResult, $initVal): bool {
            if (2 === $idx) {
                $testResult = ($prevVal === $initVal);
            }

            return $curVal > 10 && $obj[$idx] === $curVal;
        };

        self::assertTrue($arr->reduceRight($callbackfn, $initVal), '$arr->reduceRight($callbackfn, $initVal) is expected to be true');
        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-14.js.
     */
    public function test1544229CII14(): void
    {
        $callbackfn = static function (): bool {
            $args = \func_get_args();

            return 100 === $args[0] && $args[3][$args[2]] === $args[1];
        };

        self::assertTrue(Arr::of(11)->reduceRight($callbackfn, 100), 'Arr::of(11)->reduceRight($callbackfn, 100) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-16.js.
     */
    public function test1544229CII16(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use (&$testResult): void {
            if (8 === $prevVal || 8 === $curVal) {
                $testResult = true;
            }
        };

        // JS array-like object adapted to a sparse Arr; non-index keys become properties.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[10] = 12;
        $obj['non_index_property'] = 8;

        $obj->reduceRight($callbackfn, 'initialValue');

        self::assertFalse($testResult, 'The value of $testResult is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-17.js.
     */
    public function test1544229CII17(): void
    {
        $arr = new Arr(11, 12, 13);
        $testResult = true;
        $initVal = 6.99;
        $preResult = $initVal;

        $callbackfn = static function (mixed $prevVal, mixed $curVal) use (&$testResult, &$preResult): mixed {
            if ($prevVal !== $preResult) {
                $testResult = false;
            }
            $preResult = $curVal;

            return $curVal;
        };

        $arr->reduceRight($callbackfn, $initVal);

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-18.js.
     */
    public function test1544229CII18(): void
    {
        $arr = new Arr(11, 12);
        $testResult = false;
        $initVal = 6.99;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult, $initVal): mixed {
            if (1 === $idx) {
                $testResult = ($prevVal === $initVal);
            }

            return $curVal;
        };

        $arr->reduceRight($callbackfn, $initVal);

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-19.js.
     */
    public function test1544229CII19(): void
    {
        $arr = new Arr(11, 12, 13);
        $testResult = false;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$testResult): mixed {
            if (1 === $idx) {
                $testResult = (13 === $prevVal);
            }

            return $curVal;
        };

        $arr->reduceRight($callbackfn);

        self::assertTrue($testResult, 'The value of $testResult is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-2.js.
     */
    public function test1544229CII2(): void
    {
        $initialValue = 5.5;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx, Arr $obj) use ($initialValue): mixed {
            if ($idx === $obj->length - 1 && $obj[$idx] === $curVal && $prevVal === $initialValue) {
                return $curVal;
            }

            if ($idx + 1 < $obj->length && $obj[$idx] === $curVal && $obj[$idx + 1] === $prevVal) {
                return $curVal;
            }

            return false;
        };

        $arr = new Arr(0, 1, true, null, new \stdClass(), 'five');

        self::assertSame(0, $arr->reduceRight($callbackfn, $initialValue), '$arr->reduceRight($callbackfn, $initialValue) is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-20.js.
     */
    public function test1544229CII20(): void
    {
        $accessed = false;

        // JS undefined -> PHP null; an explicitly passed null counts as initialValue.
        $callbackfn = static function (mixed $prevVal) use (&$accessed): bool {
            $accessed = true;

            return null === $prevVal;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, null), '$obj->reduceRight($callbackfn, null) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-21.js.
     */
    public function test1544229CII21(): void
    {
        $accessed = false;

        $callbackfn = static function (mixed $prevVal) use (&$accessed): bool {
            $accessed = true;

            return null === $prevVal;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, null), '$obj->reduceRight($callbackfn, null) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-22.js.
     */
    public function test1544229CII22(): void
    {
        $accessed = false;

        $callbackfn = static function (mixed $prevVal) use (&$accessed): bool {
            $accessed = true;

            return false === $prevVal;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, false), '$obj->reduceRight($callbackfn, false) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-23.js.
     */
    public function test1544229CII23(): void
    {
        $accessed = false;

        $callbackfn = static function (mixed $prevVal) use (&$accessed): bool {
            $accessed = true;

            return 12 === $prevVal;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, 12), '$obj->reduceRight($callbackfn, 12) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-24.js.
     */
    public function test1544229CII24(): void
    {
        $accessed = false;

        $callbackfn = static function (mixed $prevVal) use (&$accessed): bool {
            $accessed = true;

            return 'hello_' === $prevVal;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, 'hello_'), '$obj->reduceRight($callbackfn, "hello_") is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-25.js.
     */
    public function test1544229CII25(): void
    {
        $accessed = false;
        $objFunction = static function (): void {};

        $callbackfn = static function (mixed $prevVal) use (&$accessed, $objFunction): bool {
            $accessed = true;

            return $prevVal === $objFunction;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, $objFunction), '$obj->reduceRight($callbackfn, $objFunction) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-26.js.
     */
    public function test1544229CII26(): void
    {
        $accessed = false;
        $objArray = new Arr();

        $callbackfn = static function (mixed $prevVal) use (&$accessed, $objArray): bool {
            $accessed = true;

            return $prevVal === $objArray;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, $objArray), '$obj->reduceRight($callbackfn, $objArray) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-27.js
    // Reason: String wrapper object as accumulator

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-28.js
    // Reason: Boolean wrapper object as accumulator

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-29.js
    // Reason: Number wrapper object as accumulator

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-3.js.
     */
    public function test1544229CII3(): void
    {
        $bCalled = false;

        $callbackfn = static function (mixed $prevVal) use (&$bCalled): bool {
            $bCalled = true;

            return true === $prevVal && 4 === \func_num_args();
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertTrue($arr->reduceRight($callbackfn, true), '$arr->reduceRight($callbackfn, true) is expected to be true');
        self::assertTrue($bCalled, 'The value of $bCalled is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-30.js
    // Reason: the Math object as accumulator

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-31.js.
     */
    public function test1544229CII31(): void
    {
        $accessed = false;
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = static function (mixed $prevVal) use (&$accessed, $objDate): bool {
            $accessed = true;

            return $prevVal === $objDate;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, $objDate), '$obj->reduceRight($callbackfn, $objDate) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-32.js
    // Reason: RegExp object as accumulator

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-33.js
    // Reason: the JSON object as accumulator

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-34.js.
     */
    public function test1544229CII34(): void
    {
        $accessed = false;
        $objError = new RangeError();

        $callbackfn = static function (mixed $prevVal) use (&$accessed, $objError): bool {
            $accessed = true;

            return $prevVal === $objError;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, $objError), '$obj->reduceRight($callbackfn, $objError) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-35.js.
     */
    public function test1544229CII35(): void
    {
        $accessed = false;

        // JS Arguments object adapted to the args array.
        $arg = (static fn (): array => \func_get_args())(10, 11, 12, 13);

        $callbackfn = static function (mixed $prevVal) use (&$accessed, $arg): bool {
            $accessed = true;

            return $prevVal === $arg;
        };

        $obj = Arr::of(11);

        self::assertTrue($obj->reduceRight($callbackfn, $arg), '$obj->reduceRight($callbackfn, $arg) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-37.js
    // Reason: the global object as accumulator

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-4-s.js
    // Reason: JS strict-mode 'this' semantics for unbound callbacks

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-4.js.
     */
    public function test1544229CII4(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4, 5);
        $lastIdx = $arr->length - 1;
        $accessed = false;
        $result = true;

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$lastIdx, &$accessed, &$result): void {
            $accessed = true;
            if ($lastIdx !== $idx) {
                $result = false;
            } else {
                --$lastIdx;
            }
        };

        $arr->reduceRight($callbackfn, 1);

        self::assertTrue($result, 'The value of $result is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-5.js.
     */
    public function test1544229CII5(): void
    {
        $arr = new Arr(11, 12, 13, 14);
        $kIndex = [];
        $result = true;
        $called = 0;

        // By below way, we could verify that k would be set as length - 1, ..., 1, 0 in order, and each value will be set one time.
        $callbackfn = static function (mixed $preVal, mixed $curVal, int $idx) use (&$kIndex, &$result, &$called, $arr): void {
            // Each position should be visited one time, which means k is accessed one time during iterations.
            ++$called;
            if (!isset($kIndex[$idx])) {
                // when current position is visited, its next index should have been visited.
                if ($idx !== $arr->length - 1 && !isset($kIndex[$idx + 1])) {
                    $result = false;
                }
                $kIndex[$idx] = 1;
            } else {
                $result = false;
            }
        };

        $arr->reduceRight($callbackfn, 1);

        self::assertTrue($result, 'The value of $result is expected to be true');
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-7.js.
     */
    public function test1544229CII7(): void
    {
        $accessed = false;
        $exception = new \Exception('Exception occurred in callbackfn');

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$accessed, $exception): void {
            if ($idx < 10) {
                $accessed = true;
            }
            if (10 === $idx) {
                throw $exception;
            }
        };

        // JS array-like object adapted to a sparse Arr.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[4] = 10;
        $obj[10] = 8;

        try {
            $obj->reduceRight($callbackfn, 1);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertFalse($accessed, 'The value of $accessed is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-8.js.
     */
    public function test1544229CII8(): void
    {
        $accessed = false;

        $obj = new Arr(11, 12);

        $callbackfn = static function (mixed $prevVal, mixed $curVal, int $idx) use (&$accessed, $obj): bool {
            $accessed = true;
            if (1 === $idx) {
                $obj[$idx - 1] = 8;
            }

            return $curVal > 10;
        };

        self::assertFalse($obj->reduceRight($callbackfn, 1), '$obj->reduceRight($callbackfn, 1) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/reduceRight/15.4.4.22-9-c-ii-9.js.
     */
    public function test1544229CII9(): void
    {
        $called = 0;

        $callbackfn = static function () use (&$called): bool {
            ++$called;

            return true;
        };

        self::assertTrue((new Arr(11, 12))->reduceRight($callbackfn, 11), '(new Arr(11, 12))->reduceRight($callbackfn, 11) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/call-with-boolean.js
    // Reason: this coercion (call on boolean primitives)

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/callbackfn-resize-arraybuffer.js
    // Reason: TypedArray / ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/length-near-integer-limit.js
    // Reason: array-like object with 'length' near 2^53; Arr caps length at 2^32-1

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/length.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/name.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/prop-desc.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/resizable-buffer-grow-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/resizable-buffer-shrink-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/reduceRight/resizable-buffer.js
    // Reason: TypedArray / resizable ArrayBuffer
}
