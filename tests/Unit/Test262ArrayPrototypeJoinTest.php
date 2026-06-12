<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.join tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeJoinTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A1.1_T1.js.
     */
    public function testS15445A11T1(): void
    {
        $x = new Arr();
        self::assertSame('', $x->join(), '$x = new Arr(); $x->join() is expected to be ""');

        $x = new Arr();
        $x[0] = 1;
        $x->length = 0;
        self::assertSame('', $x->join(), '$x = new Arr(); $x[0] = 1; $x->length = 0; $x->join() is expected to be ""');
    }

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A1.2_T1.js.
     */
    public function testS15445A12T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        self::assertSame('0,1,2,3', $x->join(), '$x = new Arr(0,1,2,3); $x->join() is expected to be "0,1,2,3"');

        $x = new Arr();
        $x[0] = 0;
        $x[3] = 3;
        self::assertSame('0,,,3', $x->join(), '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->join() is expected to be "0,,,3"');

        $x = new Arr();
        $x[0] = 0;
        self::assertSame('0', $x->join(), '$x = new Arr(); $x[0] = 0; $x->join() is expected to be "0"');
    }

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A1.2_T2.js.
     */
    public function testS15445A12T2(): void
    {
        $x = new Arr(0, 1, 2, 3);
        self::assertSame('0,1,2,3', $x->join(null), '$x = new Arr(0,1,2,3); $x->join(null) is expected to be "0,1,2,3"');

        $x = new Arr();
        $x[0] = 0;
        $x[3] = 3;
        self::assertSame('0,,,3', $x->join(null), '$x = new Arr(); $x[0] = 0; $x[3] = 3; $x->join(null) is expected to be "0,,,3"');

        $x = new Arr();
        $x[0] = 0;
        self::assertSame('0', $x->join(null), '$x = new Arr(); $x[0] = 0; $x->join(null) is expected to be "0"');
    }

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A1.3_T1.js.
     */
    public function testS15445A13T1(): void
    {
        $x = new Arr();
        $x[0] = null;
        self::assertSame('', $x->join(), '$x = new Arr(); $x[0] = null; $x->join() is expected to be ""');

        // JS distinguishes undefined from null; in PHP both map to null and render as "".
        $x = new Arr();
        $x[0] = null;
        self::assertSame('', $x->join(), '$x = new Arr(); $x[0] = null; $x->join() is expected to be ""');

        $x = new Arr(null, 1, null, 3);
        self::assertSame(',1,,3', $x->join(), '$x = new Arr(null,1,null,3); $x->join() is expected to be ",1,,3"');
    }

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A2_T1.js
    // Reason: join called on a non-array object via Array.prototype.join

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A2_T2.js
    // Reason: join called on a non-array object via Array.prototype.join

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A2_T3.js
    // Reason: join called on a non-array object via Array.prototype.join

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A2_T4.js
    // Reason: length coercion via valueOf/toString on a non-array object

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A3.1_T1.js.
     */
    public function testS15445A31T1(): void
    {
        $x = new Arr(0, 1, 2, 3);
        self::assertSame('0123', $x->join(''), '$x->join("") is expected to be "0123"');

        $x = new Arr(0, 1, 2, 3);
        self::assertSame('0\1\2\3', $x->join('\\'), '$x->join("\") is expected to be "0\1\2\3"');

        self::assertSame('0&1&2&3', $x->join('&'), '$x->join("&") is expected to be "0&1&2&3"');

        // Separators true/Infinity/null/NaN rely on ToString coercion and are
        // not portable: Arr::join() is typed ?string and null selects the
        // default comma separator (JS join(null) joins with "null").

        self::assertSame('0,1,2,3', $x->join(null), '$x->join(null) (undefined separator) is expected to be "0,1,2,3"');
    }

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A3.1_T2.js
    // Reason: separator coercion via ToPrimitive(separator, String); Arr::join() is typed ?string

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A3.2_T1.js.
     */
    public function testS15445A32T1(): void
    {
        $x = new Arr('', '', '');
        self::assertSame('', $x->join(''), '$x = new Arr("","",""); $x->join("") is expected to be ""');

        $x = new Arr('\\', '\\', '\\');
        self::assertSame('\\\\\\\\\\', $x->join('\\'), '$x = new Arr("\","\","\"); $x->join("\") is expected to be "\\\\\\\\\"');

        $x = new Arr('&', '&', '&');
        self::assertSame('&&&&&', $x->join('&'), '$x = new Arr("&","&","&"); $x->join("&") is expected to be "&&&&&"');

        $x = new Arr(true, true, true);
        self::assertSame('true,true,true', $x->join(), '$x = new Arr(true,true,true); $x->join() is expected to be "true,true,true"');

        $x = new Arr(null, null, null);
        self::assertSame(',,', $x->join(), '$x = new Arr(null,null,null); $x->join() is expected to be ",,"');

        // JS distinguishes undefined from null; in PHP both map to null.
        $x = new Arr(null, null, null);
        self::assertSame(',,', $x->join(), '$x = new Arr(null,null,null); $x->join() is expected to be ",,"');

        $x = new Arr(INF, INF, INF);
        self::assertSame('Infinity,Infinity,Infinity', $x->join(), '$x = new Arr(INF,INF,INF); $x->join() is expected to be "Infinity,Infinity,Infinity"');

        $x = new Arr(NAN, NAN, NAN);
        self::assertSame('NaN,NaN,NaN', $x->join(), '$x = new Arr(NAN,NAN,NAN); $x->join() is expected to be "NaN,NaN,NaN"');
    }

    /**
     * test/built-ins/Array/prototype/join/S15.4.4.5_A3.2_T2.js.
     */
    public function testS15445A32T2(): void
    {
        // ToPrimitive(argument, String) via valueOf has no PHP equivalent; only
        // the __toString() (toString) cases are portable.
        $object = new class implements \Stringable {
            public function __toString(): string
            {
                return '*';
            }
        };
        $x = new Arr($object);
        self::assertSame('*', $x->join(), '$x->join() is expected to be "*"');

        // Arr deviation: objects without __toString render as "object" instead
        // of "[object Object]".
        $x = new Arr(new \stdClass());
        self::assertSame('object', $x->join(), '$x->join() is expected to be "object"');

        $exception = new \Exception('error');
        $throwing = new class($exception) implements \Stringable {
            public function __construct(private readonly \Exception $exception) {}

            public function __toString(): string
            {
                throw $this->exception;
            }
        };

        try {
            (new Arr($throwing))->join();

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e, 'The value of $e is expected to be the thrown exception');
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A4_T3.js
    // Reason: join called on a non-array object with a negative length

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A5_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/join/S15.4.4.5_A6.6.js

    // SKIPPED: test/built-ins/Array/prototype/join/call-with-boolean.js

    // SKIPPED: test/built-ins/Array/prototype/join/coerced-separator-grow.js

    // SKIPPED: test/built-ins/Array/prototype/join/coerced-separator-shrink.js

    // SKIPPED: test/built-ins/Array/prototype/join/length.js

    // SKIPPED: test/built-ins/Array/prototype/join/name.js

    // SKIPPED: test/built-ins/Array/prototype/join/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/join/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/join/resizable-buffer.js
}
