<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.every tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeEveryTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-0-1.js.
     */
    public function test15441601(): void
    {
        self::assertIsCallable([new Arr(), 'every'], 'typeof(f) is expected to be "function"');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-1.js
    // Reason: this coercion (call on undefined)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-10.js
    // Reason: this coercion (call on the Math object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-11.js
    // Reason: this coercion (call on a Date object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-12.js
    // Reason: this coercion (call on a RegExp object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-13.js
    // Reason: this coercion (call on the JSON object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-14.js
    // Reason: this coercion (call on an Error object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-15.js
    // Reason: this coercion (call on the Arguments object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-2.js
    // Reason: this coercion (call on null)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-3.js
    // Reason: this coercion (call on a boolean primitive)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-4.js
    // Reason: this coercion (call on a Boolean object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-5.js
    // Reason: this coercion (call on a number primitive)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-6.js
    // Reason: this coercion (call on a Number object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-7.js
    // Reason: this coercion (call on a string primitive)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-8.js
    // Reason: this coercion (call on a String object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-1-9.js
    // Reason: this coercion (call on a Function object)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-1.js
    // Reason: array-like object with own 'length' data property

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-10.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-11.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-12.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-13.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-14.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-17.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-18.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-19.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-2.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-3.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-4.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-5.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-6.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-7.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-8.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-2-9.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-1.js
    // Reason: 'length' coercion on array-like objects

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-10.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-11.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-12.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-13.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-14.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-15.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-16.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-17.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-18.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-19.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-2.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-20.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-21.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-22.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-23.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-24.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-25.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-29.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-3.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-4.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-5.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-6.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-7.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-8.js

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-3-9.js

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-1.js.
     */
    public function test15441641(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line missing argument on purpose
        $arr->every();
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-4-10.js
    // Reason: 'length' accessor property throwing on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-4-11.js
    // Reason: 'length' toString coercion throwing on an array-like object

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-12.js.
     */
    public function test154416412(): void
    {
        $callbackfn = static fn (int $val): bool => $val > 10;

        self::assertFalse((new Arr(11, 9))->every($callbackfn), '(new Arr(11, 9))->every($callbackfn) is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-4-15.js
    // Reason: 'length' accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-3.js.
     */
    public function test15441643(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->every(null);
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-4.js.
     */
    public function test15441644(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->every(true);
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-5.js.
     */
    public function test15441645(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->every(5);
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-6.js.
     */
    public function test15441646(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        $arr->every('abc');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-4-7.js.
     */
    public function test15441647(): void
    {
        $arr = new Arr(10);

        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line non-callable on purpose
        $arr->every(new \stdClass());
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-4-8.js
    // Reason: 'length' accessor property side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-4-9.js
    // Reason: 'length' toString coercion side effects on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-1-s.js
    // Reason: JS strict-mode 'this' semantics for unbound callbacks

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-1.js
    // Reason: JS global object as default 'this' for unbound callbacks

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-10.js.
     */
    public function test154416510(): void
    {
        $accessed = false;
        $objArray = new Arr();

        $callbackfn = function () use (&$accessed, $objArray): bool {
            $accessed = true;

            return $this === $objArray;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn, $objArray), 'Arr::of(11)->every($callbackfn, $objArray) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-11.js
    // Reason: String wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-12.js
    // Reason: Boolean wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-13.js
    // Reason: Number wrapper object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-14.js
    // Reason: the Math object as thisArg

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-15.js.
     */
    public function test154416515(): void
    {
        $accessed = false;
        $objDate = new \DateTimeImmutable('@0');

        $callbackfn = function () use (&$accessed, $objDate): bool {
            $accessed = true;

            return $this === $objDate;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn, $objDate), 'Arr::of(11)->every($callbackfn, $objDate) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-16.js
    // Reason: RegExp object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-17.js
    // Reason: the JSON object as thisArg

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-18.js.
     */
    public function test154416518(): void
    {
        $accessed = false;
        $objError = new RangeError();

        $callbackfn = function () use (&$accessed, $objError): bool {
            $accessed = true;

            return $this === $objError;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn, $objError), 'Arr::of(11)->every($callbackfn, $objError) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-19.js
    // Reason: the Arguments object as thisArg

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-2.js.
     */
    public function test15441652(): void
    {
        $o = new \stdClass();
        $o->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->every($callbackfn, $o), '$arr->every($callbackfn, $o) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-21.js
    // Reason: the global object as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-22.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-23.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-24.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-3.js.
     */
    public function test15441653(): void
    {
        $a = new Arr();
        $a['res'] = true;

        $callbackfn = fn (): bool => true === $this['res'];

        $arr = Arr::of(1);

        self::assertTrue($arr->every($callbackfn, $a), '$arr->every($callbackfn, $a) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-4.js.
     */
    public function test15441654(): void
    {
        // JS: property inherited from the constructor prototype; PHP: property declared on the class.
        $f = new class {
            public bool $res = true;
        };

        $callbackfn = fn (): bool => $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->every($callbackfn, $f), '$arr->every($callbackfn, $f) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-5-5.js.
     */
    public function test15441655(): void
    {
        $f = new \stdClass();
        $f->res = true;

        $callbackfn = fn (): bool => true === $this->res;

        $arr = Arr::of(1);

        self::assertTrue($arr->every($callbackfn, $f), '$arr->every($callbackfn, $f) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-6.js
    // Reason: function as thisArg; PHP Closures do not support dynamic properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-7.js
    // Reason: built-in function (eval) as thisArg

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-5-9.js
    // Reason: Function object as thisArg; PHP Closures do not support dynamic properties

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-1.js.
     */
    public function test15441671(): void
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

            return true;
        };

        $arr->every($callbackfn);

        self::assertTrue($calledForThree, 'The value of $calledForThree is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-2.js.
     */
    public function test15441672(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr[4] = 6;

            return $val < 6;
        };

        self::assertFalse($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-3.js.
     */
    public function test15441673(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        $callbackfn = static function (int $val) use ($arr): bool {
            unset($arr[2]);

            return 3 !== $val;
        };

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-4.js.
     */
    public function test15441674(): void
    {
        $arr = new Arr(1, 2, 3, 4, 6);

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr->length = 3;

            return $val < 4;
        };

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-5.js.
     */
    public function test15441675(): void
    {
        $arr = new Arr(10);
        $arr[1] = 1;
        $arr[2] = 2;

        $callbackfn = static function (int $val) use ($arr): bool {
            $arr[1000] = 3;

            return $val < 3;
        };

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-6.js
    // Reason: Array.prototype index pollution

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-7.js.
     */
    public function test15441677(): void
    {
        $o = new \stdClass();
        $o->arr = new Arr(1, 2, 3, 4, 5);

        // Adapted: JS deletes the 'arr' property; the project CS forbids unset() on
        // properties, so it is cleared by assigning null instead.
        $callbackfn = static function (int $val, int $idx) use ($o): bool {
            $o->arr = null;

            return $val === $idx + 1;
        };

        $arr = $o->arr;

        self::assertTrue($arr->every($callbackfn), '$o->arr->every($callbackfn) is expected to be true');
        self::assertNull($o->arr, 'The value of $o->arr is expected to be null');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-8.js
    // Reason: array-like object with 'length' 0

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-9.js
    // Reason: index accessor property on an array-like object

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-b-1.js.
     */
    public function test1544167B1(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return true;
        };

        $arr = new Arr(10);
        $arr[1] = null;
        $arr->every($callbackfn);

        self::assertSame(1, $callCnt, 'The value of $callCnt is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-10.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-11.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-12.js
    // Reason: Object.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-13.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-14.js
    // Reason: index accessor property (getter decreasing length)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-15.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-16.js
    // Reason: non-configurable index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-2.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-3.js
    // Reason: 'length' accessor property on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-4.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-5.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-6.js
    // Reason: Object.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-7.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-8.js
    // Reason: index accessor properties on an array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-b-9.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-1.js
    // Reason: array-like object

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-10.js
    // Reason: index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-11.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-12.js
    // Reason: Array.prototype index pollution / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-13.js
    // Reason: prototype-chain / index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-14.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-15.js
    // Reason: prototype-chain index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-16.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-17.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-18.js
    // Reason: index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-19.js
    // Reason: index accessor property without getter / Object.prototype pollution

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-2.js.
     */
    public function test1544167CI2(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return 11 === $val;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertSame(1, $called, 'The value of $called is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-20.js
    // Reason: index accessor property without getter / Array.prototype pollution

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-21.js
    // Reason: prototype-chain index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-22.js
    // Reason: Array.prototype index accessor property without getter

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-25.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-26.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-27.js
    // Reason: Arguments object as this

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-28.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-29.js
    // Reason: index accessor properties (getter side effects)

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-3.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-30.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-31.js
    // Reason: index accessor property throwing

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-4.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-5.js
    // Reason: prototype-chain / Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-6.js
    // Reason: Array.prototype index accessor properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-7.js
    // Reason: prototype-chain data properties

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-8.js
    // Reason: Array.prototype index pollution

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-i-9.js
    // Reason: index accessor properties on an array-like object

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-1.js.
     */
    public function test1544167CII1(): void
    {
        $callbackfn = static fn (int $val, int $idx, Arr $obj): bool => $obj[$idx] === $val;

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-10.js.
     */
    public function test1544167CII10(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return $val > 10;
        };

        self::assertTrue((new Arr(11, 12))->every($callbackfn), '(new Arr(11, 12))->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-11.js.
     */
    public function test1544167CII11(): void
    {
        $called = 0;

        $callbackfn = static function (int $val, int $idx) use (&$called): bool {
            ++$called;
            $args = \func_get_args();

            return $val > 10 && $args[2][$idx] === $val;
        };

        self::assertTrue((new Arr(11, 12))->every($callbackfn), '(new Arr(11, 12))->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-12.js.
     */
    public function test1544167CII12(): void
    {
        $called = 0;

        $callbackfn = static function (int $val, int $idx, Arr $obj) use (&$called): bool {
            ++$called;

            return $val > 10 && $obj[$idx] === $val;
        };

        self::assertTrue((new Arr(11, 12, 13))->every($callbackfn), '(new Arr(11, 12, 13))->every($callbackfn) is expected to be true');
        self::assertSame(3, $called, 'The value of $called is expected to be 3');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-13.js.
     */
    public function test1544167CII13(): void
    {
        $called = 0;

        $callbackfn = static function () use (&$called): bool {
            ++$called;
            $args = \func_get_args();

            return $args[2][$args[1]] === $args[0];
        };

        self::assertTrue((new Arr(11, 12))->every($callbackfn), '(new Arr(11, 12))->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-16.js
    // Reason: boolean primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-17.js
    // Reason: number primitive as thisArg; Arr only binds objects

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-18.js
    // Reason: string primitive as thisArg; Arr only binds objects

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-19.js.
     */
    public function test1544167CII19(): void
    {
        $called = 0;

        $callbackfn = static function (int $val) use (&$called): bool {
            ++$called;

            return 8 !== $val;
        };

        // JS array-like object adapted to a sparse Arr; non-index keys become properties.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[10] = 12;
        $obj['non_index_property'] = 8;

        self::assertTrue($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-2.js.
     */
    public function test1544167CII2(): void
    {
        // verify if callbackfn was called with 3 parameters
        $callbackfn = static fn (): bool => 3 === \func_num_args();

        $arr = new Arr(0, 1, true, null, new \stdClass(), 'five');
        $arr[999999] = -6.6;

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-20.js.
     */
    public function test1544167CII20(): void
    {
        $accessed = false;

        $callbackfn = function () use (&$accessed): bool {
            $accessed = true;

            return 10 === $this->threshold;
        };

        $thisArg = new \stdClass();
        $thisArg->threshold = 10;

        $obj = Arr::of(11);

        self::assertTrue($obj->every($callbackfn, $thisArg), '$obj->every($callbackfn, $thisArg) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-21.js.
     */
    public function test1544167CII21(): void
    {
        $accessed = false;

        $callbackfn = static function (int $val, int $idx) use (&$accessed): bool {
            $accessed = true;

            if (0 === $idx) {
                return 11 === $val;
            }

            if (1 === $idx) {
                return 12 === $val;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        self::assertTrue($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-22.js.
     */
    public function test1544167CII22(): void
    {
        $accessed = false;

        $callbackfn = static function (int $val, int $idx) use (&$accessed): bool {
            $accessed = true;

            if (11 === $val) {
                return 0 === $idx;
            }

            if (12 === $val) {
                return 1 === $idx;
            }

            return false;
        };

        $obj = new Arr(11, 12);

        self::assertTrue($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-23.js.
     */
    public function test1544167CII23(): void
    {
        $called = 0;
        $obj = new Arr(11, 12);

        $callbackfn = static function (int $val, int $idx, Arr $o) use (&$called, $obj): bool {
            ++$called;

            return $obj === $o;
        };

        self::assertTrue($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-3.js.
     */
    public function test1544167CII3(): void
    {
        $callCnt = 0;

        $callbackfn = static function (int $val, int $idx) use (&$callCnt): bool {
            ++$callCnt;

            return $idx <= 5;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertFalse($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be false');
        self::assertSame(7, $callCnt, 'The value of $callCnt is expected to be 7');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-4.js.
     */
    public function test1544167CII4(): void
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

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
        self::assertSame($arr->length, $called, 'The value of $called is expected to equal the value of $arr->length');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-5.js.
     */
    public function test1544167CII5(): void
    {
        $called = 0;
        $kIndex = [];

        // By below way, we could verify that k would be set as 0, 1, ..., length - 1 in order, and each value will be set one time.
        $callbackfn = static function (int $val, int $idx) use (&$called, &$kIndex): bool {
            ++$called;

            // Each position should be visited one time, which means k is accessed one time during iterations.
            if (!isset($kIndex[$idx])) {
                // when current position is visited, its previous index should have been visited.
                if (0 !== $idx && !isset($kIndex[$idx - 1])) {
                    return false;
                }
                $kIndex[$idx] = 1;

                return true;
            }

            return false;
        };

        self::assertTrue((new Arr(11, 12, 13, 14))->every($callbackfn, null), '(new Arr(11, 12, 13, 14))->every($callbackfn, null) is expected to be true');
        self::assertSame(4, $called, 'The value of $called is expected to be 4');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-6.js.
     */
    public function test1544167CII6(): void
    {
        $accessed = false;
        $thisArg = new \stdClass();
        $obj = Arr::of(11);

        $callbackfn = function () use (&$accessed, $thisArg, $obj): bool {
            $accessed = true;
            $args = \func_get_args();

            return $this === $thisArg
                && 11 === $args[0]
                && 0 === $args[1]
                && $args[2] === $obj;
        };

        self::assertTrue($obj->every($callbackfn, $thisArg), '$obj->every($callbackfn, $thisArg) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-7.js.
     */
    public function test1544167CII7(): void
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
            $obj->every($callbackfn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        self::assertSame(1, $called, 'The value of $called is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-8.js.
     */
    public function test1544167CII8(): void
    {
        $obj = new Arr(11, 12);

        $callbackfn = static function (int $val, int $idx) use ($obj): bool {
            if (0 === $idx) {
                $obj[$idx + 1] = 8;
            }

            return $val > 10;
        };

        self::assertFalse($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be false');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-ii-9.js.
     */
    public function test1544167CII9(): void
    {
        $called = 0;

        $callbackfn = static function () use (&$called): bool {
            ++$called;

            return true;
        };

        self::assertTrue((new Arr(11, 12))->every($callbackfn), '(new Arr(11, 12))->every($callbackfn) is expected to be true');
        self::assertSame(2, $called, 'The value of $called is expected to be 2');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-1.js.
     */
    public function test1544167CIII1(): void
    {
        $accessed = false;
        $obj = Arr::of(11);

        // JS callbackfn returns undefined (falsy); PHP equivalent: null (falsy).
        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        self::assertFalse($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-10.js.
     */
    public function test1544167CIII10(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): float {
            $accessed = true;

            return INF;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-11.js.
     */
    public function test1544167CIII11(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): float {
            $accessed = true;

            return -INF;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-12.js
    // Reason: NaN is falsy in JS but truthy in PHP (every() would return true instead of
    // false, and PHP 8.5 emits an "unexpected NAN value was coerced to bool" warning)

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-13.js.
     */
    public function test1544167CIII13(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): string {
            $accessed = true;

            return '';
        };

        self::assertFalse(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-14.js.
     */
    public function test1544167CIII14(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): string {
            $accessed = true;

            return 'non-empty string';
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-15.js.
     */
    public function test1544167CIII15(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): \Closure {
            $accessed = true;

            return static function (): void {};
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-16.js.
     */
    public function test1544167CIII16(): void
    {
        $accessed = false;

        // JS [] is an Array object (truthy); PHP equivalent: an empty Arr instance (objects are truthy).
        $callbackfn = static function () use (&$accessed): Arr {
            $accessed = true;

            return new Arr();
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-17.js
    // Reason: String wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-18.js
    // Reason: Boolean wrapper object as return value

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-19.js
    // Reason: Number wrapper object as return value

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-2.js.
     */
    public function test1544167CIII2(): void
    {
        $accessed = false;
        $obj = Arr::of(11);

        $callbackfn = static function () use (&$accessed): void {
            $accessed = true;
        };

        self::assertFalse($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-20.js
    // Reason: the Math object as return value

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-21.js.
     */
    public function test1544167CIII21(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): \DateTimeImmutable {
            $accessed = true;

            return new \DateTimeImmutable('@0');
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-22.js
    // Reason: RegExp object as return value

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-23.js
    // Reason: the JSON object as return value

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-24.js.
     */
    public function test1544167CIII24(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): \Exception {
            $accessed = true;

            return new \Exception();
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-25.js.
     */
    public function test1544167CIII25(): void
    {
        $accessed = false;

        // JS returns the arguments object (truthy); PHP equivalent: the non-empty args array (truthy).
        $callbackfn = static function () use (&$accessed): array {
            $accessed = true;

            return \func_get_args();
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-27.js
    // Reason: the global object as return value

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-28.js.
     */
    public function test1544167CIII28(): void
    {
        $result = false;

        // Adapted: the JS test uses index getters; here the callback tracks that no
        // element after the first false result is visited.
        $obj = new Arr(20);
        $obj[0] = 11;
        $obj[1] = 8;
        $obj[2] = 8;

        $callbackfn = static function (int $val, int $idx) use (&$result): bool {
            if ($idx > 1) {
                $result = true;
            }

            return $val > 10;
        };

        self::assertFalse($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be false');
        self::assertFalse($result, 'The value of $result is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-29.js
    // Reason: Boolean wrapper object (new Boolean(false)) as return value

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-3.js.
     */
    public function test1544167CIII3(): void
    {
        $accessed = false;
        $obj = Arr::of(11);

        $callbackfn = static function () use (&$accessed): bool {
            $accessed = true;

            return false;
        };

        self::assertFalse($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-4.js.
     */
    public function test1544167CIII4(): void
    {
        $accessed = false;
        $obj = Arr::of(11);

        $callbackfn = static function () use (&$accessed): bool {
            $accessed = true;

            return true;
        };

        self::assertTrue($obj->every($callbackfn), '$obj->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-5.js.
     */
    public function test1544167CIII5(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return 0;
        };

        self::assertFalse(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-6.js.
     */
    public function test1544167CIII6(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return +0;
        };

        self::assertFalse(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-7.js.
     */
    public function test1544167CIII7(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): float {
            $accessed = true;

            return -0.0;
        };

        self::assertFalse(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be false');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-8.js.
     */
    public function test1544167CIII8(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return 5;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-7-c-iii-9.js.
     */
    public function test1544167CIII9(): void
    {
        $accessed = false;

        $callbackfn = static function () use (&$accessed): int {
            $accessed = true;

            return -5;
        };

        self::assertTrue(Arr::of(11)->every($callbackfn), 'Arr::of(11)->every($callbackfn) is expected to be true');
        self::assertTrue($accessed, 'The value of $accessed is expected to be true');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-8-1.js.
     */
    public function test15441681(): void
    {
        $cb = static fn (): bool => true;
        $i = (new Arr())->every($cb);

        self::assertTrue($i, 'The value of $i is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-10.js
    // Reason: subclassed Array

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-8-11.js.
     */
    public function test154416811(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return true;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
        self::assertSame(10, $callCnt, 'The value of $callCnt is expected to be 10');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-8-12.js.
     */
    public function test154416812(): void
    {
        $callbackfn = static fn (): bool => true;

        $arr = new Arr(1, 2, 3, 4, 5);
        $arr->every($callbackfn);

        self::assertSame(1, $arr[0], 'The value of $arr[0] is expected to be 1');
        self::assertSame(2, $arr[1], 'The value of $arr[1] is expected to be 2');
        self::assertSame(3, $arr[2], 'The value of $arr[2] is expected to be 3');
        self::assertSame(4, $arr[3], 'The value of $arr[3] is expected to be 4');
        self::assertSame(5, $arr[4], 'The value of $arr[4] is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/every/15.4.4.16-8-13.js.
     */
    public function test154416813(): void
    {
        $callCnt = 0;

        $callbackfn = static function () use (&$callCnt): bool {
            ++$callCnt;

            return true;
        };

        $arr = new Arr(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $arr['i'] = 10;
        $arr[true] = 11;

        self::assertTrue($arr->every($callbackfn), '$arr->every($callbackfn) is expected to be true');
        self::assertSame(10, $callCnt, 'The value of $callCnt is expected to be 10');
    }

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-2.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-3.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-4.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-5.js
    // Reason: subclassed Array / length type conversion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-6.js
    // Reason: subclassed Array / length valueOf coercion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-7.js
    // Reason: subclassed Array / length toString coercion

    // SKIPPED: test/built-ins/Array/prototype/every/15.4.4.16-8-8.js
    // Reason: subclassed Array / length array coercion

    // SKIPPED: test/built-ins/Array/prototype/every/call-with-boolean.js
    // Reason: this coercion (call on boolean primitives)

    // SKIPPED: test/built-ins/Array/prototype/every/callbackfn-resize-arraybuffer.js
    // Reason: TypedArray / ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/every/length.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/every/name.js
    // Reason: function property descriptor

    // SKIPPED: test/built-ins/Array/prototype/every/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/every/prop-desc.js
    // Reason: property descriptor

    // SKIPPED: test/built-ins/Array/prototype/every/resizable-buffer-grow-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/every/resizable-buffer-shrink-mid-iteration.js
    // Reason: TypedArray / resizable ArrayBuffer

    // SKIPPED: test/built-ins/Array/prototype/every/resizable-buffer.js
    // Reason: TypedArray / resizable ArrayBuffer
}
