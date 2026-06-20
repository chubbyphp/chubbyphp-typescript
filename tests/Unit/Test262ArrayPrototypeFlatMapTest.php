<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.flatMap tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeFlatMapTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/flatMap/array-like-objects-nested.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/array-like-objects-poisoned-length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/array-like-objects-typedarrays.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/array-like-objects.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/flatMap/bound-function-argument.js.
     */
    public function testBoundFunctionArgument(): void
    {
        $a = new Arr(0, 0);
        $bound = \Closure::bind(fn () => $this, new Arr(1, 2), Arr::class);

        self::assertSame(
            [1, 2, 1, 2],
            $a->flatMap($bound)->toArray(),
            '$a->flatMap(bound closure returning [1, 2]) must return [1, 2, 1, 2]',
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/flatMap/call-with-boolean.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/flatMap/depth-always-one.js.
     */
    public function testDepthAlwaysOne(): void
    {
        self::assertSame(
            [1, 2, 2, 4],
            (new Arr(1, 2))->flatMap(static fn (int $e) => new Arr($e, $e * 2))->toArray(),
            '[1, 2].flatMap(e => [e, e * 2]) must return [1, 2, 2, 4]',
        );

        $result = (new Arr(1, 2, 3))->flatMap(static fn (int $ele) => Arr::of(Arr::of($ele * 2)));
        self::assertSame(3, $result->length, 'The value of $result->length is expected to be 3');
        self::assertInstanceOf(Arr::class, $result[0]);
        self::assertSame([2], $result[0]->toArray(), 'The value of $result[0] is expected to be [2]');
        self::assertInstanceOf(Arr::class, $result[1]);
        self::assertSame([4], $result[1]->toArray(), 'The value of $result[1] is expected to be [4]');
        self::assertInstanceOf(Arr::class, $result[2]);
        self::assertSame([6], $result[2]->toArray(), 'The value of $result[2] is expected to be [6]');
    }

    // SKIPPED: test/built-ins/Array/prototype/flatMap/length.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/flatMap/mapperfunction-throws.js.
     */
    public function testMapperfunctionThrows(): void
    {
        // Check #1
        $exception = new \Exception();

        try {
            Arr::of(0)->flatMap(static function () use ($exception): never {
                throw $exception;
            });

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }

        // Check #2
        $callcount = 0;
        (new Arr())->flatMap(static function () use (&$callcount): never {
            ++$callcount;

            throw new \Exception();
        });

        self::assertSame(0, $callcount, 'If sourceLen is 0, mapperFunction should not be called.');
    }

    // SKIPPED: test/built-ins/Array/prototype/flatMap/name.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/flatMap/non-callable-argument-throws.js.
     */
    public function testNonCallableArgumentThrows(): void
    {
        // Symbol() has no PHP equivalent; an object covers the non-callable object case.
        foreach ([new \stdClass(), 0, null, false, ''] as $nonCallable) {
            try {
                (new Arr())->flatMap($nonCallable);

                throw new \Exception('Should not be reached');
            } catch (\TypeError $e) {
                self::addToAssertionCount(1);
            }
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/flatMap/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/prop-desc.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/proxy-access-count.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/target-array-non-extensible.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/target-array-with-non-configurable-property.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/target-array-with-non-writable-property.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-ctor-non-object.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-ctor-object-species-bad-throws.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-ctor-object-species-custom-ctor-poisoned-throws.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-ctor-object-species-custom-ctor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-ctor-object-species.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/flatMap/this-value-null-undefined-throws.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/flatMap/thisArg-argument.js.
     */
    public function testThisArgArgument(): void
    {
        // Primitive thisArg values (string/number/null/boolean/undefined) are
        // not portable: Arr::flatMap() $thisArg is typed ?object and only
        // non-static closures are bound.
        $a = new \stdClass();

        $actual = Arr::of(1)->flatMap(fn () => Arr::of($this), $a);
        self::assertSame([$a], $actual->toArray(), 'The value of $actual is expected to be [a]');
    }
}
