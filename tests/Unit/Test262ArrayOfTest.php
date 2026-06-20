<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.of tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayOfTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/of/construct-this-with-the-number-of-arguments.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/of/creates-a-new-array-from-arguments.js.
     */
    public function testCreatesANewArrayFromArguments(): void
    {
        $a1 = Arr::of('Mike', 'Rick', 'Leo');
        self::assertSame(3, $a1->length, 'The value of $a1->length is expected to be 3');
        self::assertSame('Mike', $a1[0], 'The value of $a1[0] is expected to be "Mike"');
        self::assertSame('Rick', $a1[1], 'The value of $a1[1] is expected to be "Rick"');
        self::assertSame('Leo', $a1[2], 'The value of $a1[2] is expected to be "Leo"');

        $a2 = Arr::of(null, false, null, null);
        self::assertSame(4, $a2->length, 'The value of $a2->length is expected to be 4');
        self::assertNull($a2[0], 'The value of a2[0] is expected to equal null');
        self::assertFalse($a2[1], 'The value of $a2[1] is expected to be false');
        self::assertNull($a2[2], 'The value of $a2[2] is expected to be null');
        self::assertNull($a2[3], 'The value of a2[3] is expected to equal null');

        $a3 = Arr::of();
        self::assertSame(0, $a3->length, 'The value of $a3->length is expected to be 0');
    }

    // SKIPPED: test/built-ins/Array/of/does-not-use-prototype-properties.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/does-not-use-set-for-indices.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/of.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/proto-from-ctor-realm.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-contructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-data-property.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-data-property-using-proxy.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-setting-length.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/of/return-a-custom-instance.js.
     */
    public function testReturnACustomInstance(): void
    {
        $coop = Arr::of('Mike', 'Rick', 'Leo');

        self::assertSame(3, $coop->length, 'The value of $coop->length is expected to be 3');

        self::assertSame('Mike', $coop[0], 'The value of $coop[0] is expected to be "Mike"');
        self::assertSame('Rick', $coop[1], 'The value of $coop[0] is expected to be "Rick"');
        self::assertSame('Leo', $coop[2], 'The value of $coop[0] is expected to be "Leo"');
    }

    // SKIPPED: test/built-ins/Array/of/return-a-new-array-object.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/of/sets-length.js
    // Reason: test262 semantics are not portable to PHP
}
