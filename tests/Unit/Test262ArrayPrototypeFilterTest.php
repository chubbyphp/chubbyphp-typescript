<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.filter tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFilterTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-1.js
    // Reason: this coercion (call on undefined)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-10.js
    // Reason: this coercion (call on the Math object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-11.js
    // Reason: this coercion (call on a Date object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-12.js
    // Reason: this coercion (call on a RegExp object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-13.js
    // Reason: this coercion (call on the JSON object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-14.js
    // Reason: this coercion (call on an Error object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-15.js
    // Reason: this coercion (call on the Arguments object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-2.js
    // Reason: this coercion (call on null)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-3.js
    // Reason: this coercion (call on a boolean primitive)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-4.js
    // Reason: this coercion (call on a Boolean object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-5.js
    // Reason: this coercion (call on a number primitive)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-6.js
    // Reason: this coercion (call on a Number object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-7.js
    // Reason: this coercion (call on a string primitive)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-8.js
    // Reason: this coercion (call on a String object)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-1-9.js
    // Reason: this coercion (call on a Function object)

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-10-1.js.
     */
    public function test15442101(): void
    {
        $callbackfn = static fn (): bool => true;

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $srcArr->filter($callbackfn);

        self::assertSame(1, $srcArr[0], 'The value of $srcArr[0] is expected to be 1');
        self::assertSame(2, $srcArr[1], 'The value of $srcArr[1] is expected to be 2');
        self::assertSame(3, $srcArr[2], 'The value of $srcArr[2] is expected to be 3');
        self::assertSame(4, $srcArr[3], 'The value of $srcArr[3] is expected to be 4');
        self::assertSame(5, $srcArr[4], 'The value of $srcArr[4] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-10-2.js.
     */
    public function test15442102(): void
    {
        // JS relies on the numeric truthiness of (val % 2); PHP needs an explicit bool.
        $callbackfn = static fn (int $val): bool => 1 === $val % 2;

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(3, $resArr->length, 'The value of $resArr->length is expected to be 3');
        self::assertSame(1, $resArr[0], 'The value of $resArr[0] is expected to be 1');
        self::assertSame(3, $resArr[1], 'The value of $resArr[1] is expected to be 3');
        self::assertSame(5, $resArr[2], 'The value of $resArr[2] is expected to be 5');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-10-3.js
    // Reason: subclassed Array / length type conversion

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-10-4.js.
     */
    public function test15442104(): void
    {
        $callCnt = 0;

        // JS callbackfn returns undefined (falsy); PHP equivalent: void (null).
        $callbackfn = static function () use (&$callCnt): void {
            ++$callCnt;
        };

        $srcArr = new Arr(1, 2, 3, 4, 5);
        $srcArr['i'] = 10;
        $srcArr[true] = 11;

        $srcArr->filter($callbackfn);

        self::assertSame(5, $callCnt, 'The value of $callCnt is expected to be 5');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-1.js
    // Reason: array-like object with own 'length' data property

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-10.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-11.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-12.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-13.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-14.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-17.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-18.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-19.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-2.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-3.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-4.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-5.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-6.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-7.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-8.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-2-9.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-1.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-10.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-11.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-12.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-13.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-14.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-15.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-16.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-17.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-18.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-19.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-2.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-20.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-21.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-22.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-23.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-24.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-25.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-3.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-4.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-5.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-6.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-7.js

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-3-9.js

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-1.js.
     */
    public function test15442041(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing argument on purpose
        $arr->filter();
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-11.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-12.js.
     */
    public function test154420412(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            if (1 === $idx) {
                return 9 === $val;
            }

            return false;
        };

        $newArr = (new Arr(11, 9))->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(9, $newArr[0], 'The value of $newArr[0] is expected to be 9');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-15.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-2.js
    // Reason: JS ReferenceError for an unresolved identifier

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-3.js.
     */
    public function test15442043(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->filter(null);
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-4.js.
     */
    public function test15442044(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->filter(true);
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-5.js.
     */
    public function test15442045(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->filter(5);
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-6.js.
     */
    public function test15442046(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->filter('abc');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-4-7.js.
     */
    public function test15442047(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->filter(new \stdClass());
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-8.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-4-9.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-1-s.js
    // Reason: JS strict-mode 'this' semantics for unbound callbacks

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-1.js
    // Reason: JS global object as default 'this' for unbound callbacks

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-10.js.
     */
    public function test154420510(): void
    {
        $accessed = false;
        $objArray = new Arr(10);

        $callbackfn = function () use (&$accessed, $objArray): bool {
            $accessed = true;

            return $this === $objArray;
        };

        $newArr = Arr::of(11)->filter($callbackfn, $objArray);

        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-11.js
    // Reason: String wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-12.js
    // Reason: Boolean wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-13.js
    // Reason: Number wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-14.js
    // Reason: the Math object as thisArg

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-15.js.
     */
    public function test154420515(): void
    {
        $accessed = false;
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = function () use (&$accessed, $objDate): bool {
            $accessed = true;

            return $this === $objDate;
        };

        $newArr = Arr::of(11)->filter($callbackfn, $objDate);

        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-16.js
    // Reason: RegExp object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-17.js
    // Reason: the JSON object as thisArg

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-18.js.
     */
    public function test154420518(): void
    {
        $accessed = false;
        $objError = new RangeError();

        $callbackfn = function () use (&$accessed, $objError): bool {
            $accessed = true;

            return $this === $objError;
        };

        $newArr = Arr::of(11)->filter($callbackfn, $objError);

        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-19.js
    // Reason: the Arguments object as thisArg

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-2.js.
     */
    public function test15442052(): void
    {
        $o = new \stdClass();
        $o->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->filter($callbackfn, $o);

        self::assertSame(1, $resArr->length, 'The value of $resArr->length is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-21.js
    // Reason: the global object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-22.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-23.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-24.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-27.js.
     */
    public function test154420527(): void
    {
        $newArr = Arr::of(11)->filter(static function (): void {});

        self::assertTrue(Arr::isArray($newArr), 'Arr::isArray($newArr) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-28.js.
     */
    public function test154420528(): void
    {
        $newArr = Arr::of(11)->filter(static function (): void {});

        self::assertInstanceOf(Arr::class, $newArr, 'The result of evaluating ($newArr instanceof Arr) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-29.js.
     */
    public function test154420529(): void
    {
        $newArr = Arr::of(11)->filter(static function (): void {});

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-3.js.
     */
    public function test15442053(): void
    {
        $a = new Arr();
        $a['res'] = true;

        $callbackfn = fn (): bool => true === $this['res'];

        $srcArr = Arr::of(1);
        $resArr = $srcArr->filter($callbackfn, $a);

        self::assertSame(1, $resArr->length, 'The value of $resArr->length is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-30.js
    // Reason: JS unbound callbacks default 'this' to the global object; PHP closures keep
    // their original binding

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-4.js.
     */
    public function test15442054(): void
    {
        // JS: property inherited from the constructor prototype; PHP: property declared on the class.
        $f = new class {
            public bool $res = true;
        };

        $callbackfn = fn (): bool => $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->filter($callbackfn, $f);

        self::assertSame(1, $resArr->length, 'The value of $resArr->length is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-5-5.js.
     */
    public function test15442055(): void
    {
        $f = new \stdClass();
        $f->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $srcArr = Arr::of(1);
        $resArr = $srcArr->filter($callbackfn, $f);

        self::assertSame(1, $resArr->length, 'The value of $resArr->length is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-6.js
    // Reason: function as thisArg; PHP Closures do not support dynamic properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-7.js
    // Reason: built-in function (eval) as thisArg

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-5-9.js
    // Reason: Function object as thisArg; PHP Closures do not support dynamic properties

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-6-1.js.
     */
    public function test15442061(): void
    {
        $a = (new Arr())->filter(static function (): void {});

        self::assertTrue(Arr::isArray($a), 'Arr::isArray($a) is expected to be true');
        self::assertSame(0, $a->length, 'The value of $a->length is expected to be 0');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-2.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-3.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-4.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-5.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-6.js
    // Reason: subclassed Array / length valueOf coercion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-7.js
    // Reason: subclassed Array / length toString coercion

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-6-8.js
    // Reason: subclassed Array / length array coercion

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-1.js.
     */
    public function test15442091(): void
    {
        $srcArr = new Arr(5);
        $srcArr[0] = 1;
        $srcArr[1] = 2;
        $srcArr[3] = 4;
        $srcArr[4] = 5;

        $callbackfn = static function () use ($srcArr): bool {
            $srcArr[2] = 3;
            $srcArr[5] = 6;

            return true;
        };

        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-2.js.
     */
    public function test15442092(): void
    {
        $srcArr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($srcArr): bool {
            $srcArr[2] = -1;
            $srcArr[4] = -1;

            return $val > 0;
        };

        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(3, $resArr->length, 'The value of $resArr->length is expected to be 3');
        self::assertSame(1, $resArr[0], 'The value of $resArr[0] is expected to be 1');
        self::assertSame(4, $resArr[2], 'The value of $resArr[2] is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-3.js.
     */
    public function test15442093(): void
    {
        $srcArr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($srcArr): bool {
            unset($srcArr[2], $srcArr[4]);

            return $val > 0;
        };

        $resArr = $srcArr->filter($callbackfn);

        // two elements deleted
        self::assertSame(3, $resArr->length, 'The value of $resArr->length is expected to be 3');
        self::assertSame(1, $resArr[0], 'The value of $resArr[0] is expected to be 1');
        self::assertSame(4, $resArr[2], 'The value of $resArr[2] is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-4.js.
     */
    public function test15442094(): void
    {
        $srcArr = new Arr(1, 2, 3, 4, 6);

        $callbackfn = static function () use ($srcArr): bool {
            $srcArr->length = 2;

            return true;
        };

        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(2, $resArr->length, 'The value of $resArr->length is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-5.js.
     */
    public function test15442095(): void
    {
        $srcArr = new Arr(10);
        $srcArr[1] = 1;
        $srcArr[2] = 2;

        $callbackfn = static function () use ($srcArr): bool {
            $srcArr[1000] = 3;

            return true;
        };

        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(2, $resArr->length, 'The value of $resArr->length is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-6.js
    // Reason: Array.prototype index pollution

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-7.js.
     */
    public function test15442097(): void
    {
        $o = new \stdClass();
        $o->srcArr = new Arr(1, 2, 3, 4, 5);

        // Adapted: JS deletes the 'srcArr' property; the project CS forbids unset() on
        // properties, so it is cleared by assigning null instead.
        $callbackfn = static function (int $val) use ($o): bool {
            $o->srcArr = null;

            return $val > 0;
        };

        $srcArr = $o->srcArr;
        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(5, $resArr->length, 'The value of $resArr->length is expected to be 5');
        self::assertNull($o->srcArr, 'The value of $o->srcArr is expected to be null');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-8.js
    // Reason: array-like object with 'length' 0 but populated indexes

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-9.js
    // Reason: index accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-b-1.js.
     */
    public function test1544209B1(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return false;
        };

        $srcArr = new Arr(10);
        $srcArr[1] = null; // explicitly assigning a value
        $resArr = $srcArr->filter($callbackfn);

        self::assertSame(0, $resArr->length, 'The value of $resArr->length is expected to be 0');
        self::assertSame(1, $callCnt, 'The value of $callCnt is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-10.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-11.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-12.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-13.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-14.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-15.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-16.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-2.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-3.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-4.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-5.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-6.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-7.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-8.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-b-9.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-1.js
    // Reason: array-like object

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-19.js
    // Reason: index accessor property without getter / Object.prototype pollution

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-2.js.
     */
    public function test1544209CI2(): void
    {
        // JS callbackfn returns undefined (falsy) for indexes other than 0; PHP: explicit false.
        $callbackfn = static function (int $val, int $idx): bool {
            if (0 === $idx) {
                return 11 === $val;
            }

            return false;
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-20.js
    // Reason: index accessor property without getter / Array.prototype pollution

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-28.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-29.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-3.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-30.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-31.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-7.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-i-9.js
    // Reason: index accessor properties on an array-like object

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-1.js.
     */
    public function test1544209CII1(): void
    {
        $bPar = true;
        $bCalled = false;

        // JS callbackfn returns undefined (falsy); PHP equivalent: void (null).
        $callbackfn = static function (mixed $val, int $idx, Arr $obj) use (&$bPar, &$bCalled): void {
            $bCalled = true;
            if ($obj[$idx] !== $val) {
                $bPar = false;
            }
        };

        $srcArr = new Arr(0, 1, true, null, new \stdClass(), 'five');
        $srcArr[999999] = -6.6;
        $srcArr->filter($callbackfn);

        self::assertTrue($bCalled, 'The value of $bCalled is expected to be true');
        self::assertTrue($bPar, 'The value of $bPar is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-10.js.
     */
    public function test1544209CII10(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        $newArr = Arr::of(12)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(12, $newArr[0], 'The value of $newArr[0] is expected to be 12');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-11.js.
     */
    public function test1544209CII11(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            $args = \func_get_args();

            return $val > 10 && $args[2][$idx] === $val;
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-12.js.
     */
    public function test1544209CII12(): void
    {
        $callbackfn = static fn (int $val, int $idx, Arr $obj): bool => $val > 10 && $obj[$idx] === $val;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-13.js.
     */
    public function test1544209CII13(): void
    {
        $callbackfn = static function (): bool {
            $args = \func_get_args();

            return $args[2][$args[1]] === $args[0];
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-16.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-17.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-18.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-19.js.
     */
    public function test1544209CII19(): void
    {
        $accessed = false;

        $callbackfn = static function (int $val) use (&$accessed): bool {
            $accessed = true;

            return 8 === $val;
        };

        // JS array-like object adapted to a sparse Arr; non-index keys become properties.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[2] = 5;
        $obj['non_index_property'] = 8;

        $newArr = $obj->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-2.js.
     */
    public function test1544209CII2(): void
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
        $srcArr->filter($callbackfn);

        self::assertTrue($bCalled, 'The value of $bCalled is expected to be true');
        self::assertSame(3, $parCnt, 'The value of $parCnt is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-20.js.
     */
    public function test1544209CII20(): void
    {
        $thisArg = new \stdClass();
        $thisArg->threshold = 10;

        $callbackfn = fn (): bool => $this === $thisArg;

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);
        $newArr = $obj->filter($callbackfn, $thisArg);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-21.js.
     */
    public function test1544209CII21(): void
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
        $newArr = $obj->filter($callbackfn);

        self::assertSame(2, $newArr->length, 'The value of $newArr->length is expected to be 2');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
        self::assertSame(12, $newArr[1], 'The value of $newArr[1] is expected to be 12');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-22.js.
     */
    public function test1544209CII22(): void
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
        $newArr = $obj->filter($callbackfn);

        self::assertSame(2, $newArr->length, 'The value of $newArr->length is expected to be 2');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
        self::assertSame(12, $newArr[1], 'The value of $newArr[1] is expected to be 12');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-23.js.
     */
    public function test1544209CII23(): void
    {
        // JS array-like object {0: 11, length: 2} adapted to a sparse Arr.
        $obj = new Arr(2);
        $obj[0] = 11;

        $callbackfn = static fn (int $val, int $idx, Arr $o): bool => $obj === $o;

        $newArr = $obj->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-4.js.
     */
    public function test1544209CII4(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4, 5);
        $lastIdx = 0;
        $called = 0;

        $callbackfn = static function (int $val, int $idx) use (&$lastIdx, &$called): bool {
            ++$called;
            if ($lastIdx !== $idx) {
                return false;
            }

            ++$lastIdx;

            return true;
        };

        $newArr = $arr->filter($callbackfn);

        self::assertSame($called, $newArr->length, 'The value of $newArr->length is expected to equal the value of $called');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-5.js.
     */
    public function test1544209CII5(): void
    {
        $kIndex = [];
        $called = 0;

        // By below way, we could verify that k would be set as 0, 1, ..., length - 1 in order, and each value will be set one time.
        $callbackfn = static function (int $val, int $idx) use (&$kIndex, &$called): bool {
            ++$called;

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

        $newArr = (new Arr(11, 12, 13, 14))->filter($callbackfn, null);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-6.js.
     */
    public function test1544209CII6(): void
    {
        $thisArg = new \stdClass();

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);

        $callbackfn = function () use ($thisArg, $obj): bool {
            $args = \func_get_args();

            return $this === $thisArg
                && 11 === $args[0]
                && 0 === $args[1]
                && $args[2] === $obj;
        };

        $newArr = $obj->filter($callbackfn, $thisArg);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-7.js.
     */
    public function test1544209CII7(): void
    {
        $called = 0;
        $exception = new \Exception('Exception occurred in callbackfn');

        $callbackfn = static function () use (&$called, $exception): bool {
            ++$called;
            if (1 === $called) {
                throw $exception;
            }

            return true;
        };

        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[4] = 10;
        $obj[10] = 8;

        try {
            $obj->filter($callbackfn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertSame(1, $called, 'The value of $called is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-8.js.
     */
    public function test1544209CII8(): void
    {
        $obj = new Arr(11, 12);

        $callbackfn = static function (int $val, int $idx) use ($obj): bool {
            if (0 === $idx) {
                $obj[$idx + 1] = 8;
            }

            return $val > 10;
        };

        $newArr = $obj->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-ii-9.js.
     */
    public function test1544209CII9(): void
    {
        $callbackfn = static fn (): bool => true;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-1.js.
     */
    public function test1544209CIII11(): void
    {
        $callbackfn = static fn (): bool => true;

        // JS array-like object {0: 11, 1: 9, length: 2} adapted to an Arr.
        $obj = new Arr(11, 9);
        $newArr = $obj->filter($callbackfn);

        self::assertSame($obj[0], $newArr[0], 'The value of $newArr[0] is expected to equal the value of $obj[0]');
        self::assertSame($obj[1], $newArr[1], 'The value of $newArr[1] is expected to equal the value of $obj[1]');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-2.js.
     */
    public function test1544209CIII12(): void
    {
        $callbackfn = static fn (): bool => true;

        $obj = new Arr(11, 9);
        $newArr = $obj->filter($callbackfn);

        $tempVal = $newArr[1];
        $newArr[1] = $tempVal + 1;

        self::assertNotSame($tempVal, $newArr[1], 'The value of $newArr[1] is expected to not equal the value of $tempVal');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-3.js.
     */
    public function test1544209CIII13(): void
    {
        $callbackfn = static fn (): bool => true;

        // JS array-like object {0: 11, length: 2} adapted to a sparse Arr.
        $obj = new Arr(2);
        $obj[0] = 11;
        $newArr = $obj->filter($callbackfn);

        // JS enumerates with for-in/hasOwnProperty; PHP equivalent: iterating the keys.
        $enumerable = false;
        foreach ($newArr->keys() as $key) {
            if (0 === $key) {
                $enumerable = true;
            }
        }

        self::assertTrue($enumerable, 'The value of $enumerable is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-4.js.
     */
    public function test1544209CIII14(): void
    {
        $callbackfn = static fn (): bool => true;

        $obj = new Arr(11, 9);
        $newArr = $obj->filter($callbackfn);

        $tempVal = $newArr[1];
        unset($newArr[1]);

        self::assertNotNull($tempVal, 'The value of $tempVal is expected to not be null');
        self::assertNull($newArr[1], 'The value of $newArr[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-5.js.
     */
    public function test1544209CIII15(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4);
        $lastToIdx = 0;
        $called = 0;

        $callbackfn = static function (int $val, int $idx) use (&$lastToIdx, &$called): bool {
            ++$called;
            if ($lastToIdx !== $idx) {
                return false;
            }

            ++$lastToIdx;

            return true;
        };

        $newArr = $arr->filter($callbackfn);

        self::assertSame(5, $newArr->length, 'The value of $newArr->length is expected to be 5');
        self::assertSame(5, $called, 'The value of $called is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1-6.js.
     */
    public function test1544209CIII16(): void
    {
        $toIndex = [];
        $called = 0;

        // By below way, we could verify that 'to' would be set as 0, 1, ..., length - 1 in order, and each value will be set one time.
        $callbackfn = static function (int $val, int $idx) use (&$toIndex, &$called): bool {
            ++$called;

            // Each position should be visited one time, which means 'to' is accessed one time during iterations.
            if (!isset($toIndex[$idx])) {
                // when current position is visited, its previous index should have been visited.
                if (0 !== $idx && !isset($toIndex[$idx - 1])) {
                    return false;
                }
                $toIndex[$idx] = 1;

                return true;
            }

            return false;
        };

        $newArr = (new Arr(11, 12, 13, 14))->filter($callbackfn, null);

        self::assertSame(4, $newArr->length, 'The value of $newArr->length is expected to be 4');
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-1.js
    // Reason: property descriptor of returned array elements

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-10.js.
     */
    public function test1544209CIII10(): void
    {
        $callbackfn = static fn (): int => -5;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-11.js.
     *
     * Method name suffixed with "B" to avoid colliding with 15.4.4.20-9-c-iii-1-1.js.
     */
    public function test1544209CIII11B(): void
    {
        $callbackfn = static fn (): float => INF;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-12.js.
     *
     * Method name suffixed with "B" to avoid colliding with 15.4.4.20-9-c-iii-1-2.js.
     */
    public function test1544209CIII12B(): void
    {
        $callbackfn = static fn (): float => -INF;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-13.js
    // Reason: NaN is falsy in JS but truthy in PHP (filter() would keep the element instead
    // of dropping it, and PHP 8.5 emits an "unexpected NAN value was coerced to bool" warning)

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-14.js.
     *
     * Method name suffixed with "B" to avoid colliding with 15.4.4.20-9-c-iii-1-4.js.
     */
    public function test1544209CIII14B(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): string {
            $accessed = true;

            return '';
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-15.js.
     *
     * Method name suffixed with "B" to avoid colliding with 15.4.4.20-9-c-iii-1-5.js.
     */
    public function test1544209CIII15B(): void
    {
        $callbackfn = static fn (): string => 'non-empty string';

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-16.js.
     *
     * Method name suffixed with "B" to avoid colliding with 15.4.4.20-9-c-iii-1-6.js.
     */
    public function test1544209CIII16B(): void
    {
        $callbackfn = static fn (): \Closure => static function (): void {};

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-17.js.
     */
    public function test1544209CIII17(): void
    {
        // JS new Array(10) is an Array object (truthy); PHP equivalent: an Arr instance (objects are truthy).
        $callbackfn = static fn (): Arr => new Arr(10);

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-18.js
    // Reason: String wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-19.js
    // Reason: Boolean wrapper object as return value

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-2.js.
     */
    public function test1544209CIII2(): void
    {
        $accessed = false;

        // JS callbackfn returns undefined (falsy); PHP equivalent: void (null).
        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);
        $newArr = $obj->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-20.js
    // Reason: Number wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-21.js
    // Reason: the Math object as return value

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-22.js.
     */
    public function test1544209CIII22(): void
    {
        $callbackfn = static fn (): \DateTimeImmutable => new \DateTimeImmutable('@0');

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-23.js
    // Reason: RegExp object as return value

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-24.js
    // Reason: the JSON object as return value

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-25.js.
     */
    public function test1544209CIII25(): void
    {
        // JS returns an EvalError object (truthy); PHP equivalent: an Exception instance.
        $callbackfn = static fn (): \Exception => new \Exception();

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-26.js.
     */
    public function test1544209CIII26(): void
    {
        // JS returns the arguments object (truthy); PHP equivalent: the non-empty args array (truthy).
        $callbackfn = static fn (): array => \func_get_args();

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-28.js
    // Reason: the global object as return value

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-29.js.
     */
    public function test1544209CIII29(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return $val > 10;
        };

        // JS array-like object {0: 11, 1: 8, length: 20} adapted to a sparse Arr.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[1] = 8;

        $newArr = $obj->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertNotSame(8, $newArr[0], 'The value of $newArr[0] is expected to not be 8');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-3.js.
     */
    public function test1544209CIII3(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): mixed {
            $accessed = true;

            return null;
        };

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);
        $newArr = $obj->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-30.js
    // Reason: Boolean wrapper object (new Boolean(false)) as return value

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-4.js.
     */
    public function test1544209CIII4(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): bool {
            $accessed = true;

            return false;
        };

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);
        $newArr = $obj->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-5.js.
     */
    public function test1544209CIII5(): void
    {
        $callbackfn = static fn (): bool => true;

        // JS array-like object {0: 11, length: 1} adapted to an Arr.
        $obj = Arr::of(11);
        $newArr = $obj->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-6.js.
     */
    public function test1544209CIII6(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return 0;
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-7.js.
     */
    public function test1544209CIII7(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return +0;
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-8.js.
     */
    public function test1544209CIII8(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): float {
            $accessed = true;

            return -0.0;
        };

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(0, $newArr->length, 'The value of $newArr->length is expected to be 0');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/filter/15.4.4.20-9-c-iii-9.js.
     */
    public function test1544209CIII9(): void
    {
        $callbackfn = static fn (): int => 5;

        $newArr = Arr::of(11)->filter($callbackfn);

        self::assertSame(1, $newArr->length, 'The value of $newArr->length is expected to be 1');
        self::assertSame(11, $newArr[0], 'The value of $newArr[0] is expected to be 11');
    }

    // SKIPPED: test/built-ins/Array/prototype/filter/call-with-boolean.js
    // Reason: this coercion (call on boolean primitives)

    // SKIPPED: test/built-ins/Array/prototype/filter/callbackfn-resize-arraybuffer.js
    // Reason: TypedArray / ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/filter/create-ctor-non-object.js
    // Reason: 'constructor' property lookup for ArraySpeciesCreate

    // SKIPPED: test/built-ins/Array/prototype/filter/create-ctor-poisoned.js
    // Reason: 'constructor' property lookup for ArraySpeciesCreate

    // SKIPPED: test/built-ins/Array/prototype/filter/create-non-array.js
    // Reason: ArraySpeciesCreate on non-array this

    // SKIPPED: test/built-ins/Array/prototype/filter/create-proto-from-ctor-realm-array.js
    // Reason: realms

    // SKIPPED: test/built-ins/Array/prototype/filter/create-proto-from-ctor-realm-non-array.js
    // Reason: realms

    // SKIPPED: test/built-ins/Array/prototype/filter/create-proxy.js
    // Reason: Proxy

    // SKIPPED: test/built-ins/Array/prototype/filter/create-revoked-proxy.js
    // Reason: revoked Proxy

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species-abrupt.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species-non-ctor.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species-null.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species-poisoned.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species-undef.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/create-species.js
    // Reason: @@species

    // SKIPPED: test/built-ins/Array/prototype/filter/length.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/filter/name.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/filter/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/filter/prop-desc.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/filter/resizable-buffer-grow-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/filter/resizable-buffer-shrink-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/filter/resizable-buffer.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/filter/target-array-non-extensible.js
    // Reason: non-extensible objects / Object.preventExtensions

    // SKIPPED: test/built-ins/Array/prototype/filter/target-array-with-non-configurable-property.js
    // Reason: non-configurable properties / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/filter/target-array-with-non-writable-property.js
    // Reason: non-writable properties / Object.defineProperty
}
