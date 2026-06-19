<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\Map;
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

    public function testMapConstructorThrowsTypeErrorForEntryWithLessThanTwoValues(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Iterator value is not an entry object');

        new Map([['a', 1], ['b']]);
    }

    public function testMapConstructorThrowsTypeErrorForStringEntries(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Iterator value is not an entry object');

        new Map('abc');
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

    // count

    public function testMapCountReturnsSize(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(2, $map->count());
        self::assertCount(2, $map);
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

    // entries / keys / values

    public function testMapEntriesIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $entries = [];
        foreach ($map->entries() as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([['a', 1], ['b', 2]], $entries);
    }

    public function testMapKeysIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame(['a', 'b'], iterator_to_array($map->keys()));
    }

    public function testMapValuesIterateInInsertionOrder(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        self::assertSame([1, 2], iterator_to_array($map->values()));
    }

    public function testMapDefaultIteratorYieldsEntries(): void
    {
        $map = new Map([['a', 1], ['b', 2]]);

        $entries = [];
        foreach ($map as $entry) {
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

    // toArray

    public function testMapToArrayReturnsCopy(): void
    {
        $map = new Map([['a', 1]]);

        $copy = $map->toArray();
        $copy[0][1] = 99;

        self::assertSame(1, $map->get('a'));
    }
}
