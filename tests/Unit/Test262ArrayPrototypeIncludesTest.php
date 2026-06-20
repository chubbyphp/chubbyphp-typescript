<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.includes tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeIncludesTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/includes/call-with-boolean.js
    // Reason: Infinity/-Infinity are not representable; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/coerced-searchelement-fromindex-resize.js
    // Reason: Infinity/-Infinity are not representable; Arr::includes() $fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/includes/fromIndex-equal-or-greater-length-returns-false.js.
     */
    public function testFromIndexEqualOrGreaterLengthReturnsFalse(): void
    {
        $sample = new Arr(7, 7, 7, 7);
        self::assertFalse($sample->includes(7, 4), 'length');
        self::assertFalse($sample->includes(7, 5), 'length + 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/fromIndex-infinity.js
    // Reason: Infinity/-Infinity are not representable; Arr::includes() $fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/includes/fromIndex-minus-zero.js.
     */
    public function testFromIndexMinusZero(): void
    {
        // PHP ints have no -0; the int literal -0 is identical to 0.
        $sample = new Arr(42, 43);
        self::assertTrue($sample->includes(42, -0), '-0 [0]');
        self::assertTrue($sample->includes(43, -0), '-0 [1]');
        self::assertFalse($sample->includes(44, -0), '-0 [2]');
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/get-prop.js
    // Reason: array-like length coercion via ToLength; not applicable to Arr

    // SKIPPED: test/built-ins/Array/prototype/includes/length-boundaries.js
    // Reason: array-like length coercion via ToLength; not applicable to Arr

    /**
     * test/built-ins/Array/prototype/includes/length-zero-returns-false.js.
     */
    public function testLengthZeroReturnsFalse(): void
    {
        // The fromIndex valueOf-counting object is not portable: $fromIndex is typed int.
        $sample = new Arr();
        self::assertFalse($sample->includes(0), 'returns false');
        self::assertFalse($sample->includes(), 'returns false - no arg');
        self::assertFalse($sample->includes(0, 1), 'using fromIndex');
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/length.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/name.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/includes/no-arg.js.
     */
    public function testNoArg(): void
    {
        self::assertFalse(Arr::of(0)->includes(), '[0].includes()');
        self::assertTrue((new Arr(null))->includes(), '[undefined].includes()');
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/not-a-constructor.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/prop-desc.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/includes/resizable-buffer-special-float-values.js.
     */
    public function testResizableBufferSpecialFloatValues(): void
    {
        // Adapted from the resizable TypedArray test: only the special float
        // value lookups are portable.
        $lengthTracking = new Arr(-INF, INF, NAN, null);
        self::assertTrue($lengthTracking->includes(-INF), 'includes(-INF) must return true');
        self::assertTrue($lengthTracking->includes(INF), 'includes(INF) must return true');
        self::assertTrue($lengthTracking->includes(NAN), 'includes(NAN) must return true');
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/resizable-buffer.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-get-length.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-get-prop.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-tointeger-fromindex-symbol.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-tointeger-fromindex.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-tonumber-length-symbol.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/return-abrupt-tonumber-length.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    /**
     * test/built-ins/Array/prototype/includes/samevaluezero.js.
     */
    public function testSamevaluezero(): void
    {
        $sample = new Arr(42, 0, 1, NAN);
        self::assertFalse($sample->includes('42'), "'42'");
        self::assertFalse($sample->includes([42]), '[42]');
        self::assertTrue($sample->includes(42.0), '42.0');
        self::assertTrue($sample->includes(-0.0), '-0');
        self::assertFalse($sample->includes(true), 'true');
        self::assertFalse($sample->includes(false), 'false');
        self::assertFalse($sample->includes(null), 'null');
        self::assertFalse($sample->includes(''), 'empty string');
        self::assertTrue($sample->includes(NAN), 'NaN');
    }

    /**
     * test/built-ins/Array/prototype/includes/search-found-returns-true.js.
     */
    public function testSearchFoundReturnsTrue(): void
    {
        $obj = new \stdClass();
        $array = new Arr();

        // JS has distinct null and undefined entries; both map to PHP null.
        // Symbol('1') has no PHP equivalent and is omitted; $obj covers object identity.
        $sample = new Arr(42, 'test262', null, null, true, false, 0, -1, '', $obj, $array);

        self::assertTrue($sample->includes(42), '42');
        self::assertTrue($sample->includes('test262'), "'test262'");
        self::assertTrue($sample->includes(null), 'null');
        self::assertTrue($sample->includes(), 'undefined');
        self::assertTrue($sample->includes(true), 'true');
        self::assertTrue($sample->includes(false), 'false');
        self::assertTrue($sample->includes(0), '0');
        self::assertTrue($sample->includes(-1), '-1');
        self::assertTrue($sample->includes(''), 'the empty string');
        self::assertTrue($sample->includes($obj), 'obj');
        self::assertTrue($sample->includes($array), 'array');
    }

    /**
     * test/built-ins/Array/prototype/includes/search-not-found-returns-false.js.
     */
    public function testSearchNotFoundReturnsFalse(): void
    {
        self::assertFalse(Arr::of(42)->includes(43), '43');

        self::assertFalse((new Arr('test262'))->includes('test'), 'string');

        self::assertFalse((new Arr(0, 'test262', null))->includes(''), 'the empty string');

        self::assertFalse((new Arr('true', false))->includes(true), 'true');
        self::assertFalse((new Arr('', true))->includes(false), 'false');

        // Arr deviation: JS distinguishes null from undefined, in PHP both map
        // to null, so these lookups match where JS returns false.
        self::assertTrue((new Arr(null, false, 0, 1))->includes(null), 'null (undefined maps to null)');
        self::assertTrue((new Arr(null))->includes(), 'undefined (null maps to null)');

        // Symbol('1') has no PHP equivalent; distinct objects cover the identity case.
        self::assertFalse((new Arr(new \stdClass()))->includes(new \stdClass()), 'object');
        self::assertFalse((new Arr(new Arr()))->includes(new Arr()), 'array');

        $sample = Arr::of(42);
        self::assertFalse($sample->includes($sample), 'this');
    }

    /**
     * test/built-ins/Array/prototype/includes/sparse.js.
     */
    public function testSparse(): void
    {
        self::assertTrue(
            (new Arr(3))->includes(null),
            '[ , , , ].includes(undefined)',
        );

        $x = new Arr(4);
        $x[3] = 42;
        self::assertFalse(
            $x->includes(null, 4),
            '[ , , , 42, ].includes(undefined, 4)',
        );

        $sample = new Arr(5);
        $sample[3] = 42;

        self::assertTrue(
            $sample->includes(null),
            'sample.includes(undefined)',
        );
        self::assertTrue(
            $sample->includes(null, 4),
            'sample.includes(undefined, 4)',
        );
        self::assertTrue(
            $sample->includes(42, 3),
            'sample.includes(42, 3)',
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/this-is-not-object.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/tointeger-fromindex.js
    // Reason: fromIndex coercion from string/bool/NaN/null/object; Arr::includes() $fromIndex is typed int

    // SKIPPED: test/built-ins/Array/prototype/includes/tolength-length.js
    // Reason: array-like length coercion via ToLength; not applicable to Arr

    /**
     * test/built-ins/Array/prototype/includes/using-fromindex.js.
     */
    public function testUsingFromindex(): void
    {
        $sample = new Arr('a', 'b', 'c');
        self::assertTrue($sample->includes('a', 0), "includes('a', 0)");
        self::assertFalse($sample->includes('a', 1), "includes('a', 1)");
        self::assertFalse($sample->includes('a', 2), "includes('a', 2)");

        self::assertTrue($sample->includes('b', 0), "includes('b', 0)");
        self::assertTrue($sample->includes('b', 1), "includes('b', 1)");
        self::assertFalse($sample->includes('b', 2), "includes('b', 2)");

        self::assertTrue($sample->includes('c', 0), "includes('c', 0)");
        self::assertTrue($sample->includes('c', 1), "includes('c', 1)");
        self::assertTrue($sample->includes('c', 2), "includes('c', 2)");

        self::assertFalse($sample->includes('a', -1), "includes('a', -1)");
        self::assertFalse($sample->includes('a', -2), "includes('a', -2)");
        self::assertTrue($sample->includes('a', -3), "includes('a', -3)");
        self::assertTrue($sample->includes('a', -4), "includes('a', -4)");

        self::assertFalse($sample->includes('b', -1), "includes('b', -1)");
        self::assertTrue($sample->includes('b', -2), "includes('b', -2)");
        self::assertTrue($sample->includes('b', -3), "includes('b', -3)");
        self::assertTrue($sample->includes('b', -4), "includes('b', -4)");

        self::assertTrue($sample->includes('c', -1), "includes('c', -1)");
        self::assertTrue($sample->includes('c', -2), "includes('c', -2)");
        self::assertTrue($sample->includes('c', -3), "includes('c', -3)");
        self::assertTrue($sample->includes('c', -4), "includes('c', -4)");
    }

    // SKIPPED: test/built-ins/Array/prototype/includes/values-are-not-cached.js
    // Reason: array-like length coercion via ToLength; not applicable to Arr
}
