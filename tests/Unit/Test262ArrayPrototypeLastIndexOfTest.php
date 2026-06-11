<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.lastIndexOf tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeLastIndexOfTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-1.js
    // Reason: lastIndexOf.call(undefined); ToObject coercion of this is JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-10.js
    // Reason: applied to the Math object via call(); array-likes are JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-12.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-14.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-15.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-2.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-3.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-4.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-8.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-1-9.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-1.js
    // Reason: 'length' on array-like objects via call(); JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-10.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-12.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-14.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-17.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-18.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-19.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-2.js.
     */
    public function test15441522(): void
    {
        // Note: JS additionally pollutes Array.prototype[2]; prototype-chain lookup does not apply to Arr,
        // the relevant behavior is that the search is limited by length.
        $targetObj = new \stdClass();

        self::assertSame(1, (new Arr(0, $targetObj))->lastIndexOf($targetObj), '(new Arr(0, $targetObj))->lastIndexOf($targetObj)');
        self::assertSame(-1, (new Arr(0, 1))->lastIndexOf($targetObj), '(new Arr(0, 1))->lastIndexOf($targetObj)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-3.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-4.js.
     */
    public function test15441524(): void
    {
        // Note: JS overrides the inherited Array.prototype.length; irrelevant for Arr.
        $targetObj = new \stdClass();

        self::assertSame(1, (new Arr(0, $targetObj, 2))->lastIndexOf($targetObj), '(new Arr(0, $targetObj, 2))->lastIndexOf($targetObj)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-8.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-2-9.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-1.js
    // Reason: 'length' value coercion on array-like objects; Arr->length is always int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-10.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-12.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-14.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-15.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-16.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-17.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-18.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-19.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-2.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-20.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-21.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-22.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-23.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-24.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-25.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-28.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-3.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-4.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-3-9.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-1.js.
     */
    public function test15441541(): void
    {
        $i = (new Arr())->lastIndexOf(42);

        self::assertSame(-1, $i, 'The value of $i is expected to be -1');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-10.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-2.js
    // Reason: call() on array-like with coerced 'length'; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-3.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-4.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-8.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-4-9.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-1.js
    // Reason: fromIndex coercion from string; Arr::lastIndexOf() fromIndex is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-10.js
    // Reason: fromIndex coercion from float; Arr::lastIndexOf() fromIndex is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-12.js
    // Reason: fromIndex Infinity is not representable as int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-14.js
    // Reason: fromIndex NaN is not representable as int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-15.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-16.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-17.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-18.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-19.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-2.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-20.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-21.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-22.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-23.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-24.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-25.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-26.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-27.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-28.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-29.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-3.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-30.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-31.js
    // Reason: float fromIndex truncation; Arr::lastIndexOf() fromIndex is typed ?int

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-32.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-33.js.
     */
    public function test154415533(): void
    {
        self::assertSame(0, (new Arr(0, 1, 2, 3, 4))->lastIndexOf(0, 0), '(new Arr(0, 1, 2, 3, 4))->lastIndexOf(0, 0)');
        self::assertSame(0, (new Arr(0, 1, 2, 3, 4))->lastIndexOf(0, 2), '(new Arr(0, 1, 2, 3, 4))->lastIndexOf(0, 2)');
        self::assertSame(2, (new Arr(0, 1, 2, 3, 4))->lastIndexOf(2, 2), '(new Arr(0, 1, 2, 3, 4))->lastIndexOf(2, 2)');
        self::assertSame(2, (new Arr(0, 1, 2, 3, 4))->lastIndexOf(2, 4), '(new Arr(0, 1, 2, 3, 4))->lastIndexOf(2, 4)');
        self::assertSame(4, (new Arr(0, 1, 2, 3, 4))->lastIndexOf(4, 4), '(new Arr(0, 1, 2, 3, 4))->lastIndexOf(4, 4)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-4.js.
     */
    public function test15441554(): void
    {
        $a = new Arr(1, 2, 1);

        // Arr deviation: in JS an explicitly passed undefined fromIndex coerces to 0, while
        // omitting it means len - 1. Arr uses null for "not passed", so null behaves like
        // omitting the argument in JS (search from the end) instead of JS's 0-behavior.
        self::assertSame(1, $a->lastIndexOf(2, null), '$a->lastIndexOf(2, null) searches from the end');
        self::assertSame(2, $a->lastIndexOf(1, null), '$a->lastIndexOf(1, null) searches from the end');
        self::assertSame(2, $a->lastIndexOf(1), '$a->lastIndexOf(1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-5.js.
     */
    public function test15441555(): void
    {
        $a = new Arr(1, 2, 1);

        // Arr deviation: in JS a null fromIndex coerces to 0; Arr's ?int fromIndex treats null
        // as "not passed" and searches from the end (JS would return -1 and 0 here).
        self::assertSame(1, $a->lastIndexOf(2, null), '$a->lastIndexOf(2, null) searches from the end');
        self::assertSame(2, $a->lastIndexOf(1, null), '$a->lastIndexOf(1, null) searches from the end');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-6.js.
     */
    public function test15441556(): void
    {
        $arr = new Arr(0, 1, 2, 3, 4);

        // 'fromIndex' will be set as 4 if not passed by default
        self::assertSame($arr->lastIndexOf(0, 4), $arr->lastIndexOf(0), '$arr->lastIndexOf(0)');
        self::assertSame($arr->lastIndexOf(2, 4), $arr->lastIndexOf(2), '$arr->lastIndexOf(2)');
        self::assertSame($arr->lastIndexOf(4, 4), $arr->lastIndexOf(4), '$arr->lastIndexOf(4)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-7.js.
     */
    public function test15441557(): void
    {
        self::assertSame(-1, (new Arr(0, 100))->lastIndexOf(100, 0), 'verify fromIndex is not more than 0');
        self::assertSame(0, (new Arr(200, 0))->lastIndexOf(200, 0), 'verify fromIndex is not less than 0');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-8.js.
     */
    public function test15441558(): void
    {
        self::assertSame(-1, (new Arr(0, true))->lastIndexOf(true, +0), '(new Arr(0, true))->lastIndexOf(true, +0)');
        self::assertSame(0, (new Arr(true, 0))->lastIndexOf(true, +0), '(new Arr(true, 0))->lastIndexOf(true, +0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-5-9.js.
     */
    public function test15441559(): void
    {
        // PHP ints have no -0; -0 is the same int as 0.
        self::assertSame(-1, (new Arr(0, true))->lastIndexOf(true, -0), '(new Arr(0, true))->lastIndexOf(true, -0)');
        self::assertSame(0, (new Arr(true, 0))->lastIndexOf(true, -0), '(new Arr(true, 0))->lastIndexOf(true, -0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-1.js.
     */
    public function test15441561(): void
    {
        $a = new Arr(1, 2, 3);

        // JS uses the floats 5.4 and 3.1 (ToInteger truncates them); Arr's fromIndex is typed
        // int, so the already-truncated values are used.
        self::assertSame(2, $a->lastIndexOf(3, 5), '$a->lastIndexOf(3, 5)');
        self::assertSame(2, $a->lastIndexOf(3, 3), '$a->lastIndexOf(3, 3)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-2.js.
     */
    public function test15441562(): void
    {
        self::assertSame(2, (new Arr(1, 2, 3))->lastIndexOf(3, 2), '(new Arr(1, 2, 3))->lastIndexOf(3, 2)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-3.js.
     */
    public function test15441563(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3))->lastIndexOf(3, 1), '(new Arr(1, 2, 3))->lastIndexOf(3, 1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-4.js.
     */
    public function test15441564(): void
    {
        self::assertSame(-1, (new Arr())->lastIndexOf(1, 0), '(new Arr())->lastIndexOf(1, 0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-5.js.
     */
    public function test15441565(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3))->lastIndexOf(3, 1), '(new Arr(1, 2, 3))->lastIndexOf(3, 1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-6-6.js.
     */
    public function test15441566(): void
    {
        self::assertSame(1, (new Arr(1, 2, 3))->lastIndexOf(2, 1), '(new Arr(1, 2, 3))->lastIndexOf(2, 1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-7-1.js.
     */
    public function test15441571(): void
    {
        $a = new Arr(1, 2, 3);

        self::assertSame(1, $a->lastIndexOf(2, -2), '$a->lastIndexOf(2, -2)');
        self::assertSame(-1, $a->lastIndexOf(2, -3), '$a->lastIndexOf(2, -3)');
        // JS uses -5.3 (ToInteger truncates towards zero to -5); fromIndex is typed int.
        self::assertSame(-1, $a->lastIndexOf(1, -5), '$a->lastIndexOf(1, -5)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-7-2.js.
     */
    public function test15441572(): void
    {
        self::assertSame(3, (new Arr(1, 2, 3, 4))->lastIndexOf(4, -1), '(new Arr(1, 2, 3, 4))->lastIndexOf(4, -1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-7-3.js.
     */
    public function test15441573(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3, 4))->lastIndexOf(3, -3), '(new Arr(1, 2, 3, 4))->lastIndexOf(3, -3)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-7-4.js.
     */
    public function test15441574(): void
    {
        self::assertSame(-1, (new Arr(1, 2, 3, 4))->lastIndexOf(2, -4), '(new Arr(1, 2, 3, 4))->lastIndexOf(2, -4)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-1.js.
     */
    public function test15441581(): void
    {
        $obj = new \stdClass();
        $false = false;
        $a = new Arr(false, true, false, $obj, $false, true, 'true', null, 0, null, 1, 'str', 0, 1);

        self::assertSame(5, $a->lastIndexOf(true), '$a[5] = true');
        self::assertSame(4, $a->lastIndexOf(false), '$a[4] = $false');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-10.js.
     */
    public function test154415810(): void
    {
        $nan = NAN;
        $a = new Arr('NaN', $nan, NAN, null, 0, false, null, new \stdClass(), 'false');

        self::assertSame(-1, $a->lastIndexOf(NAN), 'NaN matches nothing, not even itself');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-11.js
    // Reason: Object.defineProperty getter side effects; JS-only

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-2.js.
     */
    public function test15441582(): void
    {
        $obj = new \stdClass();
        $one = 1;
        $float = -(4 / 3);
        // JS -0 at index 3 is represented as the float -0.0 (PHP ints have no -0).
        $a = new Arr(+0, true, 0, -0.0, false, null, null, '0', $obj, $float, -(4 / 3), -1.3333333333333, 'str', $one, 1, false);

        self::assertSame(10, $a->lastIndexOf(-(4 / 3)), '$a[10] = -(4/3)');
        self::assertSame(3, $a->lastIndexOf(0), '$a[3] = -0.0, but using === -0.0 and 0 are equal');
        self::assertSame(3, $a->lastIndexOf(-0.0), '$a[3] = -0.0');
        self::assertSame(14, $a->lastIndexOf(1), '$a[14] = 1');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-3.js.
     */
    public function test15441583(): void
    {
        $obj = new \stdClass();
        $szFalse = 'false';
        $a = new Arr($szFalse, 'false', 'false1', null, 0, false, null, 1, $obj, 0);

        self::assertSame(1, $a->lastIndexOf('false'), '$a->lastIndexOf("false")');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-4.js.
     */
    public function test15441584(): void
    {
        $obj = new \stdClass();
        $undefined1 = null;
        $undefined2 = null;
        $a = new Arr($undefined1, $undefined2, null, true, 0, false, null, 1, 'undefined', $obj, 1);

        // Arr deviation: JS distinguishes undefined (indexes 0-2) from null (index 6) and
        // expects 2; both map to PHP null, so the last null at index 6 is found.
        self::assertSame(6, $a->lastIndexOf(null), '$a->lastIndexOf(null)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-5.js.
     */
    public function test15441585(): void
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = $obj1;
        $a = new Arr($obj2, $obj1, $obj3, false, null, 0, false, null, new \stdClass(), 'false');

        self::assertSame(2, $a->lastIndexOf($obj3), '$a->lastIndexOf($obj3)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-6.js.
     */
    public function test15441586(): void
    {
        $obj = new \stdClass();
        $null = null;
        $a = new Arr(true, null, 0, false, null, 1, 'str', 0, 1, null, true, false, null, $null, 'null', null, 'str', $obj);

        // Arr deviation: JS expects 13 ($null) because the undefined at index 15 is not null;
        // both map to PHP null, so the last null at index 15 is found.
        self::assertSame(15, $a->lastIndexOf(null), '$a->lastIndexOf(null)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-7.js.
     */
    public function test15441587(): void
    {
        $a = new Arr(0, 1, 2, 3);
        $a[2] = $a;

        self::assertSame(2, $a->lastIndexOf($a), '$a->lastIndexOf($a)');
        self::assertSame(3, $a->lastIndexOf(3), '$a->lastIndexOf(3)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-8.js.
     */
    public function test15441588(): void
    {
        $b = new Arr('0,1');
        $a = new Arr(0, $b, '0,1', 3);

        self::assertSame(2, $a->lastIndexOf($b->toString()), '$a->lastIndexOf($b->toString())');
        self::assertSame(2, $a->lastIndexOf('0,1'), '$a->lastIndexOf("0,1")');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-9.js.
     */
    public function test15441589(): void
    {
        $a = new Arr(0, 1);
        $a[4294967294] = 2; // 2^32-2 - is max array element index
        $a[4294967295] = 3; // 2^32-1 added as non-array element property
        $a[4294967296] = 4; // 2^32   added as non-array element property
        $a[4294967297] = 5; // 2^32+1 added as non-array element property
        // stop searching near the end in case implementation actually tries to test all missing elements!!
        $a[4294967200] = 3;
        $a[4294967201] = 4;
        $a[4294967202] = 5;

        self::assertSame(4294967294, $a->lastIndexOf(2), '$a->lastIndexOf(2)');
        self::assertSame(4294967200, $a->lastIndexOf(3), '$a->lastIndexOf(3)');
        self::assertSame(4294967201, $a->lastIndexOf(4), '$a->lastIndexOf(4)');
        self::assertSame(4294967202, $a->lastIndexOf(5), '$a->lastIndexOf(5)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-1.js
    // Reason: Object.defineProperty getter side effects on array-likes; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-10.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-12.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-14.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-15.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-16.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-17.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-18.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-19.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-2.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-3.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-4.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-8.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-a-9.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-1.js.
     */
    public function test1544158B1(): void
    {
        $a = new Arr(3);
        $a[0] = 0;
        $a[2] = 2;

        self::assertSame(-1, $a->lastIndexOf(null), 'holes are not visited');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-1.js
    // Reason: element lookup on array-like objects via call(); JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-10.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-11.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-12.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-13.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-14.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-15.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-16.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-17.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-18.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-19.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-2.js.
     */
    public function test1544158BI2(): void
    {
        self::assertSame(2, (new Arr(true, true, true))->lastIndexOf(true), '(new Arr(true, true, true))->lastIndexOf(true)');
        self::assertSame(1, (new Arr(true, true, false))->lastIndexOf(true), '(new Arr(true, true, false))->lastIndexOf(true)');
        self::assertSame(0, (new Arr(true, false, false))->lastIndexOf(true), '(new Arr(true, false, false))->lastIndexOf(true)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-20.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-21.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-22.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-25.js
    // Reason: applied to the Arguments object; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-26.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-27.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-28.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-29.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-3.js
    // Reason: prototype-chain element lookup; Arr has no prototype chain

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-30.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-31.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-4.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-5.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-6.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-7.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-8.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-i-9.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-1.js.
     */
    public function test1544158BII1(): void
    {
        self::assertSame(-1, (new Arr('true'))->lastIndexOf(true), '(new Arr("true"))->lastIndexOf(true)');
        self::assertSame(-1, (new Arr('0'))->lastIndexOf(0), '(new Arr("0"))->lastIndexOf(0)');
        self::assertSame(-1, (new Arr(false))->lastIndexOf(0), '(new Arr(false))->lastIndexOf(0)');
        self::assertSame(-1, (new Arr(null))->lastIndexOf(0), '(new Arr(null))->lastIndexOf(0)'); // [undefined]
        self::assertSame(-1, (new Arr(null))->lastIndexOf(0), '(new Arr(null))->lastIndexOf(0)'); // [null]
        self::assertSame(-1, (new Arr(new Arr()))->lastIndexOf(0), '(new Arr(new Arr()))->lastIndexOf(0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-10.js.
     */
    public function test1544158BII10(): void
    {
        self::assertSame(1, (new Arr(false, true))->lastIndexOf(true), '(new Arr(false, true))->lastIndexOf(true)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-11.js.
     */
    public function test1544158BII11(): void
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $obj3 = $obj2;

        self::assertSame(0, (new Arr($obj2, $obj1))->lastIndexOf($obj3), '(new Arr($obj2, $obj1))->lastIndexOf($obj3)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-2.js.
     */
    public function test1544158BII2(): void
    {
        self::assertSame(0, (new Arr(null))->lastIndexOf(), '(new Arr(null))->lastIndexOf()');
        self::assertSame(0, (new Arr(null))->lastIndexOf(null), '(new Arr(null))->lastIndexOf(null)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-3.js.
     */
    public function test1544158BII3(): void
    {
        self::assertSame(0, (new Arr(null))->lastIndexOf(null), '(new Arr(null))->lastIndexOf(null)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-4.js.
     */
    public function test1544158BII4(): void
    {
        self::assertSame(-1, (new Arr(+NAN, NAN, -NAN))->lastIndexOf(NAN), '(new Arr(+NAN, NAN, -NAN))->lastIndexOf(NAN)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-5.js.
     */
    public function test1544158BII5(): void
    {
        self::assertSame(-1, (new Arr(+NAN, NAN, -NAN))->lastIndexOf(-NAN), '(new Arr(+NAN, NAN, -NAN))->lastIndexOf(-NAN)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-6.js.
     */
    public function test1544158BII6(): void
    {
        // JS -0 is represented as the float -0.0 (PHP ints have no -0); strict equality
        // compares int/float numerically, so 0 and -0.0 are equal.
        $a = new Arr();
        $a[0] = +0;

        self::assertSame(0, $a->lastIndexOf(-0.0), '$a->lastIndexOf(-0.0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-7.js.
     */
    public function test1544158BII7(): void
    {
        $a = new Arr();
        $a[0] = -0.0;

        self::assertSame(0, $a->lastIndexOf(+0), '$a->lastIndexOf(+0)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-8.js.
     */
    public function test1544158BII8(): void
    {
        self::assertSame(0, (new Arr(-1, 0, 1))->lastIndexOf(-1), '(new Arr(-1, 0, 1))->lastIndexOf(-1)');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-ii-9.js.
     */
    public function test1544158BII9(): void
    {
        self::assertSame(0, (new Arr('abc', 'ab', 'bca', ''))->lastIndexOf('abc'), '(new Arr("abc", "ab", "bca", ""))->lastIndexOf("abc")');
    }

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-iii-1.js.
     */
    public function test1544158BIII1(): void
    {
        self::assertSame(3, (new Arr(2, 1, 2, 2, 1))->lastIndexOf(2), '(new Arr(2, 1, 2, 2, 1))->lastIndexOf(2)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-8-b-iii-2.js
    // Reason: Object.defineProperty getters track element access; JS-only

    /**
     * test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-9-1.js.
     */
    public function test15441591(): void
    {
        $a = new Arr();
        $a[100] = 1;
        $a[99999] = '';
        $a[10] = new \stdClass();
        $a[5555] = 5.5;
        $a[123456] = 'str';
        $a[5] = INF; // JS uses 1E+309 which overflows to Infinity

        self::assertSame(100, $a->lastIndexOf(1), '$a->lastIndexOf(1)');
        self::assertSame(99999, $a->lastIndexOf(''), '$a->lastIndexOf("")');
        self::assertSame(123456, $a->lastIndexOf('str'), '$a->lastIndexOf("str")');
        self::assertSame(5555, $a->lastIndexOf(5.5), '$a->lastIndexOf(5.5)');
        self::assertSame(5, $a->lastIndexOf(INF), '$a->lastIndexOf(INF)');

        self::assertSame(-1, $a->lastIndexOf(true), '$a->lastIndexOf(true)');
        self::assertSame(-1, $a->lastIndexOf(5), '$a->lastIndexOf(5)');
        self::assertSame(-1, $a->lastIndexOf('str1'), '$a->lastIndexOf("str1")');
        self::assertSame(-1, $a->lastIndexOf(null), '$a->lastIndexOf(null)');
        self::assertSame(-1, $a->lastIndexOf(new \stdClass()), '$a->lastIndexOf(new \stdClass())');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/15.4.4.15-9-2.js
    // Reason: Object.defineProperty getter on array-like; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/call-with-boolean.js
    // Reason: call() on boolean primitive; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/calls-only-has-on-prototype-after-length-zeroed.js
    // Reason: Proxy traps; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/coerced-position-grow.js
    // Reason: TypedArrays backed by resizable ArrayBuffers; JS-only

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/coerced-position-shrink.js

    /**
     * test/built-ins/Array/prototype/lastIndexOf/fromindex-zero-conversion.js.
     */
    public function testFromindexZeroConversion(): void
    {
        // JS asserts 1 / lastIndexOf(...) === +Infinity to prove +0 (not -0) is returned;
        // PHP ints have no -0, so asserting the int 0 is sufficient.
        self::assertSame(0, (new Arr(true))->lastIndexOf(true, -0), '(new Arr(true))->lastIndexOf(true, -0)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/length-near-integer-limit.js
    // Reason: array-like with length near 2^53-1; Arr caps length at 2^32-1

    /**
     * test/built-ins/Array/prototype/lastIndexOf/length-zero-returns-minus-one.js.
     */
    public function testLengthZeroReturnsMinusOne(): void
    {
        self::assertSame(-1, (new Arr())->lastIndexOf(1), '(new Arr())->lastIndexOf(1)');
        // JS verifies fromIndex is not coerced when length is 0 (its valueOf would throw);
        // Arr's typed int fromIndex cannot carry that side effect, so only the early
        // return for length 0 is verified.
        self::assertSame(-1, (new Arr())->lastIndexOf(2, 5), '(new Arr())->lastIndexOf(2, 5)');
    }

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/length.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/name.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/lastIndexOf/resizable-buffer.js
    // Reason: TypedArrays backed by resizable ArrayBuffers; JS-only
}
