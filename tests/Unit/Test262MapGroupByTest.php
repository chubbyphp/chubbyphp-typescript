<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.groupBy tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapGroupByTest extends TestCase
{
    /**
     * test/built-ins/Map/groupBy/callback-arg.js.
     */
    public function testCallbackArg(): void
    {
        $arr = new Arr(-0.0, 0.0, 1, 2, 3);

        $calls = 0;

        Map::groupBy($arr, static function ($n, $i) use (&$calls, $arr): mixed {
            ++$calls;
            self::assertSame($arr[$i], $n, 'selected element aligns with index');
            self::assertSame(2, \func_num_args(), 'only two arguments are passed');

            return null;
        });

        self::assertSame(5, $calls, 'called for all 5 elements');
    }

    /**
     * test/built-ins/Map/groupBy/callback-throws.js.
     */
    public function testCallbackThrows(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('throw in callback');

        $array = Arr::of(1);
        Map::groupBy($array, static function (): void {
            throw new \Exception('throw in callback');
        });
    }

    /**
     * test/built-ins/Map/groupBy/emptyList.js.
     */
    public function testEmptyList(): void
    {
        $original = new Arr();

        $map = Map::groupBy($original, static function (): void {
            throw new \Exception('callback function should not be called');
        });

        self::assertInstanceOf(Map::class, $map, 'Map::groupBy returns a map');
        self::assertSame(0, $map->size, 'map of empty list has size 0');
    }

    /**
     * test/built-ins/Map/groupBy/evenOdd.js.
     */
    public function testEvenOdd(): void
    {
        $array = new Arr(1, 2, 3);

        $map = Map::groupBy($array, static fn (int $i): string => 0 === $i % 2 ? 'even' : 'odd');

        self::assertSame(['odd', 'even'], iterator_to_array($map->keys()), 'keys are in insertion order');
        self::assertSame([2], $map->get('even')->toArray(), "group 'even' contains [2]");
        self::assertSame([1, 3], $map->get('odd')->toArray(), "group 'odd' contains [1, 3]");
    }

    /**
     * test/built-ins/Map/groupBy/groupLength.js.
     */
    public function testGroupLength(): void
    {
        $arr = new Arr('hello', 'test', 'world');

        $map = Map::groupBy($arr, static fn (string $i): int => \strlen($i));

        self::assertSame([5, 4], iterator_to_array($map->keys()), 'keys are in insertion order');
        self::assertSame(['hello', 'world'], $map->get(5)->toArray(), 'group 5 contains [hello, world]');
        self::assertSame(['test'], $map->get(4)->toArray(), 'group 4 contains [test]');
    }

    /**
     * test/built-ins/Map/groupBy/invalid-callback.js.
     *
     * Adapted: PHP's native `callable` parameter type rejects non-callables at the
     * call boundary with a TypeError; only one throwing call is possible per test.
     */
    public function testInvalidCallback(): void
    {
        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line intentionally passing null instead of a callable
        Map::groupBy(new Arr(), null);
    }

    /**
     * test/built-ins/Map/groupBy/invalid-iterable.js.
     *
     * Adapted: PHP's native `iterable` parameter type rejects non-iterables at the
     * call boundary with a TypeError, so the callback is never called.
     */
    public function testInvalidIterable(): void
    {
        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line intentionally passing a non-iterable object
        Map::groupBy(new \stdClass(), static function (): void {
            throw new \Exception('callback function should not be called');
        });
    }

    /**
     * test/built-ins/Map/groupBy/iterator-next-throws.js.
     */
    public function testIteratorNextThrows(): void
    {
        $throwingIterator = (static function (): \Generator {
            throw new \Exception('next() method was called');

            // @phpstan-ignore-next-line unreachable yield turns this function into a generator
            yield null;
        })();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('next() method was called');

        Map::groupBy($throwingIterator, static fn (): string => 'key');
    }

    // SKIPPED: test/built-ins/Map/groupBy/length.js
    // Reason: function `length` property descriptor is not portable to PHP

    /**
     * test/built-ins/Map/groupBy/map-instance.js.
     */
    public function testMapInstance(): void
    {
        $array = new Arr(1, 2, 3);

        $map = Map::groupBy($array, static fn (int $i): string => 0 === $i % 2 ? 'even' : 'odd');

        self::assertInstanceOf(Map::class, $map, 'Map::groupBy returns a Map instance');
    }

    // SKIPPED: test/built-ins/Map/groupBy/name.js
    // Reason: function `name` property descriptor is not portable to PHP

    /**
     * test/built-ins/Map/groupBy/negativeZero.js.
     */
    public function testNegativeZero(): void
    {
        $arr = new Arr(-0.0, 0.0);

        $map = Map::groupBy($arr, static fn (float $i): float => $i);

        self::assertSame(1, $map->size, '-0 and +0 end up in a single group');

        // assertSame(-0.0, 0.0) passes in PHP, so prove the key was canonicalized
        // to +0 via its string representation ('-0' would betray a -0.0 key).
        foreach ($map->keys() as $key) {
            self::assertSame('0', (string) $key, 'key -0 is normalized to +0');
        }

        self::assertSame([-0.0, 0.0], $map->get(0)->toArray(), 'group 0 contains [-0, 0]');
    }

    /**
     * test/built-ins/Map/groupBy/string.js.
     *
     * Adapted: Map::groupBy() takes an iterable, so the string is split into its
     * characters via Arr::from(). PHP's byte-wise UTF-8 string comparison agrees
     * with JS' UTF-16 code unit comparison for these characters (verified in node).
     */
    public function testString(): void
    {
        $string = '🥰💩🙏😈';

        $map = Map::groupBy(Arr::from($string), static fn (string $char): string => $char < '🙏' ? 'before' : 'after');

        self::assertSame(['after', 'before'], iterator_to_array($map->keys()), 'keys are in insertion order');
        self::assertSame(['💩', '😈'], $map->get('before')->toArray(), "group 'before' contains [💩, 😈]");
        self::assertSame(['🥰', '🙏'], $map->get('after')->toArray(), "group 'after' contains [🥰, 🙏]");
    }

    /**
     * test/built-ins/Map/groupBy/toPropertyKey.js.
     *
     * Adapted: PHP has no ToPropertyKey either — the test's point (keys keep their
     * type/identity, int 1, string '1' and a stringable object stay three distinct
     * keys) ports directly using an object with __toString().
     */
    public function testToPropertyKey(): void
    {
        $stringable = new class {
            public function __toString(): string
            {
                return '1';
            }
        };

        $array = new Arr(1, '1', $stringable);

        $map = Map::groupBy($array, static fn ($v) => $v);

        self::assertSame([1, '1', $stringable], iterator_to_array($map->keys()), 'keys are not coerced');
        self::assertSame(['1'], $map->get('1')->toArray(), "group '1' contains ['1']");
        self::assertSame([1], $map->get(1)->toArray(), 'group 1 contains [1]');
        self::assertSame([$stringable], $map->get($stringable)->toArray(), 'group $stringable contains [$stringable]');
    }
}
