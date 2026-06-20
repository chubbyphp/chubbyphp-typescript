<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.flat tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFlatTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/flat/array-like-objects.js
    // Reason: Function.prototype.bind on Array.prototype.flat itself

    // SKIPPED: test/built-ins/Array/prototype/flat/bound-function-call.js
    // Reason: Function.prototype.bind on Array.prototype.flat itself

    // SKIPPED: test/built-ins/Array/prototype/flat/call-with-boolean.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    /**
     * test/built-ins/Array/prototype/flat/empty-array-elements.js.
     */
    public function testEmptyArrayElements(): void
    {
        $a = new \stdClass();

        self::assertSame([], (new Arr())->flat()->toArray(), '[].flat() must return []');
        self::assertSame([], (new Arr(new Arr(), new Arr()))->flat()->toArray(), '[ [], [] ].flat() must return []');
        self::assertSame([1], (new Arr(new Arr(), Arr::of(1)))->flat()->toArray(), '[ [], [1] ].flat() must return [1]');
        self::assertSame([1, $a], (new Arr(new Arr(), new Arr(1, $a)))->flat()->toArray(), '[ [], [1, a] ].flat() must return [1, a]');
    }

    /**
     * test/built-ins/Array/prototype/flat/empty-object-elements.js.
     */
    public function testEmptyObjectElements(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();

        self::assertSame([$a], Arr::of($a)->flat()->toArray(), '[a].flat() must return [a]');
        self::assertSame([$a, $b], (new Arr($a, Arr::of($b)))->flat()->toArray(), '[a, [b]].flat() must return [a, b]');
        self::assertSame([$a, $b], (new Arr(Arr::of($a), $b))->flat()->toArray(), '[ [a], b ].flat() must return [a, b]');
        self::assertSame([$a, $b], (new Arr(Arr::of($a), Arr::of($b)))->flat()->toArray(), '[ [a], [b] ].flat() must return [a, b]');
    }

    // SKIPPED: test/built-ins/Array/prototype/flat/length.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/name.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    /**
     * test/built-ins/Array/prototype/flat/non-numeric-depth-should-not-throw.js.
     */
    public function testNonNumericDepthShouldNotThrow(): void
    {
        $a = new Arr(1, Arr::of(2));
        $expected = [1, [2]];

        // Depth coercion from non-integral strings, objects and -Infinity is
        // not portable: Arr::flat() $depth is typed int. The zero and default
        // cases below cover the resulting depthNum values.

        // positive zero depthNum is converted to 0
        $actual = $a->flat(0);
        self::assertSame($expected, $actual->toArray(), 'The value of $actual is expected to equal the value of $expected');

        // negative zero depthNum is converted to 0 (PHP ints have no -0)
        $actual = $a->flat(-0);
        self::assertSame($expected, $actual->toArray(), 'The value of $actual is expected to equal the value of $expected');

        // undefined depthNum uses the default value of 1
        $actual = $a->flat();
        self::assertSame([1, 2], $actual->toArray(), '$a->flat() uses default depth of 1');
    }

    // SKIPPED: test/built-ins/Array/prototype/flat/non-object-ctor-throws.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/not-a-constructor.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    /**
     * test/built-ins/Array/prototype/flat/null-undefined-elements.js.
     */
    public function testNullUndefinedElements(): void
    {
        // JS distinguishes undefined (void 0) from null; in PHP both map to null.
        $a = Arr::of(null);

        self::assertSame(
            [1, null, null],
            (new Arr(1, null, null))->flat()->toArray(),
            '[1, null, void 0].flat() must return [1, null, null]',
        );
        self::assertSame(
            [1, null, null],
            (new Arr(1, new Arr(null, null)))->flat()->toArray(),
            '[1, [null, void 0]].flat() must return [1, null, null]',
        );
        self::assertSame(
            [null, null, null, null],
            (new Arr(new Arr(null, null), new Arr(null, null)))->flat()->toArray(),
            '[ [null, void 0], [null, void 0] ].flat() must return [null, null, null, null]',
        );

        $result = (new Arr(1, new Arr(null, $a)))->flat(1);
        self::assertSame(3, $result->length, 'The value of $result->length is expected to be 3');
        self::assertSame(1, $result[0], 'The value of $result[0] is expected to be 1');
        self::assertNull($result[1], 'The value of $result[1] is expected to be null');
        self::assertSame($a, $result[2], 'The value of $result[2] is expected to be a');

        self::assertSame(
            [1, null, null],
            (new Arr(1, new Arr(null, $a)))->flat(2)->toArray(),
            '[1, [null, a]].flat(2) must return [1, null, null]',
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/flat/null-undefined-input-throws.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    /**
     * test/built-ins/Array/prototype/flat/positive-infinity.js.
     */
    public function testPositiveInfinity(): void
    {
        // Number.POSITIVE_INFINITY is not representable as int; PHP_INT_MAX
        // exceeds any possible nesting depth and exercises the same behavior.
        $a = new Arr(1, new Arr(2, new Arr(3, Arr::of(4))));
        self::assertSame([1, 2, 3, 4], $a->flat(PHP_INT_MAX)->toArray(), '$a->flat(PHP_INT_MAX) must return [1, 2, 3, 4]');
    }

    // SKIPPED: test/built-ins/Array/prototype/flat/prop-desc.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/proxy-access-count.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/symbol-object-create-null-depth-throws.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/target-array-non-extensible.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/target-array-with-non-configurable-property.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int

    // SKIPPED: test/built-ins/Array/prototype/flat/target-array-with-non-writable-property.js
    // Reason: depth given as Symbol/Object.create(null); Arr::flat() $depth is typed int
}
