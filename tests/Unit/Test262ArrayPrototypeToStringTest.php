<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.toString tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeToStringTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/toString/S15.4.4.2_A1_T1.js.
     */
    public function testS154442A1T1(): void
    {
        $x = new Arr();
        self::assertSame($x->join(), $x->toString(), '#1.1: $x = new Arr(); $x->toString() === $x->join()');
        self::assertSame('', $x->toString(), '#1.2: $x = new Arr(); $x->toString() === ""');

        $x = new Arr();
        $x[0] = 1;
        $x->length = 0;
        self::assertSame($x->join(), $x->toString(), '#2.1: $x = new Arr(); $x[0] = 1; $x->length = 0; $x->toString() === $x->join()');
        self::assertSame('', $x->toString(), '#2.2: $x = new Arr(); $x[0] = 1; $x->length = 0; $x->toString() === ""');
    }

    /**
     * test/built-ins/Array/prototype/toString/S15.4.4.2_A1_T2.js.
     */
    public function testS154442A1T2(): void
    {
        $x = new Arr(0, 1, 2, 3);
        self::assertSame($x->join(), $x->toString(), '#1.1: $x = new Arr(0,1,2,3); $x->toString() === $x->join()');
        self::assertSame('0,1,2,3', $x->toString(), '#1.2: $x = new Arr(0,1,2,3); $x->toString() === "0,1,2,3"');

        $x = new Arr();
        $x[0] = 0;
        $x[3] = 3;
        self::assertSame($x->join(), $x->toString(), '#2.1: $x = new Arr(); $x[0] = 0; $x[3] = 3; $x->toString() === $x->join()');
        self::assertSame('0,,,3', $x->toString(), '#2.2: $x = new Arr(); $x[0] = 0; $x[3] = 3; $x->toString() === "0,,,3"');

        $x = new Arr(null, 1, null, 3);
        self::assertSame($x->join(), $x->toString(), '#3.1: $x = new Arr(null,1,null,3); $x->toString() === $x->join()');
        self::assertSame(',1,,3', $x->toString(), '#3.2: $x = new Arr(null,1,null,3); $x->toString() === ",1,,3"');

        $x = new Arr();
        $x[0] = 0;
        self::assertSame($x->join(), $x->toString(), '#4.1: $x = new Arr(); $x[0] = 0; $x->toString() === $x->join()');
        self::assertSame('0', $x->toString(), '#4.2: $x = new Arr(); $x[0] = 0; $x->toString() === "0"');
    }

    /**
     * test/built-ins/Array/prototype/toString/S15.4.4.2_A1_T3.js.
     */
    public function testS154442A1T3(): void
    {
        $x = new Arr('', '', '');
        self::assertSame($x->join(), $x->toString(), '#0.1: $x = new Arr("","",""); $x->toString() === $x->join()');
        self::assertSame(',,', $x->toString(), '#0.2: $x = new Arr("","",""); $x->toString() === ",,"');

        $x = new Arr('\\', '\\', '\\');
        self::assertSame($x->join(), $x->toString(), '#1.1: $x = new Arr("\\\","\\\","\\\"); $x->toString() === $x->join()');
        self::assertSame('\,\,\\', $x->toString(), '#1.2: $x = new Arr("\\\","\\\","\\\"); $x->toString() === "\\\,\\\,\\\"');

        $x = new Arr('&', '&', '&');
        self::assertSame($x->join(), $x->toString(), '#2.1: $x = new Arr("&", "&", "&"); $x->toString() === $x->join()');
        self::assertSame('&,&,&', $x->toString(), '#2.2: $x = new Arr("&", "&", "&"); $x->toString() === "&,&,&"');

        $x = new Arr(true, true, true);
        self::assertSame($x->join(), $x->toString(), '#3.1: $x = new Arr(true,true,true); $x->toString() === $x->join()');
        self::assertSame('true,true,true', $x->toString(), '#3.2: $x = new Arr(true,true,true); $x->toString() === "true,true,true"');

        $x = new Arr(null, null, null);
        self::assertSame($x->join(), $x->toString(), '#4.1: $x = new Arr(null,null,null); $x->toString() === $x->join()');
        self::assertSame(',,', $x->toString(), '#4.2: $x = new Arr(null,null,null); $x->toString() === ",,"');

        // JS distinguishes undefined and null; both map to PHP null (",,"), so #5 equals #4
        $x = new Arr(null, null, null);
        self::assertSame($x->join(), $x->toString(), '#5.1: $x = new Arr(null,null,null); $x->toString() === $x->join()');
        self::assertSame(',,', $x->toString(), '#5.2: $x = new Arr(null,null,null); $x->toString() === ",,"');

        $x = new Arr(INF, INF, INF);
        self::assertSame($x->join(), $x->toString(), '#6.1: $x = new Arr(INF,INF,INF); $x->toString() === $x->join()');
        self::assertSame('Infinity,Infinity,Infinity', $x->toString(), '#6.2: $x = new Arr(INF,INF,INF); $x->toString() === "Infinity,Infinity,Infinity"');

        $x = new Arr(NAN, NAN, NAN);
        self::assertSame($x->join(), $x->toString(), '#7.1: $x = new Arr(NAN,NAN,NAN); $x->toString() === $x->join()');
        self::assertSame('NaN,NaN,NaN', $x->toString(), '#7.2: $x = new Arr(NAN,NAN,NAN); $x->toString() === "NaN,NaN,NaN"');
    }

    /**
     * test/built-ins/Array/prototype/toString/S15.4.4.2_A1_T4.js.
     */
    public function testS154442A1T4(): void
    {
        // Adapted: PHP has no ToPrimitive/valueOf; objects are stringified via __toString
        $object = new class implements \Stringable {
            public function __toString(): string
            {
                return '*';
            }
        };
        $x = new Arr($object);
        self::assertSame($x->join(), $x->toString(), '$x->toString() must return the same value returned by $x->join()');
        self::assertSame('*', $x->toString(), '$x->toString() must return "*"');

        $throwingObject = new class implements \Stringable {
            public function __toString(): string
            {
                throw new \Exception('error');
            }
        };
        $x = new Arr($throwingObject);

        try {
            $x->toString();

            throw new \RuntimeException('Should not be reached');
        } catch (\Exception $e) {
            self::assertSame('error', $e->getMessage(), 'An exception thrown while stringifying an element propagates from $x->toString()');
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/toString/S15.4.4.2_A3_T1.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/call-with-boolean.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/non-callable-join-string-tag.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toString/prop-desc.js
    // Reason: test262 semantics are not portable to PHP
}
