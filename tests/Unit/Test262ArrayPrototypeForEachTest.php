<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.forEach tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeForEachTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-1.js
    // Reason: ToObject coercion of `this`; forEach is an Arr instance method

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-10.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-11.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-12.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-13.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-14.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-15.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-2.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-3.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-4.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-5.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-6.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-7.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-8.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-1-9.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-1.js
    // Reason: forEach applied to array-like objects with a `length` property

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-10.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-11.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-12.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-13.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-14.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-17.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-18.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-19.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-2.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-3.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-4.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-5.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-6.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-7.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-8.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-2-9.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-1.js
    // Reason: ToUint32 coercion of `length` on array-like objects; Arr length is typed int

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-10.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-11.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-12.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-13.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-14.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-15.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-16.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-17.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-18.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-19.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-2.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-20.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-21.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-22.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-23.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-24.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-25.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-3.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-4.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-5.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-6.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-7.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-3-9.js
    // Reason: `length` getter on an array-like object

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-4-1.js.
     */
    public function test154418441(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing required callback argument on purpose
        $arr->forEach();
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-10.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-11.js
    // Reason: ReferenceError for an unresolved identifier is a JS-only concern

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-4-12.js.
     */
    public function test1544184412(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        (new Arr(11, 9))->forEach($callbackfn);

        self::assertTrue($accessed, 'accessed !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-15.js
    // Reason: ReferenceError for an unresolved identifier is a JS-only concern

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-2.js
    // Reason: ReferenceError for an unresolved identifier is a JS-only concern

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-4-3.js.
     */
    public function test15441843(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line null is not callable on purpose
        $arr->forEach(null);
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-4.js
    // Reason: TypeError on non-callable is a PHP language-level guarantee; representative ported as 15.4.4.18-4-3

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-5.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-6.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-7.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-8.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-4-9.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-1-s.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-1.js.
     */
    public function test15441851(): void
    {
        // Adapted: when thisArg is not passed a non-static Closure keeps its original
        // $this (the JS test expects the global object rather than a local binding).
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn);

        self::assertSame($this, $result, 'result');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-10.js.
     */
    public function test154418510(): void
    {
        $result = false;
        $objArray = new Arr();

        $callbackfn = function () use (&$result, $objArray): void {
            $result = ($this === $objArray);
        };

        Arr::of(11)->forEach($callbackfn, $objArray);

        self::assertTrue($result, 'result !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-11.js
    // Reason: String wrapper object as thisArg has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-12.js
    // Reason: Boolean wrapper object as thisArg has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-13.js
    // Reason: Number wrapper object as thisArg has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-14.js
    // Reason: the JS Math object has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-15.js.
     */
    public function test154418515(): void
    {
        $result = false;
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = function () use (&$result, $objDate): void {
            $result = ($this === $objDate);
        };

        Arr::of(11)->forEach($callbackfn, $objDate);

        self::assertTrue($result, 'result !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-16.js
    // Reason: RegExp object as thisArg has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-17.js
    // Reason: the JS JSON object has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-18.js.
     */
    public function test154418518(): void
    {
        $result = false;
        $objError = new RangeError();

        $callbackfn = function () use (&$result, $objError): void {
            $result = ($this === $objError);
        };

        Arr::of(11)->forEach($callbackfn, $objError);

        self::assertTrue($result, 'result !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-19.js
    // Reason: the JS Arguments object has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-2.js.
     */
    public function test15441852(): void
    {
        $o = new \stdClass();
        $o->res = true;
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this->res;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn, $o);

        self::assertTrue($result, 'result');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-21.js
    // Reason: the JS global object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-22.js
    // Reason: primitive thisArg; Arr::forEach() thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-23.js
    // Reason: primitive thisArg; Arr::forEach() thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-24.js
    // Reason: primitive thisArg; Arr::forEach() thisArg is typed ?object

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-25.js.
     */
    public function test154418525(): void
    {
        // Adapted: when thisArg is not passed a non-static Closure keeps its original
        // $this, so the surrounding object's property is not visible via $this.
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this->_15_4_4_18_5_25 ?? null;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn);

        self::assertNotTrue($result, 'new innerObj().retVal !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-3.js.
     */
    public function test15441853(): void
    {
        $a = new Arr();
        $a['res'] = true;
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this['res'];
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn, $a);

        self::assertTrue($result, 'result');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-4.js.
     */
    public function test15441854(): void
    {
        $f = new class {
            public bool $res = true;
        };
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this->res;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn, $f);

        self::assertTrue($result, 'result');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-5.js.
     */
    public function test15441855(): void
    {
        $f = new \stdClass();
        $f->res = true;
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this->res;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn, $f);

        self::assertTrue($result, 'result');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-6.js.
     */
    public function test15441856(): void
    {
        // Adapted: PHP Closures do not accept dynamic properties, so an invokable
        // object plays the role of the JS function used as thisArg.
        $foo = new class {
            public bool $res = true;

            public function __invoke(): void {}
        };
        $result = null;

        $callbackfn = function () use (&$result): void {
            $result = $this->res;
        };

        $arr = Arr::of(1);
        $arr->forEach($callbackfn, $foo);

        self::assertTrue($result, 'result');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-5-7.js
    // Reason: the JS built-in eval function has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-5-9.js.
     */
    public function test15441859(): void
    {
        $result = false;
        $objString = static function (): void {};

        $callbackfn = function () use (&$result, $objString): void {
            $result = ($this === $objString);
        };

        Arr::of(11)->forEach($callbackfn, $objString);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-1.js.
     */
    public function test15441871(): void
    {
        $callCnt = 0;

        $arr = new Arr(5);
        $arr[0] = 1;
        $arr[1] = 2;
        $arr[3] = 4;
        $arr[4] = 5;

        $callbackfn = static function () use (&$callCnt, $arr): void {
            ++$callCnt;
            $arr[2] = 3;
            $arr[5] = 6;
        };

        $arr->forEach($callbackfn);

        self::assertSame(5, $callCnt, 'callCnt');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-2.js.
     */
    public function test15441872(): void
    {
        $callCnt = 0;

        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function () use (&$callCnt, $arr): void {
            if (0 === $callCnt) {
                unset($arr[3]);
            }
            ++$callCnt;
        };

        $arr->forEach($callbackfn);

        self::assertSame(4, $callCnt, 'callCnt');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-3.js.
     */
    public function test15441873(): void
    {
        $callCnt = 0;

        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function () use (&$callCnt, $arr): void {
            $arr->length = 3;
            ++$callCnt;
        };

        $arr->forEach($callbackfn);

        self::assertSame(3, $callCnt, 'callCnt');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-4.js.
     */
    public function test15441874(): void
    {
        $callCnt = 0;

        $arr = new Arr(10);
        $arr[1] = 1;
        $arr[2] = 2;

        $callbackfn = static function () use (&$callCnt, $arr): void {
            $arr[1000] = 3;
            ++$callCnt;
        };

        $arr->forEach($callbackfn);

        self::assertSame(2, $callCnt, 'callCnt');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-5.js
    // Reason: index properties inherited from Array.prototype

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-7.js.
     */
    public function test15441877(): void
    {
        $result = false;
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use (&$result, $arr): void {
            $arr[4] = 6;
            if ($val >= 6) {
                $result = true;
            }
        };

        $arr->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-8.js
    // Reason: array-like with populated indexes beyond length 0 cannot be represented by Arr

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-9.js
    // Reason: index getter on an array-like object

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-1.js.
     */
    public function test1544187B1(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): void {
            ++$callCnt;
        };

        $arr = new Arr(10);
        $arr[1] = null;
        $arr->forEach($callbackfn);

        self::assertSame(1, $callCnt, 'callCnt');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-10.js
    // Reason: prototype-chain index properties / getters

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-11.js
    // Reason: relies on an index getter to mutate length mid-iteration; covered by 15.4.4.18-7-3

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-12.js
    // Reason: relies on an index getter to mutate length mid-iteration; covered by 15.4.4.18-7-3

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-13.js
    // Reason: relies on an index getter to mutate length mid-iteration; covered by 15.4.4.18-7-3

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-14.js
    // Reason: relies on an index getter to mutate length mid-iteration; covered by 15.4.4.18-7-3

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-15.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-16.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-2.js
    // Reason: `length` getter on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-3.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-4.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-5.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-6.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-7.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-8.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-b-9.js
    // Reason: accessor index properties via Object.defineProperty

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-1.js.
     */
    public function test1544187Ci1(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr.
        $kValue = new \stdClass();
        $testResult = false;

        $callbackfn = static function (mixed $val, int $idx) use (&$testResult, $kValue): void {
            if (5 === $idx) {
                $testResult = ($val === $kValue);
            }
        };

        $obj = new Arr(100);
        $obj[5] = $kValue;

        $obj->forEach($callbackfn);

        self::assertTrue($testResult, 'testResult !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-10.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-11.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-12.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-13.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-14.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-15.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-16.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-17.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-18.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-19.js
    // Reason: the JS Arguments object has no PHP equivalent

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-2.js.
     */
    public function test1544187Ci2(): void
    {
        $testResult = false;

        $callbackfn = static function (mixed $val, int $idx) use (&$testResult): void {
            if (0 === $idx) {
                $testResult = (11 === $val);
            }
        };

        Arr::of(11)->forEach($callbackfn);

        self::assertTrue($testResult, 'testResult !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-20.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-21.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-22.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-25.js
    // Reason: the JS Arguments object has no PHP equivalent

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-26.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-27.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-28.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-29.js
    // Reason: prototype-chain index properties

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-3.js
    // Reason: prototype-chain index properties

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-30.js
    // Reason: accessor index properties via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-31.js
    // Reason: prototype-chain index properties

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-4.js
    // Reason: prototype-chain index properties

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-5.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-6.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-7.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-8.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-i-9.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-1.js.
     */
    public function test1544187Cii1(): void
    {
        $bPar = true;
        $bCalled = false;

        $callbackfn = static function (mixed $val, int $idx, Arr $obj) use (&$bPar, &$bCalled): void {
            $bCalled = true;
            if ($obj[$idx] !== $val) {
                $bPar = false;
            }
        };

        $arr = new Arr(0, 1, true, null, new \stdClass(), 'five');
        $arr[999999] = -6.6;
        $arr->forEach($callbackfn);

        self::assertTrue($bCalled, 'bCalled');
        self::assertTrue($bPar, 'bPar');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-10.js.
     */
    public function test1544187Cii10(): void
    {
        $result = false;

        $callbackfn = static function (int $val) use (&$result): void {
            $result = ($val > 10);
        };

        Arr::of(11)->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-11.js.
     */
    public function test1544187Cii11(): void
    {
        $result = false;

        $callbackfn = static function (int $val, int $idx) use (&$result): void {
            $args = \func_get_args();
            $result = ($val > 10 && $args[2][$idx] === $val);
        };

        Arr::of(11)->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-12.js.
     */
    public function test1544187Cii12(): void
    {
        $result = false;

        $callbackfn = static function (int $val, int $idx, Arr $obj) use (&$result): void {
            $result = ($val > 10 && $obj[$idx] === $val);
        };

        Arr::of(11)->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-13.js.
     */
    public function test1544187Cii13(): void
    {
        $result = false;

        $callbackfn = static function () use (&$result): void {
            $args = \func_get_args();
            $result = ($args[2][$args[1]] === $args[0]);
        };

        Arr::of(11)->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-16.js
    // Reason: primitive thisArg wrapped into a Boolean object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-17.js
    // Reason: primitive thisArg wrapped into a Number object; thisArg is typed ?object

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-18.js
    // Reason: primitive thisArg wrapped into a String object; thisArg is typed ?object

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-19.js.
     */
    public function test1544187Cii19(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr with a string property.
        $accessed = false;
        $result = true;

        $callbackfn = static function (mixed $val) use (&$accessed, &$result): void {
            $accessed = true;
            if (8 === $val) {
                $result = false;
            }
        };

        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[10] = 12;
        $obj['non_index_property'] = 8;

        $obj->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
        self::assertTrue($accessed, 'accessed !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-2.js.
     */
    public function test1544187Cii2(): void
    {
        $parCnt = 3;
        $bCalled = false;

        $callbackfn = static function () use (&$parCnt, &$bCalled): void {
            $bCalled = true;
            if (3 !== \func_num_args()) {
                $parCnt = \func_num_args();
            }
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $arr->forEach($callbackfn);

        self::assertTrue($bCalled, 'bCalled');
        self::assertSame(3, $parCnt, 'parCnt');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-20.js.
     */
    public function test1544187Cii20(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr.
        $result = false;

        $callbackfn = function () use (&$result): void {
            $result = (10 === $this->threshold);
        };

        $thisArg = new \stdClass();
        $thisArg->threshold = 10;

        $obj = new Arr(1);
        $obj[0] = 11;

        $obj->forEach($callbackfn, $thisArg);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-21.js.
     */
    public function test1544187Cii21(): void
    {
        // Adapted: the JS array-like object becomes an Arr.
        $resultOne = false;
        $resultTwo = false;

        $callbackfn = static function (int $val, int $idx) use (&$resultOne, &$resultTwo): void {
            if (0 === $idx) {
                $resultOne = (11 === $val);
            }

            if (1 === $idx) {
                $resultTwo = (12 === $val);
            }
        };

        $obj = new Arr(11, 12);

        $obj->forEach($callbackfn);

        self::assertTrue($resultOne, 'resultOne !== true');
        self::assertTrue($resultTwo, 'resultTwo !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-22.js.
     */
    public function test1544187Cii22(): void
    {
        // Adapted: the JS array-like object becomes an Arr.
        $resultOne = false;
        $resultTwo = false;

        $callbackfn = static function (int $val, int $idx) use (&$resultOne, &$resultTwo): void {
            if (11 === $val) {
                $resultOne = (0 === $idx);
            }

            if (12 === $val) {
                $resultTwo = (1 === $idx);
            }
        };

        $obj = new Arr(11, 12);

        $obj->forEach($callbackfn);

        self::assertTrue($resultOne, 'resultOne !== true');
        self::assertTrue($resultTwo, 'resultTwo !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-23.js.
     */
    public function test1544187Cii23(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr.
        $result = false;

        $obj = new Arr(2);
        $obj[0] = 11;

        $callbackfn = static function (mixed $val, int $idx, Arr $o) use (&$result, $obj): void {
            $result = ($obj === $o);
        };

        $obj->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-4.js.
     */
    public function test1544187Cii4(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4, 5);
        $lastIdx = 0;
        $called = 0;
        $result = true;

        $callbackfn = static function (mixed $val, int $idx) use (&$lastIdx, &$called, &$result): void {
            ++$called;
            if ($lastIdx !== $idx) {
                $result = false;
            } else {
                ++$lastIdx;
            }
        };

        $arr->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
        self::assertSame($arr->length, $called, 'arr.length');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-5.js.
     */
    public function test1544187Cii5(): void
    {
        $result = true;
        $kIndex = [];

        // By below way, we could verify that k would be set as 0, 1, ..., length - 1
        // in order, and each value will be set one time.
        $callbackfn = static function (mixed $val, int $idx) use (&$result, &$kIndex): void {
            // Each position should be visited one time, which means k is accessed
            // one time during iterations.
            if (!isset($kIndex[$idx])) {
                // When current position is visited, its previous index should have
                // been visited.
                if (0 !== $idx && !isset($kIndex[$idx - 1])) {
                    $result = false;
                }
                $kIndex[$idx] = 1;
            } else {
                $result = false;
            }
        };

        (new Arr(11, 12, 13, 14))->forEach($callbackfn, null);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-6.js.
     */
    public function test1544187Cii6(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr.
        $result = false;

        $obj = new Arr(1);
        $obj[0] = 11;
        $thisArg = new \stdClass();

        $callbackfn = function () use (&$result, $obj, $thisArg): void {
            $args = \func_get_args();
            $result = ($this === $thisArg
                && 11 === $args[0]
                && 0 === $args[1]
                && $args[2] === $obj);
        };

        $obj->forEach($callbackfn, $thisArg);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-7.js.
     */
    public function test1544187Cii7(): void
    {
        // Adapted: the JS array-like object becomes a sparse Arr.
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
            $obj->forEach($callbackfn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertFalse($accessed, 'accessed');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-8.js.
     */
    public function test1544187Cii8(): void
    {
        // Adapted: the JS array-like object becomes an Arr.
        $result = false;

        $obj = new Arr(11, 12);

        $callbackfn = static function (mixed $val, int $idx) use (&$result, $obj): void {
            if (0 === $idx) {
                $obj[$idx + 1] = 8;
            }

            if (1 === $idx) {
                $result = (8 === $val);
            }
        };

        $obj->forEach($callbackfn);

        self::assertTrue($result, 'result !== true');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-7-c-ii-9.js.
     */
    public function test1544187Cii9(): void
    {
        $called = 0;

        $callbackfn = static function () use (&$called): void {
            ++$called;
        };

        (new Arr(11, 12))->forEach($callbackfn);

        self::assertSame(2, $called, 'called');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-8-1.js.
     */
    public function test15441881(): void
    {
        $callCnt = 0;

        $cb = static function () use (&$callCnt): void {
            ++$callCnt;
        };

        (new Arr())->forEach($cb);

        self::assertSame(0, $callCnt, 'callCnt');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-10.js
    // Reason: subclassed array via prototype chain

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-8-11.js.
     */
    public function test154418811(): void
    {
        $callbackfn = static function (): void {};

        $arr = new Arr(1, 2, 3, 4, 5);
        $arr->forEach($callbackfn);

        self::assertSame(1, $arr[0], 'arr[0]');
        self::assertSame(2, $arr[1], 'arr[1]');
        self::assertSame(3, $arr[2], 'arr[2]');
        self::assertSame(4, $arr[3], 'arr[3]');
        self::assertSame(5, $arr[4], 'arr[4]');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-8-12.js.
     */
    public function test154418812(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): void {
            ++$callCnt;
        };

        $arr = new Arr(1, 2, 3, 4, 5);
        $arr['i'] = 10;
        $arr[true] = 11;

        $arr->forEach($callbackfn);

        self::assertSame(5, $callCnt, 'callCnt');
    }

    /**
     * test/built-ins/Array/prototype/forEach/15.4.4.18-8-13.js.
     */
    public function test154418813(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        $result = (new Arr())->forEach($callbackfn);

        self::assertNull($result, 'typeof result');
        self::assertFalse($accessed, 'accessed');
    }

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-2.js
    // Reason: subclassed array with length type conversion

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-3.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-4.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-5.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-6.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-7.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-8.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/15.4.4.18-8-9.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/S15.4.4.18_A1.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/S15.4.4.18_A2.js
    // Reason: Object.freeze of the built-in forEach function is JS-only

    // SKIPPED: test/built-ins/Array/prototype/forEach/call-with-boolean.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/callbackfn-resize-arraybuffer.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/length.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/name.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/not-a-constructor.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/prop-desc.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/resizable-buffer-grow-mid-iteration.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/resizable-buffer-shrink-mid-iteration.js
    // Reason: forEach applied to a boolean primitive `this`

    // SKIPPED: test/built-ins/Array/prototype/forEach/resizable-buffer.js
    // Reason: forEach applied to a boolean primitive `this`
}
