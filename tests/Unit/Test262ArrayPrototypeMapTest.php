<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.map tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeMapTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-1.js
    // Reason: this coercion (call on undefined)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-10.js
    // Reason: this coercion (call on the Math object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-11.js
    // Reason: this coercion (call on a Date object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-12.js
    // Reason: this coercion (call on a RegExp object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-13.js
    // Reason: this coercion (call on the JSON object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-14.js
    // Reason: this coercion (call on an Error object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-15.js
    // Reason: this coercion (call on the Arguments object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-2.js
    // Reason: this coercion (call on null)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-3.js
    // Reason: this coercion (call on a boolean primitive)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-4.js
    // Reason: this coercion (call on a Boolean object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-5.js
    // Reason: this coercion (call on a number primitive)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-6.js
    // Reason: this coercion (call on a Number object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-7.js
    // Reason: this coercion (call on a string primitive)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-8.js
    // Reason: this coercion (call on a String object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-1-9.js
    // Reason: this coercion (call on a Function object)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-1.js
    // Reason: array-like object with own 'length' data property

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-10.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-11.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-12.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-13.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-14.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-17.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-18.js
    // Reason: String object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-19.js
    // Reason: Function object as this

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-2-2.js.
     */
    public function test15441922(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        $testResult = (new Arr(12, 11))->map($callbackfn);

        self::assertSame(2, $testResult->length, 'The value of $testResult->length is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-3.js
    // Reason: Array.prototype 'length' override

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-4.js
    // Reason: Array.prototype 'length' override

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-5.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-6.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-7.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-8.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-2-9.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-1.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-11.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-12.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-13.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-14.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-15.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-16.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-17.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-18.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-19.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-2.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-20.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-21.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-22.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-23.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-24.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-25.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-28.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-29.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-3.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-4.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-5.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-6.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-7.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-8.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-3-9.js
    // Reason: 'length' accessor property throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-1.js.
     */
    public function test15441941(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing argument on purpose
        $arr->map();
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-11.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-12.js.
     */
    public function test154419412(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        $testResult = (new Arr(11, 9))->map($callbackfn);

        self::assertSame(2, $testResult->length, 'The value of $testResult->length is expected to be 2');
        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
        self::assertFalse($testResult[1], 'The value of $testResult[1] is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-15.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-2.js
    // Reason: ReferenceError for an unresolved identifier is a JS-only concern

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-3.js.
     */
    public function test15441943(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->map(null);
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-4.js.
     */
    public function test15441944(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->map(true);
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-5.js.
     */
    public function test15441945(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->map(5);
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-6.js.
     */
    public function test15441946(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->map('abc');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-4-7.js.
     */
    public function test15441947(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->map(new \stdClass());
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-8.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-4-9.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-1-s.js
    // Reason: JS strict-mode 'this' semantics for unbound callbacks

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-1.js
    // Reason: JS global object as default 'this' for unbound callbacks

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-10.js.
     */
    public function test154419510(): void
    {
        $objArray = new Arr(2);

        $callbackfn = fn (): bool => $this === $objArray;

        $testResult = Arr::of(11)->map($callbackfn, $objArray);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-11.js
    // Reason: String wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-12.js
    // Reason: Boolean wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-13.js
    // Reason: Number wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-14.js
    // Reason: the Math object as thisArg

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-15.js.
     */
    public function test154419515(): void
    {
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = fn (): bool => $this === $objDate;

        $testResult = Arr::of(11)->map($callbackfn, $objDate);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-16.js
    // Reason: RegExp object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-17.js
    // Reason: the JSON object as thisArg

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-18.js.
     */
    public function test154419518(): void
    {
        $objError = new RangeError();

        $callbackfn = fn (): bool => $this === $objError;

        $testResult = Arr::of(11)->map($callbackfn, $objError);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-19.js
    // Reason: the Arguments object as thisArg

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-2.js.
     */
    public function test15441952(): void
    {
        $o = new \stdClass();
        $o->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->map($callbackfn, $o);

        self::assertTrue($resArr[0], 'The value of $resArr[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-21.js
    // Reason: the global object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-22.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-23.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-24.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-3.js.
     */
    public function test15441953(): void
    {
        $a = new Arr();
        $a['res'] = true;

        $callbackfn = fn (): bool => true === $this['res'];

        $srcArr = Arr::of(1);
        $resArr = $srcArr->map($callbackfn, $a);

        self::assertTrue($resArr[0], 'The value of $resArr[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-4.js.
     */
    public function test15441954(): void
    {
        // JS: property inherited from the constructor prototype; PHP: property declared on the class.
        $f = new class {
            public bool $res = true;
        };

        $callbackfn = fn (): bool => $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->map($callbackfn, $f);

        self::assertTrue($resArr[0], 'The value of $resArr[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-5-5.js.
     */
    public function test15441955(): void
    {
        $f = new \stdClass();
        $f->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->map($callbackfn, $f);

        self::assertTrue($resArr[0], 'The value of $resArr[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-6.js
    // Reason: function as thisArg; PHP Closures do not support dynamic properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-7.js
    // Reason: built-in function (eval) as thisArg

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-5-9.js
    // Reason: Function object as thisArg; PHP Closures do not support dynamic properties

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-6-1.js.
     */
    public function test15441961(): void
    {
        $newArr = Arr::of(11)->map(static function (): void {});

        self::assertTrue(Arr::isArray($newArr), 'Arr::isArray($newArr) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-6-2.js.
     */
    public function test15441962(): void
    {
        $newArr = Arr::of(11)->map(static function (): void {});

        self::assertInstanceOf(Arr::class, $newArr, 'The result of evaluating ($newArr instanceof Arr) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-1.js.
     */
    public function test15441981(): void
    {
        $srcArr = new Arr(5);
        $srcArr[0] = 1;
        $srcArr[1] = 2;
        $srcArr[3] = 4;
        $srcArr[4] = 5;

        $callbackfn = static function () use ($srcArr): int {
            $srcArr[2] = 3;
            $srcArr[5] = 6;

            return 1;
        };

        $resArr = $srcArr->map($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-2.js.
     */
    public function test15441982(): void
    {
        $srcArr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($srcArr): int {
            $srcArr[4] = -1;

            return $val > 0 ? 1 : 0;
        };

        $resArr = $srcArr->map($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
        self::assertSame(0, $resArr[4], 'The value of $resArr[4] is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-3.js.
     */
    public function test15441983(): void
    {
        $srcArr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($srcArr): int {
            unset($srcArr[4]);

            return $val > 0 ? 1 : 0;
        };

        $resArr = $srcArr->map($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
        self::assertNull($resArr[4], 'The value of $resArr[4] is expected to be null');
        self::assertFalse(isset($resArr[4]), 'The value of isset($resArr[4]) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-4.js.
     */
    public function test15441984(): void
    {
        $callCnt = 0;
        $srcArr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function () use ($srcArr, &$callCnt): int {
            $srcArr->length = 2;
            ++$callCnt;

            return 1;
        };

        $resArr = $srcArr->map($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
        self::assertSame(2, $callCnt, 'The value of $callCnt is expected to be 2');
        self::assertNull($resArr[2], 'The value of $resArr[2] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-5.js.
     */
    public function test15441985(): void
    {
        $callCnt = 0;
        $srcArr = new Arr(10);
        $srcArr[1] = 1;
        $srcArr[2] = 2;

        $callbackfn = static function (mixed $val) use ($srcArr, &$callCnt): mixed {
            $srcArr[1000] = 3;
            ++$callCnt;

            return $val;
        };

        $resArr = $srcArr->map($callbackfn);

        self::assertSame(10, $resArr->length, 'The value of $resArr->length is expected to be 10');
        self::assertSame(2, $callCnt, 'The value of $callCnt is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-6.js
    // Reason: Array.prototype index pollution

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-7.js.
     */
    public function test15441987(): void
    {
        $o = new \stdClass();
        $o->srcArr = new Arr(1, 2, 3, 4, 5);

        // Adapted: JS deletes the 'srcArr' property; the project CS forbids unset() on
        // properties, so it is cleared by assigning null instead.
        $callbackfn = static function (int $val) use ($o): int {
            $o->srcArr = null;

            return $val > 0 ? 1 : 0;
        };

        $srcArr = $o->srcArr;

        $resArr = $srcArr->map($callbackfn);

        self::assertSame('1,1,1,1,1', $resArr->toString(), 'The value of $resArr->toString() is expected to be "1,1,1,1,1"');
        self::assertNull($o->srcArr, 'The value of $o->srcArr is expected to be null');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-8.js
    // Reason: array-like object with 'length' 0

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-9.js
    // Reason: index accessor property (getter decreasing length)

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-b-1.js.
     */
    public function test1544198B1(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): int {
            ++$callCnt;

            return 1;
        };

        $srcArr = new Arr(10);
        $srcArr[1] = null; // explicitly assigning a value
        $resArr = $srcArr->map($callbackfn);

        self::assertSame(10, $resArr->length, 'The value of $resArr->length is expected to be 10');
        self::assertSame(1, $callCnt, 'The value of $callCnt is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-10.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-11.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-12.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-13.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-14.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-15.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-16.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-2.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-3.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-4.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-5.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-6.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-7.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-8.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-b-9.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-1.js
    // Reason: array-like object

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-19.js
    // Reason: index accessor property without getter / Array.prototype pollution

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-2.js.
     */
    public function test1544198CI2(): void
    {
        $kValue = new \stdClass();

        $callbackfn = static function (mixed $val, int $idx) use ($kValue): bool {
            if (0 === $idx) {
                return $val === $kValue;
            }

            return false;
        };

        $newArr = Arr::of($kValue)->map($callbackfn);

        self::assertTrue($newArr[0], 'The value of $newArr[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-20.js
    // Reason: index accessor property without getter / prototype-chain

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-28.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-29.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-3.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-30.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-31.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-7.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-i-9.js
    // Reason: index accessor properties on an array-like object

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-1.js.
     */
    public function test1544198CII1(): void
    {
        $bPar = true;
        $bCalled = false;

        $callbackfn = static function (mixed $val, int $idx, Arr $obj) use (&$bPar, &$bCalled): void {
            $bCalled = true;
            if ($obj[$idx] !== $val) {
                $bPar = false;
            }
        };

        $srcArr = new Arr(0, 1, true, null, new \stdClass(), 'five');
        $srcArr[999999] = -6.6;
        $srcArr->map($callbackfn);

        self::assertTrue($bCalled, 'The value of $bCalled is expected to be true');
        self::assertTrue($bPar, 'The value of $bPar is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-10.js.
     */
    public function test1544198CII10(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        $testResult = Arr::of(11)->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-11.js.
     */
    public function test1544198CII11(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            $args = \func_get_args();

            return $val > 10 && $args[2][$idx] === $val;
        };

        $testResult = Arr::of(11)->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-12.js.
     */
    public function test1544198CII12(): void
    {
        $callbackfn = static fn (int $val, int $idx, Arr $obj): bool => $val > 10 && $obj[$idx] === $val;

        $testResult = Arr::of(11)->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-13.js.
     */
    public function test1544198CII13(): void
    {
        $callbackfn = static function (): bool {
            $args = \func_get_args();

            return $args[2][$args[1]] === $args[0];
        };

        $testResult = Arr::of(11)->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-16.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-17.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-18.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-19.js.
     */
    public function test1544198CII19(): void
    {
        $called = 0;
        $result = false;

        $callbackfn = static function (mixed $val) use (&$called, &$result): bool {
            ++$called;
            if (11 === $val) {
                $result = true;
            }

            return true;
        };

        // JS array-like object adapted to a sparse Arr; non-index keys become properties.
        $obj = new Arr(20);
        $obj[0] = 9;
        $obj['non_index_property'] = 11;

        $testResult = $obj->map($callbackfn);

        self::assertFalse($result, 'The value of $result is expected to be false');
        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
        self::assertSame(1, $called, 'The value of $called is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-2.js.
     */
    public function test1544198CII2(): void
    {
        $parCnt = 3;
        $bCalled = false;

        // verify if callbackfn was called with 3 parameters
        $callbackfn = static function () use (&$parCnt, &$bCalled): void {
            $bCalled = true;
            if (3 !== \func_num_args()) {
                $parCnt = \func_num_args();
            }
        };

        $srcArr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $srcArr->map($callbackfn);

        self::assertTrue($bCalled, 'The value of $bCalled is expected to be true');
        self::assertSame(3, $parCnt, 'The value of $parCnt is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-20.js.
     */
    public function test1544198CII20(): void
    {
        $callbackfn = fn (): bool => 10 === $this->threshold;

        $thisArg = new \stdClass();
        $thisArg->threshold = 10;

        $obj = new Arr(11, 9);

        $testResult = $obj->map($callbackfn, $thisArg);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-21.js.
     */
    public function test1544198CII21(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            if (0 === $idx) {
                return 11 === $val;
            }

            if (1 === $idx) {
                return 12 === $val;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        $testResult = $obj->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
        self::assertTrue($testResult[1], 'The value of $testResult[1] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-22.js.
     */
    public function test1544198CII22(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            if (11 === $val) {
                return 0 === $idx;
            }

            if (12 === $val) {
                return 1 === $idx;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        $testResult = $obj->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
        self::assertTrue($testResult[1], 'The value of $testResult[1] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-23.js.
     */
    public function test1544198CII23(): void
    {
        $obj = new Arr(2);
        $obj[0] = 11;

        $callbackfn = static fn (mixed $val, int $idx, Arr $o): bool => $obj === $o;

        $testResult = $obj->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-4.js.
     */
    public function test1544198CII4(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4, 5);
        $lastIdx = 0;
        $result = true;

        $callbackfn = static function (int $val, int $idx) use (&$lastIdx, &$called, &$result): void {
            ++$called;
            if ($lastIdx !== $idx) {
                $result = false;
            } else {
                ++$lastIdx;
            }
        };

        $arr->map($callbackfn);

        self::assertTrue($result, 'The value of $result is expected to be true');
        self::assertSame($arr->length, $called, 'The value of $called is expected to equal the value of $arr->length');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-5.js.
     */
    public function test1544198CII5(): void
    {
        $kIndex = [];

        // By below way, we could verify that k would be set as 0, 1, ..., length - 1 in order, and each value will be set one time.
        $callbackfn = static function (int $val, int $idx) use (&$kIndex): bool {
            // Each position should be visited one time, which means k is accessed one time during iterations.
            if (!isset($kIndex[$idx])) {
                // when current position is visited, its previous index should have been visited.
                if (0 !== $idx && !isset($kIndex[$idx - 1])) {
                    return true;
                }
                $kIndex[$idx] = 1;

                return false;
            }

            return true;
        };

        $testResult = (new Arr(11, 12, 13, 14))->map($callbackfn);

        self::assertSame(4, $testResult->length, 'The value of $testResult->length is expected to be 4');
        self::assertFalse($testResult[0], 'The value of $testResult[0] is expected to be false');
        self::assertFalse($testResult[1], 'The value of $testResult[1] is expected to be false');
        self::assertFalse($testResult[2], 'The value of $testResult[2] is expected to be false');
        self::assertFalse($testResult[3], 'The value of $testResult[3] is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-6.js.
     */
    public function test1544198CII6(): void
    {
        $obj = Arr::of(11);
        $thisArg = new \stdClass();

        $callbackfn = function () use ($thisArg, $obj): bool {
            $args = \func_get_args();

            return $this === $thisArg
                && 11 === $args[0]
                && 0 === $args[1]
                && $args[2] === $obj;
        };

        $testResult = $obj->map($callbackfn, $thisArg);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-7.js.
     */
    public function test1544198CII7(): void
    {
        $accessed = false;
        $exception = new \Exception('Exception occurred in callbackfn');

        $callbackfn = static function (mixed $val, int $idx) use (&$accessed, $exception): void {
            if ($idx > 0) {
                $accessed = true;
            }
            if (0 === $idx) {
                throw $exception;
            }
        };

        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[4] = 10;
        $obj[10] = 8;

        try {
            $obj->map($callbackfn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertFalse($accessed, 'The value of $accessed is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-8.js.
     */
    public function test1544198CII8(): void
    {
        $obj = new Arr(9, 12);

        $callbackfn = static function (int $val, int $idx) use ($obj): bool {
            if (0 === $idx) {
                $obj[$idx + 1] = 8;
            }

            return $val > 10;
        };

        $testResult = $obj->map($callbackfn);

        self::assertFalse($testResult[1], 'The value of $testResult[1] is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-ii-9.js.
     */
    public function test1544198CII9(): void
    {
        $callbackfn = static fn (): bool => true;

        $testResult = Arr::of(11)->map($callbackfn);

        self::assertTrue($testResult[0], 'The value of $testResult[0] is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-8-c-iii-1.js
    // Reason: property descriptor (writable/enumerable/configurable) of result elements

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-iii-2.js.
     */
    public function test1544198CIII2(): void
    {
        $callbackfn = static fn (mixed $val): mixed => $val;

        $obj = new Arr(11, 9);
        $newArr = $obj->map($callbackfn);

        self::assertSame($obj[0], $newArr[0], 'The value of $newArr[0] is expected to equal the value of $obj[0]');
        self::assertSame($obj[1], $newArr[1], 'The value of $newArr[1] is expected to equal the value of $obj[1]');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-iii-3.js.
     */
    public function test1544198CIII3(): void
    {
        $callbackfn = static fn (): int => 11;

        $obj = new Arr(11, 9);
        $newArr = $obj->map($callbackfn);

        // Adapted: JS uses newArr[1] += 1; PHP increment on an ArrayAccess offset would be
        // an indirect modification of an overloaded element, so read-modify-write explicitly.
        $tempVal = $newArr[1];
        $newArr[1] = $tempVal + 1;

        self::assertNotSame($tempVal, $newArr[1], 'The value of $newArr[1] is expected to not equal the value of $tempVal');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-iii-4.js.
     */
    public function test1544198CIII4(): void
    {
        $callbackfn = static fn (): bool => true;

        $obj = new Arr(2);
        $obj[0] = 11;
        $newArr = $obj->map($callbackfn);

        // Adapted: JS uses for-in enumeration with hasOwnProperty; PHP equivalent:
        // iterate the keys and check that the populated index 0 exists on the result.
        $enumerable = false;
        foreach ($newArr->keys() as $prop) {
            if (isset($newArr[$prop]) && 0 === $prop) {
                $enumerable = true;
            }
        }

        self::assertTrue($enumerable, 'The value of $enumerable is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-8-c-iii-5.js.
     */
    public function test1544198CIII5(): void
    {
        $callbackfn = static fn (): bool => true;

        $obj = new Arr(11, 9);
        $newArr = $obj->map($callbackfn);

        $tempVal = $newArr[1];
        unset($newArr[1]);

        self::assertNotNull($tempVal, 'The value of $tempVal is expected to not be null');
        self::assertNull($newArr[1], 'The value of $newArr[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-9-1.js.
     */
    public function test15441991(): void
    {
        $callbackfn = static fn (): bool => true;

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $srcArr->map($callbackfn);

        self::assertSame(1, $srcArr[0], 'The value of $srcArr[0] is expected to be 1');
        self::assertSame(2, $srcArr[1], 'The value of $srcArr[1] is expected to be 2');
        self::assertSame(3, $srcArr[2], 'The value of $srcArr[2] is expected to be 3');
        self::assertSame(4, $srcArr[3], 'The value of $srcArr[3] is expected to be 4');
        self::assertSame(5, $srcArr[4], 'The value of $srcArr[4] is expected to be 5');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-10.js
    // Reason: subclassed Array / length valueOf coercion

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-11.js
    // Reason: subclassed Array / length toString coercion

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-12.js
    // Reason: subclassed Array / length array coercion

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-9-13.js.
     */
    public function test154419913(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return $val > 2;
        };

        $arr = new Arr(1, 2, 3, 4);

        $arr->map($callbackfn);

        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(4, $arr[3], 'The value of $arr[3] is expected to be 4');
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-9-2.js.
     */
    public function test15441992(): void
    {
        $callbackfn = static fn (int $val): int => $val + 10;

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $resArr = $srcArr->map($callbackfn);

        self::assertSame(11, $resArr[0], 'The value of $resArr[0] is expected to be 11');
        self::assertSame(12, $resArr[1], 'The value of $resArr[1] is expected to be 12');
        self::assertSame(13, $resArr[2], 'The value of $resArr[2] is expected to be 13');
        self::assertSame(14, $resArr[3], 'The value of $resArr[3] is expected to be 14');
        self::assertSame(15, $resArr[4], 'The value of $resArr[4] is expected to be 15');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-3.js
    // Reason: subclassed Array when length is reduced

    /**
     * test/built-ins/Array/prototype/map/15.4.4.19-9-4.js.
     */
    public function test15441994(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): void {
            ++$callCnt;
        };

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $srcArr['i'] = 10;
        $srcArr[true] = 11;

        $srcArr->map($callbackfn);

        self::assertSame(5, $callCnt, 'The value of $callCnt is expected to be 5');
    }

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-5.js
    // Reason: array-like object with 'length' 0

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-6.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-7.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-8.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/map/15.4.4.19-9-9.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/map/call-with-boolean.js
    // Reason: this coercion (call on boolean primitives)

    // SKIPPED: test/built-ins/Array/prototype/map/callbackfn-resize-arraybuffer.js
    // Reason: TypedArray / ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/map/create-ctor-non-object.js
    // Reason: 'constructor' property lookup (ArraySpeciesCreate)

    // SKIPPED: test/built-ins/Array/prototype/map/create-ctor-poisoned.js
    // Reason: getter on 'constructor' (ArraySpeciesCreate)

    // SKIPPED: test/built-ins/Array/prototype/map/create-non-array-invalid-len.js
    // Reason: array-like with length > 2^32-1 (ArraySpeciesCreate)

    // SKIPPED: test/built-ins/Array/prototype/map/create-non-array.js
    // Reason: 'constructor' property lookup (ArraySpeciesCreate)

    // SKIPPED: test/built-ins/Array/prototype/map/create-proto-from-ctor-realm-array.js
    // Reason: realms / @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-proto-from-ctor-realm-non-array.js
    // Reason: realms / @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-proxy.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-revoked-proxy.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-abrupt.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-non-ctor.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-null.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-poisoned.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-undef-invalid-len.js
    // Reason: Proxy / @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species-undef.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/create-species.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/map/length.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/map/name.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/map/not-a-constructor.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/map/prop-desc.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/map/resizable-buffer-grow-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/map/resizable-buffer-shrink-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/map/resizable-buffer.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/map/target-array-non-extensible.js
    // Reason: @@species / non-extensible target

    // SKIPPED: test/built-ins/Array/prototype/map/target-array-with-non-configurable-property.js
    // Reason: @@species / non-configurable property on target

    // SKIPPED: test/built-ins/Array/prototype/map/target-array-with-non-writable-property.js
    // Reason: @@species / non-writable property on target
}
