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
        $seen = [];

        Map::groupBy(new Arr('a', 'b'), static function (string $value, int $index) use (&$seen): string {
            $seen[] = [$value, $index];

            return $value;
        });

        self::assertSame([['a', 0], ['b', 1]], $seen);
    }

    /**
     * test/built-ins/Map/groupBy/callback-throws.js.
     */
    public function testCallbackThrows(): void
    {
        $this->expectException(\RuntimeException::class);

        Map::groupBy(new Arr(1), static function (): string {
            throw new \RuntimeException('err');
        });
    }

    /**
     * test/built-ins/Map/groupBy/emptyList.js.
     */
    public function testEmptyList(): void
    {
        $grouped = Map::groupBy(new Arr(), static fn (): string => 'k');

        self::assertSame(0, $grouped->size);
    }

    /**
     * test/built-ins/Map/groupBy/evenOdd.js.
     */
    public function testEvenOdd(): void
    {
        $grouped = Map::groupBy(new Arr(1, 2, 3, 4, 5), static fn (int $n): string => 0 === $n % 2 ? 'even' : 'odd');

        self::assertSame([2, 4], $grouped->get('even')->toArray());
        self::assertSame([1, 3, 5], $grouped->get('odd')->toArray());
    }

    /**
     * test/built-ins/Map/groupBy/groupLength.js.
     */
    public function testGroupLength(): void
    {
        $grouped = Map::groupBy(new Arr(1, 2, 3, 4, 5), static fn (int $n): string => 0 === $n % 2 ? 'even' : 'odd');

        self::assertSame(2, $grouped->get('even')->length);
        self::assertSame(3, $grouped->get('odd')->length);
    }

    /**
     * test/built-ins/Map/groupBy/invalid-callback.js.
     */
    public function testInvalidCallback(): void
    {
        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line
        Map::groupBy(new Arr(1), 'not-a-callback');
    }

    /**
     * test/built-ins/Map/groupBy/invalid-iterable.js.
     */
    public function testInvalidIterable(): void
    {
        $this->expectException(\TypeError::class);

        // @phpstan-ignore-next-line
        Map::groupBy(123, static fn ($x) => $x);
    }

    /**
     * test/built-ins/Map/groupBy/iterator-next-throws.js.
     */
    public function testIteratorNextThrows(): void
    {
        $generator = (static function (): \Generator {
            yield 1;

            throw new \RuntimeException('iterator error');
        })();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('iterator error');

        Map::groupBy($generator, static fn ($x) => $x);
    }

    // SKIPPED: test/built-ins/Map/groupBy/length.js
    // Reason: function length / descriptor tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/groupBy/name.js
    // Reason: function name / descriptor tests are not portable to PHP

    /**
     * test/built-ins/Map/groupBy/map-instance.js.
     */
    public function testMapInstance(): void
    {
        $grouped = Map::groupBy(new Arr(1, 2), static fn (int $n): string => 'k');

        self::assertInstanceOf(Map::class, $grouped);
    }

    /**
     * test/built-ins/Map/groupBy/negativeZero.js.
     */
    public function testNegativeZero(): void
    {
        $grouped = Map::groupBy(new Arr(1, 2), static fn (int $n, int $i): float => 0 === $i ? -0.0 : 0.0);

        self::assertSame(1, $grouped->size);
        self::assertSame([1, 2], $grouped->get(0.0)->toArray());
    }

    /**
     * test/built-ins/Map/groupBy/string.js.
     */
    public function testString(): void
    {
        $grouped = Map::groupBy(new Arr('a', 'b', 'aa', 'bb'), static fn (string $s): string => 0 === \strlen($s) % 2 ? 'even' : 'odd');

        self::assertSame(['aa', 'bb'], $grouped->get('even')->toArray());
        self::assertSame(['a', 'b'], $grouped->get('odd')->toArray());
    }

    // SKIPPED: test/built-ins/Map/groupBy/toPropertyKey.js
    // Reason: PHP does not coerce object keys via toPropertyKey; object identity is used
}
