<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Integration;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class DocumentationExamplesTest extends TestCase
{
    public function testReadmeUsageExample(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);
        $arr->shift();
        $arr->pop();
        $arr = $arr->map(static fn (int $v): int => $v * 2);
        $arr->push(10);

        self::assertSame([4, 6, 8, 10], self::values($arr));

        $arr = Arr::from([1, 2, 3, 4, 5], static fn (int $v): int => $v * 2);

        self::assertSame([2, 4, 6, 8, 10], self::values($arr));
    }

    public function testDocStaticFromExample(): void
    {
        self::assertSame([null, null], Arr::from(new Arr(2))->toArray());
        self::assertSame(['0:a', '1:b'], Arr::from(['a', 'b'], static fn (string $v, int $i): string => $i.':'.$v)->toArray());
        self::assertSame(['a', 'b', 'c'], Arr::from('abc')->toArray());
    }

    public function testDocStaticIsArrayExample(): void
    {
        self::assertTrue(Arr::isArray(new Arr(1, 2, 3)));
        self::assertFalse(Arr::isArray([1, 2, 3]));
        self::assertFalse(Arr::isArray('hello'));
    }

    public function testDocStaticOfExample(): void
    {
        self::assertSame([3], Arr::of(3)->toArray());
        self::assertSame([1, 2, 3], Arr::of(1, 2, 3)->toArray());
    }

    public function testDocConstructorExample(): void
    {
        self::assertSame([], (new Arr())->toArray());
        self::assertSame([null, null, null, null, null], (new Arr(5))->toArray());
        self::assertSame([1, 2, 3], (new Arr(1, 2, 3))->toArray());
        self::assertSame(['hello'], (new Arr('hello'))->toArray());
    }

    public function testDocLengthExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame(3, $arr->length);

        $arr->push(4);
        self::assertSame(4, $arr->length);

        $arr->pop();
        self::assertSame(3, $arr->length);
    }

    public function testDocMagicToStringExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame('1,2,3', (string) $arr);
    }

    public function testDocAtExample(): void
    {
        $arr = new Arr(10, 20, 30);

        self::assertSame(10, $arr->at(0));
        self::assertSame(30, $arr->at(-1));
        self::assertNull($arr->at(5));
    }

    public function testDocConcatExample(): void
    {
        $a = new Arr(1, 2);

        self::assertSame([1, 2, 3, 4, 5], $a->concat(new Arr(3, 4), 5)->toArray());
    }

    public function testDocCopyWithinExample(): void
    {
        $arr = new Arr('a', 'b', 'c', 'd', 'e');

        self::assertSame(['d', 'b', 'c', 'd', 'e'], $arr->copyWithin(0, 3, 4)->toArray());
        self::assertSame(['d', 'd', 'e', 'd', 'e'], $arr->copyWithin(1, 3)->toArray());
    }

    public function testDocEntriesExample(): void
    {
        $arr = new Arr('x', 'y');

        $entries = [];
        foreach ($arr->entries() as [$i, $v]) {
            $entries[] = [$i, $v];
        }

        self::assertSame([[0, 'x'], [1, 'y']], $entries);
    }

    public function testDocEveryExample(): void
    {
        $arr = new Arr(1, 30, 39, 42);

        self::assertFalse($arr->every(static fn (int $v): bool => $v < 40));
        self::assertTrue($arr->every(static fn (int $v): bool => $v < 50));
    }

    public function testDocFillExample(): void
    {
        $arr = new Arr(1, 2, 3, 4);

        self::assertSame([1, 2, 0, 0], $arr->fill(0, 2, 4)->toArray());
        self::assertSame([1, 5, 5, 5], $arr->fill(5, 1)->toArray());
        self::assertSame([6, 6, 6, 6], $arr->fill(6)->toArray());
    }

    public function testDocFilterExample(): void
    {
        $arr = new Arr(10, 20, 30, 40);

        self::assertSame([30, 40], $arr->filter(static fn (int $v): bool => $v > 25)->toArray());
    }

    public function testDocFindExample(): void
    {
        $arr = new Arr(5, 12, 8, 130, 44);

        self::assertSame(12, $arr->find(static fn (int $v): bool => $v > 10));
    }

    public function testDocFindIndexExample(): void
    {
        $arr = new Arr(5, 12, 8, 130, 44);

        self::assertSame(1, $arr->findIndex(static fn (int $v): bool => $v > 10));
    }

    public function testDocFindLastExample(): void
    {
        $arr = new Arr(5, 12, 8, 130, 44);

        self::assertSame(44, $arr->findLast(static fn (int $v): bool => $v > 10));
    }

    public function testDocFindLastIndexExample(): void
    {
        $arr = new Arr(5, 12, 8, 130, 44);

        self::assertSame(4, $arr->findLastIndex(static fn (int $v): bool => $v > 10));
    }

    public function testDocFlatExample(): void
    {
        $arr = new Arr(new Arr(1, 2), new Arr(3, Arr::of(4)));

        self::assertSame([1, 2, 3, [4]], $arr->flat(1)->toArray());
        self::assertSame([1, 2, 3, 4], $arr->flat(2)->toArray());
    }

    public function testDocFlatMapExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame([1, 2, 2, 4, 3, 6], $arr->flatMap(static fn (int $v): Arr => new Arr($v, $v * 2))->toArray());
    }

    public function testDocForEachExample(): void
    {
        $arr = new Arr('a', 'b', 'c');
        $processed = [];

        $arr->forEach(static function (string $v) use (&$processed): void {
            $processed[] = $v;
        });

        self::assertSame(['a', 'b', 'c'], $processed);
    }

    public function testDocIncludesExample(): void
    {
        $arr = new Arr(1, 2, 3, NAN);

        self::assertTrue($arr->includes(2));
        self::assertFalse($arr->includes(4));
        self::assertTrue($arr->includes(NAN));
    }

    public function testDocIndexOfExample(): void
    {
        $arr = new Arr('a', 'b', 'c', 'b');

        self::assertSame(1, $arr->indexOf('b'));
        self::assertSame(3, $arr->indexOf('b', 2));
        self::assertSame(-1, $arr->indexOf('z'));
    }

    public function testDocJoinExample(): void
    {
        $arr = new Arr('Wind', 'Rain', 'Fire');

        self::assertSame('Wind,Rain,Fire', $arr->join());
        self::assertSame('Wind - Rain - Fire', $arr->join(' - '));
        self::assertSame('Wind, Rain, Fire', $arr->join(', '));

        self::assertSame('0.1,1,Infinity', (new Arr(0.1, 1.0, INF))->join());
    }

    public function testDocKeysExample(): void
    {
        $arr = new Arr('a', 'b', 'c');

        $keys = [];
        foreach ($arr->keys() as $key) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2], $keys);
    }

    public function testDocLastIndexOfExample(): void
    {
        $arr = new Arr('a', 'b', 'c', 'b');

        self::assertSame(3, $arr->lastIndexOf('b'));
        self::assertSame(1, $arr->lastIndexOf('b', 2));
    }

    public function testDocMapExample(): void
    {
        $arr = new Arr(1, 4, 9);

        self::assertSame([2, 8, 18], $arr->map(static fn (int $v): int => $v * 2)->toArray());
        self::assertSame(['1', '4', '9'], $arr->map(static fn (int $v): string => (string) $v)->toArray());
    }

    public function testDocPopExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame(3, $arr->pop());
        self::assertSame([1, 2], $arr->toArray());
        self::assertSame(2, $arr->pop());
        self::assertSame([1], $arr->toArray());
    }

    public function testDocPushExample(): void
    {
        $arr = new Arr('a');

        self::assertSame(2, $arr->push('b'));
        self::assertSame(4, $arr->push('c', 'd'));
        self::assertSame(['a', 'b', 'c', 'd'], $arr->toArray());
    }

    public function testDocReduceExample(): void
    {
        $arr = new Arr(1, 2, 3, 4);

        self::assertSame(10, $arr->reduce(static fn (int $acc, int $v): int => $acc + $v, 0));
        self::assertSame('1-2-3-4', $arr->reduce(static fn (int|string $acc, int $v): string => $acc.'-'.$v));
    }

    public function testDocReduceRightExample(): void
    {
        $arr = new Arr('a', 'b', 'c');

        self::assertSame('cba', $arr->reduceRight(static fn (string $acc, string $v): string => $acc.$v, ''));
    }

    public function testDocReverseExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame([3, 2, 1], $arr->reverse()->toArray());
    }

    public function testDocShiftExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame(1, $arr->shift());
        self::assertSame([2, 3], $arr->toArray());
    }

    public function testDocSliceExample(): void
    {
        $arr = new Arr('a', 'b', 'c', 'd', 'e');

        self::assertSame(['c', 'd', 'e'], $arr->slice(2)->toArray());
        self::assertSame(['c', 'd'], $arr->slice(2, 4)->toArray());
        self::assertSame(['d', 'e'], $arr->slice(-2)->toArray());
    }

    public function testDocSomeExample(): void
    {
        $arr = new Arr(1, 2, 3, 4);

        self::assertTrue($arr->some(static fn (int $v): bool => 0 === $v % 2));
        self::assertFalse($arr->some(static fn (int $v): bool => $v > 10));
    }

    public function testDocSortExample(): void
    {
        $arr = new Arr(3, 30, 1, 100);

        self::assertSame([1, 100, 3, 30], $arr->sort()->toArray());
        self::assertSame([1, 3, 30, 100], $arr->sort(static fn (int $a, int $b): int => $a <=> $b)->toArray());
    }

    public function testDocSpliceExample(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);

        self::assertSame([3, 4, 5], $arr->splice(2)->toArray());
        self::assertSame([1, 2], $arr->toArray());
        self::assertSame([2], $arr->splice(1, 1)->toArray());
        self::assertSame([1], $arr->toArray());
    }

    public function testDocToLocaleStringExample(): void
    {
        $arr = new Arr(1000, 2000);

        self::assertSame('1.000,2.000', $arr->toLocaleString('de-DE'));
        self::assertSame('€1,000.00,€2,000.00', $arr->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'EUR']));
    }

    public function testDocToReversedExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame([3, 2, 1], $arr->toReversed()->toArray());
        self::assertSame([1, 2, 3], $arr->toArray());
    }

    public function testDocToSortedExample(): void
    {
        $arr = new Arr(3, 1, 2);
        $sorted = $arr->toSorted();

        self::assertSame([1, 2, 3], $sorted->toArray());
        self::assertSame([3, 1, 2], $arr->toArray());
    }

    public function testDocToSplicedExample(): void
    {
        $arr = new Arr(1, 2, 3, 4);
        $spliced = $arr->toSpliced(1, 2, 100);

        self::assertSame([1, 100, 4], $spliced->toArray());
        self::assertSame([1, 2, 3, 4], $arr->toArray());
    }

    public function testDocWithExample(): void
    {
        $arr = new Arr(1, 2, 3, 4, 5);
        $result = $arr->with(2, 99);

        self::assertSame([1, 2, 99, 4, 5], $result->toArray());
        self::assertSame([1, 2, 3, 4, 5], $arr->toArray());

        $arr2 = new Arr(1, 2, 3);
        $result2 = $arr2->with(-1, 'x');

        self::assertSame([1, 2, 'x'], $result2->toArray());
    }

    public function testDocToStringExample(): void
    {
        $arr = new Arr(1, 2, 3);

        self::assertSame('1,2,3', $arr->toString());
    }

    public function testDocUnshiftExample(): void
    {
        $arr = new Arr(3, 4);

        self::assertSame(4, $arr->unshift(1, 2));
        self::assertSame([1, 2, 3, 4], $arr->toArray());
    }

    public function testDocValuesExample(): void
    {
        $arr = new Arr('a', 'b', 'c');

        $values = [];
        foreach ($arr->values() as $value) {
            $values[] = $value;
        }

        self::assertSame(['a', 'b', 'c'], $values);
    }

    public function testDocToArrayExample(): void
    {
        $arr = new Arr(1, 'two', null, true);
        $nested = new Arr(new Arr('a', 'b'));

        self::assertSame([1, 'two', null, true], $arr->toArray());
        self::assertSame([['a', 'b']], $nested->toArray());
    }

    public function testDocJsonSerializeExample(): void
    {
        $arr = new Arr(1, 'two', null, true);

        self::assertSame('[1,"two",null,true]', json_encode($arr));
    }

    public function testDocThisArgSupportExample(): void
    {
        $arr = new Arr(1, 2, 3);
        $context = new class {
            public int $multiplier = 10;
        };

        $result = $arr->map(
            fn (int $v): int => $v * $this->multiplier,
            $context,
        );

        self::assertSame([10, 20, 30], $result->toArray());
    }

    public function testDocChainingExample(): void
    {
        $result = (new Arr(5, 2, 8, 1, 9))
            ->filter(static fn (int $v): bool => $v > 3)
            ->sort()
            ->map(static fn (int $v): int => $v ** 2)
        ;

        self::assertSame([25, 64, 81], $result->toArray());
    }

    /**
     * @return list<mixed>
     */
    private static function values(Arr $arr): array
    {
        return iterator_to_array($arr->values());
    }
}
