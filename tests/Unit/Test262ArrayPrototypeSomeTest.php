<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.some tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeSomeTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-1.js
    // Reason: this coercion (call on undefined)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-10.js
    // Reason: this coercion (call on the Math object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-11.js
    // Reason: this coercion (call on a Date object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-12.js
    // Reason: this coercion (call on a RegExp object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-13.js
    // Reason: this coercion (call on the JSON object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-14.js
    // Reason: this coercion (call on an Error object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-15.js
    // Reason: this coercion (call on the Arguments object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-2.js
    // Reason: this coercion (call on null)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-3.js
    // Reason: this coercion (call on a boolean primitive)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-4.js
    // Reason: this coercion (call on a Boolean object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-5.js
    // Reason: this coercion (call on a number primitive)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-6.js
    // Reason: this coercion (call on a Number object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-7.js
    // Reason: this coercion (call on a string primitive)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-8.js
    // Reason: this coercion (call on a String object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-1-9.js
    // Reason: this coercion (call on a Function object)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-1.js
    // Reason: array-like object with own 'length' data property

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-10.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-11.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-12.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-13.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-14.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-17.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-18.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-19.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-2.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-3.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-4.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-5.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-6.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-7.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-8.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-2-9.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-1.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-11.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-12.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-13.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-14.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-15.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-16.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-17.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-18.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-19.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-2.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-20.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-21.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-22.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-23.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-24.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-25.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-28.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-29.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-3.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-4.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-5.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-6.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-7.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-8.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-3-9.js
    // Reason: 'length' accessor property throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-1.js.
     */
    public function test15441741(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing argument on purpose
        $arr->some();
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-11.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-12.js.
     */
    public function test154417412(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        self::assertTrue((new Arr(9, 11))->some($callbackfn), '(new Arr(9, 11))->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-15.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-2.js
    // Reason: JS ReferenceError for an unresolvable identifier; no PHP equivalent

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-3.js.
     */
    public function test15441743(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->some(null);
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-4.js.
     */
    public function test15441744(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->some(true);
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-5.js.
     */
    public function test15441745(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->some(5);
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-6.js.
     */
    public function test15441746(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->some('abc');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-4-7.js.
     */
    public function test15441747(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->some(new \stdClass());
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-8.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-4-9.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-1-s.js
    // Reason: JS strict-mode 'this' semantics for unbound callbacks

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-1.js
    // Reason: JS global object as default 'this' for unbound callbacks

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-10.js.
     */
    public function test154417510(): void
    {
        $objArray = new Arr();

        $callbackfn = fn (): bool => $this === $objArray;

        self::assertTrue(Arr::of(11)->some($callbackfn, $objArray), 'Arr::of(11)->some($callbackfn, $objArray) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-11.js
    // Reason: String wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-12.js
    // Reason: Boolean wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-13.js
    // Reason: Number wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-14.js
    // Reason: the Math object as thisArg

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-15.js.
     */
    public function test154417515(): void
    {
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = fn (): bool => $this === $objDate;

        self::assertTrue(Arr::of(11)->some($callbackfn, $objDate), 'Arr::of(11)->some($callbackfn, $objDate) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-16.js
    // Reason: RegExp object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-17.js
    // Reason: the JSON object as thisArg

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-18.js.
     */
    public function test154417518(): void
    {
        $objError = new RangeError();

        $callbackfn = fn (): bool => $this === $objError;

        self::assertTrue(Arr::of(11)->some($callbackfn, $objError), 'Arr::of(11)->some($callbackfn, $objError) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-19.js
    // Reason: the Arguments object as thisArg

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-2.js.
     */
    public function test15441752(): void
    {
        $o = new \stdClass();
        $o->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->some($callbackfn, $o), '$arr->some($callbackfn, $o) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-21.js
    // Reason: the global object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-22.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-23.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-24.js
    // Reason: string primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-25.js
    // Reason: JS global object as default 'this' for unbound callbacks

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-3.js.
     */
    public function test15441753(): void
    {
        $a = new Arr();
        $a['res'] = true;

        $callbackfn = fn (): bool => true === $this['res'];

        $arr = Arr::of(1);

        self::assertTrue($arr->some($callbackfn, $a), '$arr->some($callbackfn, $a) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-4.js.
     */
    public function test15441754(): void
    {
        // JS: property inherited from the constructor prototype; PHP: property declared on the class.
        $f = new class {
            public bool $res = true;
        };

        $callbackfn = fn (): bool => $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->some($callbackfn, $f), '$arr->some($callbackfn, $f) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-5-5.js.
     */
    public function test15441755(): void
    {
        $f = new \stdClass();
        $f->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->some($callbackfn, $f), '$arr->some($callbackfn, $f) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-6.js
    // Reason: function as thisArg; PHP Closures do not support dynamic properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-7.js
    // Reason: built-in function (eval) as thisArg

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-5-9.js
    // Reason: Function object as thisArg; PHP Closures do not support dynamic properties

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-1.js.
     */
    public function test15441771(): void
    {
        $calledForThree = false;

        $arr = new Arr(5);
        $arr[0] = 1;
        $arr[1] = 2;
        $arr[3] = 4;
        $arr[4] = 5;

        $callbackfn = static function (int $val) use ($arr, &$calledForThree): bool {
            $arr[2] = 3;
            if (3 === $val) {
                $calledForThree = true;
            }

            return false;
        };

        $arr->some($callbackfn);

        self::assertTrue($calledForThree, 'The value of $calledForThree is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-2.js.
     */
    public function test15441772(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr[4] = 6;

            return $val >= 6;
        };

        self::assertTrue($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-3.js.
     */
    public function test15441773(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($arr): bool {
            unset($arr[2]);

            return 3 === $val;
        };

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-4.js.
     */
    public function test15441774(): void
    {
        $arr = new Arr(1, 2, 3, 4, 6);

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr->length = 3;

            return $val >= 4;
        };

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-5.js.
     */
    public function test15441775(): void
    {
        $arr = new Arr(10);
        $arr[1] = 1;
        $arr[2] = 2;

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr[1000] = 5;

            return $val >= 5;
        };

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-6.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-8.js
    // Reason: array-like object with 'length' 0

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-9.js
    // Reason: index accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-b-1.js.
     */
    public function test1544177B1(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return false;
        };

        $arr = new Arr(10);
        $arr[1] = null;
        $arr->some($callbackfn);

        self::assertSame(1, $callCnt, 'The value of $callCnt is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-10.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-11.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-12.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-13.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-14.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-15.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-16.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-2.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-3.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-4.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-5.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-6.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-7.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-8.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-b-9.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-1.js
    // Reason: array-like object

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-19.js
    // Reason: index accessor property without getter / Object.prototype pollution

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-2.js.
     */
    public function test1544177CI2(): void
    {
        $kValue = new \stdClass();

        $callbackfn = static function (mixed $val, int $idx) use ($kValue): bool {
            if (0 === $idx) {
                return $kValue === $val;
            }

            return false;
        };

        self::assertTrue(Arr::of($kValue)->some($callbackfn), 'Arr::of($kValue)->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-20.js
    // Reason: index accessor property without getter / Array.prototype pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-28.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-29.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-3.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-30.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-31.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-7.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-i-9.js
    // Reason: index accessor properties on an array-like object

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-1.js.
     */
    public function test1544177CII1(): void
    {
        $callbackfn = static fn (int $val, int $idx, Arr $obj): bool => $obj[$idx] !== $val;

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-10.js.
     */
    public function test1544177CII10(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        self::assertTrue((new Arr(11, 12))->some($callbackfn), '(new Arr(11, 12))->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-11.js.
     */
    public function test1544177CII11(): void
    {
        $callbackfn = static function (int $val, int $idx): bool {
            $args = \func_get_args();

            return $val > 10 && $args[2][$idx] === $val;
        };

        self::assertTrue((new Arr(9, 12))->some($callbackfn), '(new Arr(9, 12))->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-12.js.
     */
    public function test1544177CII12(): void
    {
        $callbackfn = static fn (int $val, int $idx, Arr $obj): bool => $val > 10 && $obj[$idx] === $val;

        self::assertTrue((new Arr(9, 12))->some($callbackfn), '(new Arr(9, 12))->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-13.js.
     */
    public function test1544177CII13(): void
    {
        $callbackfn = static function (): bool {
            $args = \func_get_args();

            return $args[2][$args[1]] === $args[0];
        };

        self::assertTrue((new Arr(9, 12))->some($callbackfn), '(new Arr(9, 12))->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-16.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-17.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-18.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-19.js.
     */
    public function test1544177CII19(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return 11 === $val;
        };

        // JS array-like object adapted to a sparse Arr; non-index keys become properties.
        $obj = new Arr(20);
        $obj[0] = 9;
        $obj[10] = 8;
        $obj['non_index_property'] = 11;

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-2.js.
     */
    public function test1544177CII2(): void
    {
        // verify if callbackfn was called with 3 parameters
        $callbackfn = static fn (): bool => 3 !== \func_num_args();

        $arr = new Arr(0, 1, true, null, new \stdClass(), 'five');
        $arr[999999] = -6.6;

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-20.js.
     */
    public function test1544177CII20(): void
    {
        $thisArg = new \stdClass();
        $thisArg->threshold = 10;

        $callbackfn = fn (): bool => $this === $thisArg;

        $obj = new Arr(2);
        $obj[0] = 11;

        self::assertTrue($obj->some($callbackfn, $thisArg), '$obj->some($callbackfn, $thisArg) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-21.js.
     */
    public function test1544177CII21(): void
    {
        $firstIndex = false;
        $secondIndex = false;

        $callbackfn = static function (int $val, int $idx) use (&$firstIndex, &$secondIndex): bool {
            if (0 === $idx) {
                $firstIndex = (11 === $val);

                return false;
            }

            if (1 === $idx) {
                $secondIndex = (12 === $val);

                return false;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertTrue($firstIndex, 'The value of $firstIndex is expected to be true');
        self::assertTrue($secondIndex, 'The value of $secondIndex is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-22.js.
     */
    public function test1544177CII22(): void
    {
        $firstIndex = false;
        $secondIndex = false;

        $callbackfn = static function (int $val, int $idx) use (&$firstIndex, &$secondIndex): bool {
            if (11 === $val) {
                $firstIndex = (0 === $idx);

                return false;
            }

            if (12 === $val) {
                $secondIndex = (1 === $idx);

                return false;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertTrue($firstIndex, 'The value of $firstIndex is expected to be true');
        self::assertTrue($secondIndex, 'The value of $secondIndex is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-23.js.
     */
    public function test1544177CII23(): void
    {
        $obj = new Arr(11, 12);

        $callbackfn = static fn (int $val, int $idx, Arr $o): bool => $obj === $o;

        self::assertTrue($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-3.js.
     */
    public function test1544177CII3(): void
    {
        $callCnt = 0;

        $callbackfn = static function (int $val, int $idx) use (&$callCnt): bool {
            ++$callCnt;

            return $idx > 5;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertTrue($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be true');
        self::assertSame(7, $callCnt, 'The value of $callCnt is expected to be 7');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-4.js.
     */
    public function test1544177CII4(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4, 5);
        $lastIdx = 0;

        $callbackfn = static function (int $val, int $idx) use (&$lastIdx, &$called): bool {
            ++$called;
            if ($lastIdx !== $idx) {
                return true;
            }

            ++$lastIdx;

            return false;
        };

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
        self::assertSame($arr->length, $called, 'The value of $called is expected to equal the value of $arr->length');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-5.js.
     */
    public function test1544177CII5(): void
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

        self::assertFalse((new Arr(11, 12, 13, 14))->some($callbackfn, null), '(new Arr(11, 12, 13, 14))->some($callbackfn, null) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-6.js.
     */
    public function test1544177CII6(): void
    {
        $thisArg = new \stdClass();
        $obj = Arr::of(11);

        $callbackfn = function () use ($thisArg, $obj): bool {
            $args = \func_get_args();

            return $this === $thisArg
                && 11 === $args[0]
                && 0 === $args[1]
                && $args[2] === $obj;
        };

        self::assertTrue($obj->some($callbackfn, $thisArg), '$obj->some($callbackfn, $thisArg) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-7.js.
     */
    public function test1544177CII7(): void
    {
        $accessed = false;
        $exception = new \Exception('Exception occurred in callbackfn');

        $callbackfn = static function (int $val, int $idx) use (&$accessed, $exception): bool {
            if ($idx > 0) {
                $accessed = true;
            }
            if (0 === $idx) {
                throw $exception;
            }

            return false;
        };

        $obj = new Arr(20);
        $obj[0] = 9;
        $obj[1] = 100;
        $obj[10] = 11;

        try {
            $obj->some($callbackfn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertFalse($accessed, 'The value of $accessed is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-8.js.
     */
    public function test1544177CII8(): void
    {
        $obj = new Arr(9, 8);

        $callbackfn = static function (int $val, int $idx) use ($obj): bool {
            if (0 === $idx) {
                $obj[$idx + 1] = 11;
            }

            return $val > 10;
        };

        self::assertTrue($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-ii-9.js.
     */
    public function test1544177CII9(): void
    {
        $callbackfn = static fn (): bool => true;

        self::assertTrue((new Arr(11, 12))->some($callbackfn), '(new Arr(11, 12))->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-1.js.
     */
    public function test1544177CIII1(): void
    {
        $accessed = false;

        // JS callbackfn returns undefined (falsy); PHP equivalent: null (falsy).
        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        $obj = new Arr(2);
        $obj[0] = 11;

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-10.js.
     */
    public function test1544177CIII10(): void
    {
        $callbackfn = static fn (): float => INF;

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-11.js.
     */
    public function test1544177CIII11(): void
    {
        $callbackfn = static fn (): float => -INF;

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-12.js
    // Reason: NaN is falsy in JS but truthy in PHP (some() would return true instead of
    // false, and PHP 8.5 emits an "unexpected NAN value was coerced to bool" warning)

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-13.js.
     */
    public function test1544177CIII13(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): string {
            $accessed = true;

            return '';
        };

        self::assertFalse(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-14.js.
     */
    public function test1544177CIII14(): void
    {
        $callbackfn = static fn (): string => 'non-empty string';

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-15.js.
     */
    public function test1544177CIII15(): void
    {
        $callbackfn = static fn (): \Closure => static function (): void {};

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-16.js.
     */
    public function test1544177CIII16(): void
    {
        // JS new Array(10) is an Array object (truthy); PHP equivalent: an Arr instance (objects are truthy).
        $callbackfn = static fn (): Arr => new Arr(10);

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-17.js
    // Reason: String wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-18.js
    // Reason: Boolean wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-19.js
    // Reason: Number wrapper object as return value

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-2.js.
     */
    public function test1544177CIII2(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        $obj = new Arr(2);
        $obj[0] = 11;

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-20.js
    // Reason: the Math object as return value

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-21.js.
     */
    public function test1544177CIII21(): void
    {
        $callbackfn = static fn (): \DateTimeImmutable => new \DateTimeImmutable('@0');

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-22.js
    // Reason: RegExp object as return value

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-23.js
    // Reason: the JSON object as return value

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-24.js.
     */
    public function test1544177CIII24(): void
    {
        $callbackfn = static fn (): \Exception => new \Exception();

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-25.js.
     */
    public function test1544177CIII25(): void
    {
        // JS returns the arguments object (truthy); PHP equivalent: the non-empty args array (truthy).
        $callbackfn = static fn (): array => \func_get_args();

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-26.js
    // Reason: the global object as return value

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-28.js.
     */
    public function test1544177CIII28(): void
    {
        $result = false;

        // Adapted: the JS test uses index getters; here the callback tracks that no
        // element after the first true result is visited.
        $obj = new Arr(20);
        $obj[0] = 8;
        $obj[1] = 11;
        $obj[2] = 11;

        $callbackfn = static function (int $val, int $idx) use (&$result): bool {
            if ($idx > 1) {
                $result = true;
            }

            return $val > 10;
        };

        self::assertTrue($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be true');
        self::assertFalse($result, 'The value of $result is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-29.js
    // Reason: Boolean wrapper object (new Boolean(false)) as return value

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-3.js.
     */
    public function test1544177CIII3(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): bool {
            $accessed = true;

            return false;
        };

        $obj = new Arr(2);
        $obj[0] = 11;

        self::assertFalse($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-4.js.
     */
    public function test1544177CIII4(): void
    {
        $callbackfn = static fn (): bool => true;

        $obj = new Arr(2);
        $obj[0] = 11;

        self::assertTrue($obj->some($callbackfn), '$obj->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-5.js.
     */
    public function test1544177CIII5(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return 0;
        };

        self::assertFalse(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-6.js.
     */
    public function test1544177CIII6(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return +0;
        };

        self::assertFalse(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-7.js.
     */
    public function test1544177CIII7(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): float {
            $accessed = true;

            return -0.0;
        };

        self::assertFalse(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-8.js.
     */
    public function test1544177CIII8(): void
    {
        $callbackfn = static fn (): int => 5;

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-7-c-iii-9.js.
     */
    public function test1544177CIII9(): void
    {
        $callbackfn = static fn (): int => -5;

        self::assertTrue(Arr::of(11)->some($callbackfn), 'Arr::of(11)->some($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-8-1.js.
     */
    public function test15441781(): void
    {
        $cb = static function (): void {};
        $i = (new Arr())->some($cb);

        self::assertFalse($i, 'The value of $i is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-10.js
    // Reason: subclassed Array

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-8-11.js.
     */
    public function test154417811(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return false;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
        self::assertSame(10, $callCnt, 'The value of $callCnt is expected to be 10');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-8-12.js.
     */
    public function test154417812(): void
    {
        $callbackfn = static fn (): bool => true;

        $arr = new Arr(1, 2, 3, 4, 5);
        $arr->some($callbackfn);

        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(4, $arr[3], 'The value of $arr[3] is expected to be 4');
        self::assertSame(5, $arr[4], 'The value of $arr[4] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/some/15.4.4.17-8-13.js.
     */
    public function test154417813(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return false;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $arr['i'] = 10;
        $arr[true] = 11;

        self::assertFalse($arr->some($callbackfn), '$arr->some($callbackfn) is expected to be false');
        self::assertSame(10, $callCnt, 'The value of $callCnt is expected to be 10');
    }

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-2.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-3.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-4.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-5.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-6.js
    // Reason: subclassed Array / length valueOf coercion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-7.js
    // Reason: subclassed Array / length toString coercion

    // SKIPPED: test/built-ins/Array/prototype/some/15.4.4.17-8-8.js
    // Reason: subclassed Array / length array coercion

    // SKIPPED: test/built-ins/Array/prototype/some/call-with-boolean.js
    // Reason: this coercion (call on boolean primitives)

    // SKIPPED: test/built-ins/Array/prototype/some/callbackfn-resize-arraybuffer.js
    // Reason: TypedArray / ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/some/length.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/some/name.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/some/not-a-constructor.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/some/prop-desc.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/some/resizable-buffer-grow-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/some/resizable-buffer-shrink-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/some/resizable-buffer.js
    // Reason: TypedArray / resizable ArrayBuffer
}
