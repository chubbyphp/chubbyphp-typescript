<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\Map;
use Chubbyphp\Typescript\MapCorruptionError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class MapTest extends TestCase
{
    // constructor

    public function testMapConstructorCreatesEmptyMap(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);
        self::assertSame([], $map->toArray());
        self::assertCount(0, $map);
    }

    public function testMapConstructorWithNullEntriesCreatesEmptyMap(): void
    {
        $map = new Map(null);

        self::assertSame(0, $map->size);
        self::assertSame([], $map->toArray());
    }

    public function testMapConstructorAcceptsArrayOfEntries(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(2, $map->size);
        self::assertSame([['a', 1], ['b', 2]], $map->toArray());
    }

    public function testMapConstructorAcceptsArrOfEntries(): void
    {
        $map = new Map(new Arr(new Arr('a', 1), new Arr('b', 2)));

        self::assertSame(2, $map->size);
        self::assertSame([['a', 1], ['b', 2]], $map->toArray());
    }

    public function testMapConstructorAcceptsGeneratorOfEntries(): void
    {
        $map = new Map((static function (): \Generator {
            yield ['a', 1];

            yield ['b', 2];
        })());

        self::assertSame(2, $map->size);
        self::assertSame([['a', 1], ['b', 2]], $map->toArray());
    }

    public function testMapConstructorWithDuplicateKeysKeepsFirstInsertionOrderAndLastValue(): void
    {
        $map = new Map([['a', 1], ['b', 2], ['a', 3]]);

        self::assertSame(2, $map->size);
        self::assertSame([['a', 3], ['b', 2]], $map->toArray());
    }

    public function testMapConstructorPadsEntryWithSingleValueWithNullValue(): void
    {
        $map = new Map([['a', 1], ['b']]);

        self::assertSame(2, $map->size);
        self::assertTrue($map->has('b'));
        self::assertNull($map->get('b'));
        self::assertSame([['a', 1], ['b', null]], $map->toArray());
    }

    public function testMapConstructorPadsEmptyEntryWithNullKeyAndValue(): void
    {
        $map = new Map([[]]);

        self::assertSame(1, $map->size);
        self::assertTrue($map->has(null));
        self::assertNull($map->get(null));
        self::assertSame([[null, null]], $map->toArray());
    }

    public function testMapConstructorWithEmptyStringCreatesEmptyMap(): void
    {
        $map = new Map('');

        self::assertSame(0, $map->size);
        self::assertSame([], $map->toArray());
    }

    public function testMapConstructorThrowsTypeErrorForStringEntries(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Iterator value is not an entry object');

        new Map('abc');
    }

    public function testMapConstructorThrowsTypeErrorForNonIterableArgument(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('int is not iterable');

        new Map(1);
    }

    public function testMapConstructorThrowsTypeErrorForNonIterableEntry(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Iterator value is not an entry object');

        new Map([['a', 1], 3]);
    }

    public function testMapConstructorStopsReadingEntryAfterTwoValues(): void
    {
        $read = 0;

        $entry = (static function () use (&$read): \Generator {
            ++$read;

            yield 'a';
            ++$read;

            yield 1;
            ++$read;

            yield 'extra';
        })();

        $map = new Map([$entry]);

        self::assertSame(2, $read);
        self::assertSame(1, $map->size);
        self::assertSame(1, $map->get('a'));
    }

    // __isset

    public function testMapIssetSize(): void
    {
        $map = new Map([['a', 1]]);

        self::assertTrue(isset($map->size));
    }

    public function testMapIssetUnknownProperty(): void
    {
        $map = new Map();

        self::assertFalse(isset($map->unknown));
    }

    // __get

    public function testMapGetSize(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(2, $map->size);
    }

    public function testMapSizeIsLive(): void
    {
        $map = new Map();

        self::assertSame(0, $map->size);

        $map->set('a', 1);
        self::assertSame(1, $map->size);

        $map->set('b', 2);
        self::assertSame(2, $map->size);

        $map->delete('a');
        self::assertSame(1, $map->size);

        $map->clear();
        self::assertSame(0, $map->size);
    }

    public function testMapGetUnknownPropertyTriggersWarning(): void
    {
        $map = new Map();

        error_clear_last();

        $unknown = @$map->unknown;

        $lastError = error_get_last();

        self::assertNull($unknown);
        self::assertNotNull($lastError);
        self::assertArrayHasKey('type', $lastError);
        self::assertSame(E_USER_WARNING, $lastError['type']);
        self::assertArrayHasKey('message', $lastError);
        self::assertSame('Undefined property: Map::$unknown', $lastError['message']);
    }

    // __set

    public function testMapSetSizePropertyThrowsTypeError(): void
    {
        $map = new Map([['a', 1]]);

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Cannot set property Map::$size which has only a getter');

        $map->size = 5;
    }

    public function testMapSetSizePropertyDoesNotShadowLiveSize(): void
    {
        $map = new Map([['a', 1]]);

        try {
            $map->size = 5;
        } catch (\TypeError) {
        }

        $map->set('b', 2);

        self::assertSame(2, $map->size);
    }

    public function testMapSetUnknownPropertyTriggersWarningAndStoresNothing(): void
    {
        $map = new Map();

        error_clear_last();

        @$map->unknown = 'value';

        $lastError = error_get_last();

        self::assertNotNull($lastError);
        self::assertArrayHasKey('type', $lastError);
        self::assertSame(E_USER_WARNING, $lastError['type']);
        self::assertArrayHasKey('message', $lastError);
        self::assertSame('Undefined property: Map::$unknown', $lastError['message']);

        self::assertFalse(isset($map->unknown));
        self::assertNull(@$map->unknown);
    }

    // count

    public function testMapCountReturnsSize(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(2, $map->count());
        self::assertCount(2, $map);
    }

    // IteratorAggregate / default iterator

    public function testMapDefaultIteratorYieldsEntries(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $entries = [];
        foreach ($map as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([['a', 1], ['b', 2]], $entries);
    }

    // groupBy

    public function testMapGroupByWithEvenOddCallback(): void
    {
        $numbers = new Arr(1, 2, 3, 4, 5);

        $grouped = Map::groupBy($numbers, static fn (int $n): string => 0 === $n % 2 ? 'even' : 'odd');

        self::assertSame(2, $grouped->size);
        self::assertInstanceOf(Arr::class, $grouped->get('even'));
        self::assertSame([2, 4], $grouped->get('even')->toArray());
        self::assertSame([1, 3, 5], $grouped->get('odd')->toArray());
    }

    public function testMapGroupByWithGenerator(): void
    {
        $items = (static function (): \Generator {
            yield 1;

            yield 2;

            yield 3;
        })();

        $indexes = [];
        $grouped = Map::groupBy($items, static function (int $n, int $i) use (&$indexes): string {
            $indexes[] = $i;

            return 0 === $n % 2 ? 'even' : 'odd';
        });

        self::assertSame([0, 1, 2], $indexes);
        self::assertSame(2, $grouped->size);
        self::assertSame([2], $grouped->get('even')->toArray());
        self::assertSame([1, 3], $grouped->get('odd')->toArray());
    }

    public function testMapGroupByWithEmptyIterable(): void
    {
        $grouped = Map::groupBy(new Arr(), static fn (int $n): string => 0 === $n % 2 ? 'even' : 'odd');

        self::assertSame(0, $grouped->size);
        self::assertSame([], $grouped->toArray());
    }

    public function testMapGroupByCallbackReceivesValueAndIndex(): void
    {
        $seen = [];

        $grouped = Map::groupBy(new Arr('a', 'b', 'c'), static function (string $value, int $index) use (&$seen): string {
            $seen[] = [$value, $index];

            return $value;
        });

        self::assertSame([['a', 0], ['b', 1], ['c', 2]], $seen);
        self::assertSame(3, $grouped->size);
    }

    public function testMapGroupByWithObjectKeys(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();

        $grouped = Map::groupBy(new Arr($a, $b, $a), static fn (\stdClass $value): \stdClass => $value);

        self::assertSame(2, $grouped->size);
        self::assertSame([$a, $a], $grouped->get($a)->toArray());
        self::assertSame([$b], $grouped->get($b)->toArray());
    }

    public function testMapGroupByWithSparseArrTreatsHolesAsNull(): void
    {
        /** @var Arr<null|string> $items */
        $items = new Arr();
        $items[0] = 'a';
        $items[2] = 'c';

        $grouped = Map::groupBy($items, static fn (?string $value, int $index): int => $index);

        self::assertSame(3, $grouped->size);
        self::assertSame(['a'], $grouped->get(0)->toArray());
        self::assertNull($grouped->get(1)[0]);
        self::assertSame(['c'], $grouped->get(2)->toArray());
    }

    public function testMapGroupByCallbackThrowIsPropagated(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('boom');

        Map::groupBy(new Arr(1, 2), static function (): string {
            throw new \RuntimeException('boom');
        });
    }

    public function testMapGroupByGroupsPositiveZeroAndNegativeZeroTogether(): void
    {
        $grouped = Map::groupBy(new Arr(1, 2), static fn (int $value, int $index): float => 0 === $index ? -0.0 : 0.0);

        self::assertSame(1, $grouped->size);
        self::assertSame([1, 2], $grouped->get(0.0)->toArray());
    }

    // clear

    public function testMapClearRemovesAllEntries(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $map->clear();

        self::assertSame(0, $map->size);
        self::assertSame([], $map->toArray());
        self::assertFalse($map->has('a'));
        self::assertNull($map->get('a'));
    }

    public function testMapClearOnEmptyMapIsNoop(): void
    {
        $map = new Map();

        $map->clear();

        self::assertSame(0, $map->size);
    }

    public function testMapClearDuringIterationKeepsIteratorPositionAndSeesNewEntries(): void
    {
        $map = new Map([[1, 'a'], [2, 'b'], [3, 'c']]);

        $seen = [];
        foreach ($map as [$key, $value]) {
            $seen[] = $key;

            if (1 === $key) {
                $map->clear();
                $map->set(9, 'z');
            }
        }

        self::assertSame([1, 9], $seen);
        self::assertSame(1, $map->size);
        self::assertSame([[9, 'z']], $map->toArray());
    }

    public function testMapClearDuringForEachKeepsPositionAndSeesNewEntries(): void
    {
        $map = new Map([[1, 'a'], [2, 'b']]);

        $seen = [];
        $map->forEach(static function (string $value, int $key) use (&$seen, $map): void {
            $seen[] = $key;

            if (1 === $key) {
                $map->clear();
                $map->set(8, 'y');
            }
        });

        self::assertSame([1, 8], $seen);
    }

    // delete

    public function testMapDeleteExistingReturnsTrueAndRemovesEntry(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertTrue($map->delete('a'));
        self::assertSame(1, $map->size);
        self::assertSame([['b', 2]], $map->toArray());
        self::assertFalse($map->has('a'));
    }

    public function testMapDeleteNonExistingReturnsFalse(): void
    {
        $map = new Map([['a', 1]]);

        self::assertFalse($map->delete('b'));
        self::assertSame(1, $map->size);
    }

    public function testMapDeleteThenSetAppendsNewEntry(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $map->delete('a');
        $map->set('a', 3);

        self::assertSame(2, $map->size);
        self::assertSame([['b', 2], ['a', 3]], $map->toArray());
    }

    // entries

    public function testMapEntriesIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $entries = [];
        foreach ($map->entries() as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([['a', 1], ['b', 2]], $entries);
    }

    // forEach

    public function testMapForEachReceivesValueKeyAndMap(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $seen = [];
        $map->forEach(static function (int $value, string $key, Map $m) use (&$seen, $map): void {
            self::assertSame($map, $m);
            $seen[] = [$key, $value];
        });

        self::assertSame([['a', 1], ['b', 2]], $seen);
    }

    public function testMapForEachBindsThisArgForNonStaticClosure(): void
    {
        $map = new Map([['a', 1]]);
        $context = new \stdClass();
        $context->touched = false;

        $map->forEach(function (): void {
            // @phpstan-ignore-next-line
            $this->touched = true;
        }, $context);

        self::assertTrue($context->touched);
    }

    public function testMapForEachDoesNotBindThisArgForStaticClosure(): void
    {
        $map = new Map([['a', 1]]);
        $context = new \stdClass();

        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Using $this when not in object context');

        $map->forEach(static function (): void {
            // @phpstan-ignore-next-line
            $this->touched = true;
        }, $context);
    }

    public function testMapForEachDoesNotBindThisArgForArrayCallable(): void
    {
        $map = new Map([['a', 1]]);
        $context = new \stdClass();
        $context->touched = false;

        $handler = new class {
            public bool $called = false;

            public function handle(): void
            {
                $this->called = true;
            }
        };

        $map->forEach([$handler, 'handle'], $context);

        self::assertTrue($handler->called);
    }

    public function testMapForEachWithNullValues(): void
    {
        $map = new Map([['a', null], ['b', null]]);

        $seen = [];
        $map->forEach(static function (?string $value, string $key) use (&$seen): void {
            $seen[] = [$key, $value];
        });

        self::assertSame([['a', null], ['b', null]], $seen);
    }

    // get

    public function testMapGetReturnsValueForExistingKey(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(1, $map->get('a'));
        self::assertSame(2, $map->get('b'));
    }

    public function testMapGetReturnsNullForMissingKey(): void
    {
        $map = new Map([['a', 1]]);

        self::assertNull($map->get('b'));
    }

    public function testMapGetDistinguishesNullValueFromMissingKey(): void
    {
        $map = new Map([['a', null]]);

        self::assertNull($map->get('a'));
        self::assertNull($map->get('b'));
    }

    // getOrInsert

    public function testMapGetOrInsertReturnsExistingValue(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(1, $map->getOrInsert('a', 99));
        self::assertSame(2, $map->getOrInsert('b', 99));
        self::assertSame(2, $map->size);
    }

    public function testMapGetOrInsertInsertsDefaultValueWhenKeyMissing(): void
    {
        $map = new Map([['a', 1]]);

        self::assertSame(99, $map->getOrInsert('b', 99));
        self::assertSame(1, $map->get('a'));
        self::assertSame(99, $map->get('b'));
        self::assertSame(2, $map->size);
    }

    public function testMapGetOrInsertWithNullValueDoesNotReplaceExisting(): void
    {
        $map = new Map([['a', null]]);

        self::assertNull($map->getOrInsert('a', 'default'));
        self::assertSame(1, $map->size);
    }

    // getOrInsertComputed

    public function testMapGetOrInsertComputedReturnsExistingValue(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $called = false;
        $value = $map->getOrInsertComputed('a', static function () use (&$called): int {
            $called = true;

            return 99;
        });

        self::assertSame(1, $value);
        self::assertFalse($called);
    }

    public function testMapGetOrInsertComputedInsertsCallbackResultWhenKeyMissing(): void
    {
        $map = new Map([['a', 1]]);

        $value = $map->getOrInsertComputed('b', static fn (string $key): string => 'default for '.$key);

        self::assertSame('default for b', $value);
        self::assertSame('default for b', $map->get('b'));
        self::assertSame(2, $map->size);
    }

    public function testMapGetOrInsertComputedCallbackReceivesKey(): void
    {
        $map = new Map();

        $received = null;
        $map->getOrInsertComputed('target', static function (string $key) use (&$received): string {
            $received = $key;

            return 'value';
        });

        self::assertSame('target', $received);
    }

    public function testMapGetOrInsertComputedPassesCanonicalizedKeyToCallback(): void
    {
        $map = new Map();

        $received = null;
        $map->getOrInsertComputed(-0.0, static function (float $key) use (&$received): string {
            $received = $key;

            return 'value';
        });

        self::assertSame('0', (string) $received);
        self::assertSame('value', $map->get(0.0));
    }

    public function testMapGetOrInsertComputedOverwritesMutationFromCallback(): void
    {
        $map = new Map();

        $value = $map->getOrInsertComputed('a', static function () use ($map): int {
            $map->set('a', 0);

            return 3;
        });

        self::assertSame(3, $value);
        self::assertSame(3, $map->get('a'));
        self::assertSame(1, $map->size);
    }

    public function testMapGetOrInsertComputedDoesNotCallCallbackWhenKeyExists(): void
    {
        $map = new Map([['a', 'existing']]);

        $calls = 0;
        $value = $map->getOrInsertComputed('a', static function () use (&$calls): string {
            ++$calls;

            return 'new';
        });

        self::assertSame('existing', $value);
        self::assertSame(0, $calls);
    }

    // has

    public function testMapHasReturnsTrueForExistingKey(): void
    {
        $map = new Map([['a', 1]]);

        self::assertTrue($map->has('a'));
    }

    public function testMapHasReturnsFalseForMissingKey(): void
    {
        $map = new Map([['a', 1]]);

        self::assertFalse($map->has('b'));
    }

    // sameValueZero edge cases

    public function testMapTreatsNaNAsEqualToNaN(): void
    {
        $map = new Map();
        $map->set(NAN, 'found');

        self::assertTrue($map->has(NAN));
        self::assertSame('found', $map->get(NAN));
    }

    public function testMapTreatsNegativeZeroAsEqualToPositiveZero(): void
    {
        $map = new Map();
        $map->set(-0.0, 'negative zero');

        self::assertTrue($map->has(0));
        self::assertTrue($map->has(0.0));
        self::assertSame('negative zero', $map->get(0));
    }

    public function testMapNormalizesNegativeZeroKeyToPositiveZero(): void
    {
        $map = new Map();
        $map->set(-0.0, 'zero');

        self::assertSame([0.0], iterator_to_array($map->keys()));
    }

    public function testMapTreatsIntAndFloatEquivalentlyForNumericKeys(): void
    {
        $map = new Map();
        $map->set(1, 'int');

        self::assertTrue($map->has(1.0));
        self::assertSame('int', $map->get(1.0));
    }

    public function testMapUsesIdentityForObjectKeys(): void
    {
        $key = new \stdClass();
        $otherKey = new \stdClass();

        $map = new Map();
        $map->set($key, 'value');

        self::assertTrue($map->has($key));
        self::assertFalse($map->has($otherKey));
        self::assertSame('value', $map->get($key));
        self::assertNull($map->get($otherKey));
    }

    public function testMapDistinguishesStringAndNumericKeys(): void
    {
        $map = new Map();
        $map->set('1', 'string');
        $map->set(1, 'number');

        self::assertSame(2, $map->size);
        self::assertSame('string', $map->get('1'));
        self::assertSame('number', $map->get(1));
    }

    public function testMapNaNDoesNotMatchNonNaNKey(): void
    {
        $map = new Map();
        $map->set(1.0, 'number');

        self::assertFalse($map->has(NAN));
        self::assertNull($map->get(NAN));
    }

    public function testMapStrictlyEqualRejectsNumericAndStringLookalikes(): void
    {
        $map = new Map();
        $map->set(1, 'number');

        self::assertFalse($map->has('1'));
    }

    public function testMapStrictlyEqualAcceptsIntAndFloatLookalikes(): void
    {
        $map = new Map();
        $map->set(1, 'number');

        self::assertTrue($map->has(1.0));
        self::assertSame('number', $map->get(1.0));
    }

    // keys

    public function testMapKeysIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(['a', 'b'], iterator_to_array($map->keys()));
    }

    // set

    public function testMapSetAddsNewEntry(): void
    {
        $map = new Map();

        self::assertSame($map, $map->set('a', 1));
        self::assertSame([['a', 1]], $map->toArray());
    }

    public function testMapSetChains(): void
    {
        $map = new Map();

        $map->set('a', 1)->set('b', 2)->set('c', 3);

        self::assertSame([['a', 1], ['b', 2], ['c', 3]], $map->toArray());
    }

    public function testMapSetUpdatesExistingKeyWithoutChangingOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $map->set('a', 3);

        self::assertSame([['a', 3], ['b', 2]], $map->toArray());
    }

    // values

    public function testMapValuesIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame([1, 2], iterator_to_array($map->values()));
    }

    // toArray

    public function testMapToArrayReturnsCopy(): void
    {
        $map = new Map([['a', 1]]);

        $copy = $map->toArray();
        $copy[0][1] = 99;

        self::assertSame(1, $map->get('a'));
    }

    // defensive internal state

    public function testMapEntryAtThrowsForUnexpectedlyDeletedEntry(): void
    {
        $map = new Map([['a', 1]]);

        $entriesProperty = new \ReflectionProperty($map, 'entries');

        /** @var list<null|array{0: string, 1: int}> $entries */
        $entries = $entriesProperty->getValue($map);
        $entries[0] = null;
        $entriesProperty->setValue($map, $entries);

        $method = new \ReflectionMethod($map, 'entryAt');

        $this->expectException(MapCorruptionError::class);
        $this->expectExceptionMessage('Map entry unexpectedly deleted');

        $method->invoke($map, 0);
    }
}
