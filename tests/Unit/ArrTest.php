<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Tests\Typescript\Stub\Dummy;
use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\NumberFormatError;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * https://github.com/tc39/test262.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class ArrTest extends TestCase
{
    // Array constructor

    public function testArrayConstructorSetsLengthFromArgumentCount(): void
    {
        self::assertCount(0, iterator_to_array((new Arr())->values()));
        self::assertCount(4, iterator_to_array((new Arr(0, 1, 0, 1))->values()));
        self::assertCount(2, iterator_to_array((new Arr(null, null))->values()));
    }

    public function testArrayConstructorWithSingleNumericArgumentCreatesHoles(): void
    {
        $array = new Arr(2);

        self::assertCount(2, iterator_to_array($array->values()));
        self::assertNull($array->at(0));
        self::assertNull($array->at(1));
        self::assertFalse(isset($array[0]));
        self::assertFalse(isset($array[1]));
        self::assertFalse(isset($array[-1]));
    }

    public function testArrayConstructorWithManyArgumentsSetsItemsInOrder(): void
    {
        $array = new Arr(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
        );

        self::assertSame(
            [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            iterator_to_array($array->values()),
        );
    }

    public function testArrayConstructorWithSingleNonNumericArgumentCreatesSingleElementArray(): void
    {
        self::assertSame(['hello'], iterator_to_array((new Arr('hello'))->values()));
    }

    public function testArrayConstructorWithZeroFloatCreatesEmptyArray(): void
    {
        $array = new Arr(0.0);
        self::assertSame(0, $array->length);
        self::assertSame([], iterator_to_array($array->values()));
    }

    public function testArrayConstructorWithNegativeZeroFloatCreatesEmptyArray(): void
    {
        $array = new Arr(-0.0);
        self::assertSame(0, $array->length);
        self::assertSame([], iterator_to_array($array->values()));
    }

    public function testArrayConstructorThrowsRangeErrorForNonZeroFloatLength(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(1.5);
    }

    public function testArrayConstructorThrowsRangeErrorForNegativeLength(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(-1);
    }

    public function testArrayConstructorThrowsRangeErrorForLengthAboveUint32Range(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(2 ** 32);
    }

    public function testArrayConstructorAcceptsMaxUint32Length(): void
    {
        $array = new Arr((2 ** 32) - 1);

        self::assertSame((2 ** 32) - 1, $array->length);
        self::assertNull($array->at(0));
    }

    public function testArrayConstructorThrowsRangeErrorForNanAndInfinityLengths(): void
    {
        foreach ([NAN, INF, -INF, PHP_FLOAT_MAX, PHP_FLOAT_MIN] as $length) {
            try {
                new Arr($length);
                self::fail('Expected RangeError for invalid length');
            } catch (RangeError $exception) {
                self::assertSame('Invalid array length', $exception->getMessage());
            }
        }
    }

    public function testArrayConstructorWithSingleNullAndBooleanArgumentsCreatesSingleElementArray(): void
    {
        self::assertSame([null], iterator_to_array((new Arr(null))->values()));
        self::assertSame([true], iterator_to_array((new Arr(true))->values()));

        $booleanObject = new \stdClass();
        $booleanObject->value = false;
        self::assertSame([$booleanObject], iterator_to_array((new Arr($booleanObject))->values()));
    }

    // __isset

    public function testArrayIssetLength(): void
    {
        $array = new Arr(10);

        self::assertTrue(isset($array->length));
    }

    public function testArrayIssetUnknownProperty(): void
    {
        $array = new Arr(10);

        self::assertFalse(isset($array->unknown));
    }

    // __get

    public function testArrayGetLength(): void
    {
        $array = new Arr(10);

        self::assertSame(10, $array->length);
    }

    public function testLengthReturnsElementCount(): void
    {
        self::assertSame(0, (new Arr())->length);
        self::assertSame(3, (new Arr(1, 2, 3))->length);
        self::assertSame(5, (new Arr(5))->length);
        self::assertSame(4, (new Arr('a', 'b', 'c', 'd'))->length);
    }

    public function testLengthIsLive(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(3, $array->length);

        $array->push(4);
        self::assertSame(4, $array->length);

        $array->pop();
        self::assertSame(3, $array->length);

        $array->shift();
        self::assertSame(2, $array->length);
    }

    public function testLengthWithParse(): void
    {
        $array = new Arr();
        $array[3] = 3;

        self::assertSame(4, $array->length);

        self::assertSame(3, $array->pop());

        self::assertSame(3, $array->length);
    }

    public function testArrayGetUnknownProperty(): void
    {
        $array = new Arr(10);

        error_clear_last();

        $unknown = @$array->unknown;

        $lastError = error_get_last();

        self::assertNull($unknown);

        self::assertNotNull($lastError);
        self::assertArrayHasKey('type', $lastError);
        self::assertSame(E_USER_WARNING, $lastError['type']);
        self::assertArrayHasKey('message', $lastError);
        self::assertSame('Undefined property: A::$unknown', $lastError['message']);
    }

    // __set

    public function testArraySetLengthTruncatesArray(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);
        $array->length = 2;

        self::assertSame(2, $array->length);
        self::assertSame([1, 2], $array->toArray());
    }

    public function testArraySetLengthExtendsWithHoles(): void
    {
        $array = new Arr(1, 2);
        $array->length = 5;

        self::assertSame(5, $array->length);
        self::assertSame([1, 2, null, null, null], $array->toArray());
    }

    public function testArraySetLengthToZeroEmptiesArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->length = 0;

        self::assertSame(0, $array->length);
        self::assertSame([], $array->toArray());
    }

    public function testArraySetLengthToSameValueIsNoop(): void
    {
        $array = new Arr(1, 2, 3);
        $array->length = 3;

        self::assertSame(3, $array->length);
        self::assertSame([1, 2, 3], $array->toArray());
    }

    public function testArraySetLengthThrowsRangeErrorForNegative(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        $array = new Arr(1, 2, 3);
        $array->length = -1;
    }

    public function testArraySetLengthThrowsRangeErrorForFloat(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        $array = new Arr(1, 2, 3);
        $array->length = 1.5;
    }

    public function testArraySetLengthThrowsRangeErrorForTooLarge(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        $array = new Arr(1, 2, 3);
        $array->length = 2 ** 32;
    }

    public function testArraySetUnknownPropertyTriggersWarning(): void
    {
        $array = new Arr(1, 2, 3);

        error_clear_last();

        @$array->unknown = 'x';

        $lastError = error_get_last();

        self::assertNotNull($lastError);
        self::assertArrayHasKey('type', $lastError);
        self::assertSame(E_USER_WARNING, $lastError['type']);
        self::assertArrayHasKey('message', $lastError);
        self::assertSame('Undefined property: A::$unknown', $lastError['message']);
    }

    // __toString

    public function testMagicToStringDelegatesToJoin(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame('1,2,3', $array->__toString());
    }

    // ArrayAccess

    public function testArrayAccessSupportsSparseIndexedAssignmentAndDeletion(): void
    {
        $array = new Arr();

        $array[0] = 'first';
        $array[2] = 'x';

        self::assertSame(3, $array->length);
        self::assertSame('first', $array[0]);
        self::assertNull($array[1]);
        self::assertSame('x', $array[2]);
        self::assertFalse(isset($array[1]));
        self::assertTrue(isset($array[2]));
        self::assertSame([0, 1, 2], iterator_to_array($array->keys()));
        self::assertSame(['first', null, 'x'], iterator_to_array($array->values()));
        self::assertSame([[0, 'first'], [1, null], [2, 'x']], iterator_to_array($array->entries()));

        unset($array[2]);

        self::assertSame(3, $array->length);
        self::assertFalse(isset($array[2]));
    }

    public function testSparseArrayMethodsPreserveOrSkipHolesLikeJavascript(): void
    {
        $array = new Arr(3);
        $array[1] = 'x';

        $mapped = $array->map(static fn (string $value): string => strtoupper($value));
        self::assertSame(3, $mapped->length);
        self::assertFalse(isset($mapped[0]));
        self::assertSame('X', $mapped[1]);
        self::assertFalse(isset($mapped[2]));

        $slice = $array->slice(0, 2);
        self::assertSame(2, $slice->length);
        self::assertFalse(isset($slice[0]));
        self::assertSame('x', $slice[1]);

        self::assertSame(-1, $array->indexOf(null));
        self::assertSame(-1, $array->lastIndexOf(null));
        self::assertSame('x', $array->reduce(static fn (string $carry, string $value): string => $carry.$value));
        self::assertSame('x', $array->reduceRight(static fn (string $carry, string $value): string => $carry.$value));

        $reversed = $array->toReversed();
        self::assertSame(3, $reversed->length);
        self::assertFalse(isset($reversed[0]));
        self::assertSame('x', $reversed[1]);
        self::assertFalse(isset($reversed[2]));
    }

    public function testArrayAccessSupportsAppendAndIgnoresInvalidOffsets(): void
    {
        $array = new Arr();

        $array[] = 'a';
        $array[-1] = 'negative';
        $array['key'] = 'string';

        self::assertSame(1, $array->length);
        self::assertSame('a', $array[0]);
        self::assertSame('negative', $array[-1]);
        self::assertTrue(isset($array[-1]));
        self::assertSame('string', $array['key']);
        self::assertTrue(isset($array['key']));

        unset($array['key'], $array[-1]);

        self::assertNull($array['key']);
        self::assertFalse(isset($array['key']));
        self::assertNull($array[-1]);
        self::assertFalse(isset($array[-1]));
        self::assertSame(['a'], iterator_to_array($array->values()));
    }

    public function testArrayAccessCoercesStringNumericKeysToInteger(): void
    {
        $array = new Arr('a');

        self::assertSame('a', $array['0']);

        unset($array['0']);

        self::assertSame([null], iterator_to_array($array->values()));
        self::assertFalse(isset($array[0]));
    }

    public function testArrayAccessLeadingZerosAreNotCoercedToInt(): void
    {
        $array = new Arr('a', 'b', 'c');

        $array['01'] = 'property';

        self::assertSame('property', $array['01']);
        self::assertSame('a', $array['0']);
        self::assertSame('b', $array[1]);
        self::assertSame('a', $array[0]);
        self::assertSame(3, $array->length);
    }

    public function testArrayAccessNegativeNumericStringIsProperty(): void
    {
        $array = new Arr('a');
        $array['-1'] = 'negative-1';
        $array[-2] = 'negative-2';

        self::assertSame('negative-1', $array['-1']);
        self::assertSame('negative-2', $array[-2]);
        self::assertSame(1, $array->length);
        self::assertSame('a', $array[0]);
        self::assertTrue(isset($array['-1']));
        self::assertTrue(isset($array[-2]));
    }

    public function testArrayAccessStringNumericKeyAffectsLength(): void
    {
        $array = new Arr('a');
        $array['2'] = 'x';

        self::assertSame(3, $array->length);
        self::assertSame('x', $array[2]);
        self::assertNull($array[1]);
        self::assertTrue(isset($array[2]));
    }

    public function testArrayAccessStringPropertiesDoNotAffectLengthOrIteration(): void
    {
        $array = new Arr('a', 'b');

        $array['foo'] = 'bar';
        $array['baz'] = 42;

        self::assertSame(2, $array->length);
        self::assertSame('bar', $array['foo']);
        self::assertSame(42, $array['baz']);
        self::assertTrue(isset($array['foo']));
        self::assertSame(['a', 'b'], iterator_to_array($array->values()));

        unset($array['foo']);

        self::assertNull($array['foo']);
        self::assertFalse(isset($array['foo']));
        self::assertSame(['a', 'b'], iterator_to_array($array->values()));
    }

    public function testArrayAccessCoercesIntegerEquivalentFloatToInt(): void
    {
        $array = new Arr('a', 'b');

        self::assertSame('a', $array[0.0]);
        self::assertSame('b', $array[1.0]);

        $array[1.0] = 'x';
        self::assertSame('x', $array[1]);
        self::assertTrue(isset($array[1.0]));
        self::assertSame(2, $array->length);

        unset($array[0.0]);
        self::assertFalse(isset($array[0]));
    }

    public function testArrayAccessNonIntegerFloatIgnored(): void
    {
        $array = new Arr('a');

        self::assertNull($array->offsetGet(true));
        self::assertNull($array->offsetGet(1.5));
        self::assertFalse($array->offsetExists(true));
        self::assertFalse($array->offsetExists(1.5));

        $array->offsetSet(true, 'x');
        $array->offsetSet(1.5, 'y');
        self::assertSame(1, $array->length);
        self::assertSame('a', $array[0]);
    }

    public function testArrayAccessAppendDoesNotAlsoSetNullOffset(): void
    {
        $array = new Arr();

        $array[] = 'a';
        $array[] = 'b';

        self::assertSame(2, $array->length);
        self::assertSame(['a', 'b'], iterator_to_array($array->values()));
    }

    public function testArrayAccessCoercesLargeStringIntKeyToInt(): void
    {
        $array = new Arr();
        $array['100000000000000'] = 'x';

        self::assertSame('x', $array[100000000000000]);
        self::assertTrue(isset($array[100000000000000]));
        self::assertSame(100000000000001, $array->length);

        unset($array[100000000000000]);
        self::assertFalse(isset($array[100000000000000]));
    }
    // Countable::count

    public function testCountReturnsZeroForEmptyArray(): void
    {
        self::assertCount(0, new Arr());
    }

    public function testCountReturnsLengthForPopulatedArray(): void
    {
        self::assertCount(3, new Arr(1, 2, 3));
    }

    public function testCountReturnsLengthForSparseArray(): void
    {
        self::assertCount(5, new Arr(5));
    }

    public function testCountMatchesAfterPushPopShift(): void
    {
        $array = new Arr(1, 2, 3);

        $array->push(4);
        self::assertSame($array->length, \count($array));

        $array->pop();
        self::assertSame($array->length, \count($array));

        $array->shift();
        self::assertSame($array->length, \count($array));
    }

    // IteratorAggregate / foreach

    public function testGetIteratorYieldsAllValuesInOrder(): void
    {
        $result = [];
        foreach (new Arr(1, 2, 3) as $value) {
            $result[] = $value;
        }

        self::assertSame([1, 2, 3], $result);
    }

    public function testIteratorToArrayReturnsAllValues(): void
    {
        self::assertSame([1, 2, 3], iterator_to_array(new Arr(1, 2, 3)));
    }

    public function testGetIteratorWithSparseArrayYieldsNullForHoles(): void
    {
        $array = new Arr(3);
        $array[1] = 'x';

        self::assertSame([null, 'x', null], iterator_to_array($array));
    }

    // jsonSerialize

    public function testJsonSerializeReturnsInternalDataAsArray(): void
    {
        $array = new Arr(1, 'two', null, true);

        self::assertSame([1, 'two', null, true], $array->jsonSerialize());
    }

    public function testJsonSerializeReturnsListForSparseArray(): void
    {
        $array = new Arr();
        $array[2] = 'x';

        self::assertSame([null, null, 'x'], $array->jsonSerialize());
    }

    public function testJsonSerializeReturnsListForSparseArrayByUnset(): void
    {
        $array = new Arr(1, 2, 3);
        unset($array[1]);

        self::assertSame([1, null, 3], $array->jsonSerialize());
    }

    public function testJsonSerializeReturnsListForSparseArrayByOnlyProvidingItsLength(): void
    {
        $array = new Arr(5);

        self::assertSame([null, null, null, null, null], $array->jsonSerialize());
    }

    public function testJsonSerializeRecursivelySerializesNestedArr(): void
    {
        $nested = new Arr('a', 'b');
        $array = new Arr(1, $nested, true);

        self::assertSame([1, ['a', 'b'], true], $array->jsonSerialize());
    }

    // Array.from

    public function testArrayFromCreatesArrayFromIterable(): void
    {
        self::assertSame(['a', 'b', 'c'], iterator_to_array(Arr::from(new \ArrayIterator(['a', 'b', 'c']))->values()));
    }

    public function testArrayFromCreatesDenseArrayFromSparseArr(): void
    {
        $source = new Arr(3);
        $source[1] = 'x';

        $result = Arr::from($source);

        self::assertSame([null, 'x', null], iterator_to_array($result->values()));
        self::assertTrue(isset($result[0]));
        self::assertTrue(isset($result[2]));
    }

    public function testArrayFromCreatesArrayFromString(): void
    {
        self::assertSame(['a', 'b', 'c'], iterator_to_array(Arr::from('abc')->values()));
    }

    public function testArrayFromFallsBackToByteSplittingForInvalidUtf8String(): void
    {
        self::assertSame(["\xFF", "\xFE"], iterator_to_array(Arr::from("\xFF\xFE")->values()));
    }

    public function testArrayFromMapsValues(): void
    {
        self::assertSame([1, 3, 5], iterator_to_array(Arr::from([1, 2, 3], static fn (int $value, int $index): int => $value + $index)->values()));
    }

    public function testArrayFromBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();
        $dummy->multiplier = 3;

        self::assertSame([3, 6, 9], iterator_to_array(Arr::from([1, 2, 3], $dummy->multiplierCallback(), $dummy)->values()));
    }

    public function testArrayFromMapCallbackReceivesTwoArguments(): void
    {
        $called = false;

        Arr::from([0], static function (...$args) use (&$called): bool {
            $called = true;

            return 2 === \func_num_args();
        });

        self::assertTrue($called);
    }

    public function testArrayFromThrowsTypeErrorForUnsupportedInput(): void
    {
        $this->expectException(\TypeError::class);

        Arr::from(new \stdClass());
    }

    // Array.of

    public function testArrayOfCreatesArrayFromArguments(): void
    {
        self::assertSame([3], iterator_to_array(Arr::of(3)->values()));
        self::assertSame([1, 2, 3], iterator_to_array(Arr::of(1, 2, 3)->values()));
    }

    // Array.prototype.at

    public function testAtReturnsItemValueAtSpecifiedIndex(): void
    {
        $array = new Arr(1, 2, 3, 4, null, 5);

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
        self::assertSame(4, $array->at(3));
        self::assertNull($array->at(4));
        self::assertSame(5, $array->at(5));
    }

    public function testAtReturnsItemValueAtSpecifiedRelativeIndex(): void
    {
        $array = new Arr(1, 2, 3, 4, null, 5);

        self::assertSame(1, $array->at(0));
        self::assertSame(5, $array->at(-1));
        self::assertNull($array->at(-2));
        self::assertSame(4, $array->at(-3));
        self::assertSame(3, $array->at(-4));
    }

    public function testAtReturnsUndefinedForOutOfRangeIndex(): void
    {
        $array = new Arr();

        self::assertNull($array->at(-2));
        self::assertNull($array->at(0));
        self::assertNull($array->at(1));
    }

    public function testAtReturnsNullForHolePositions(): void
    {
        $array = new Arr(3);

        self::assertNull($array->at(0));
        self::assertNull($array->at(1));
        self::assertNull($array->at(2));
        self::assertNull($array->at(-1));
    }

    // Array.prototype.concat

    public function testConcatWithArrayArgumentsAppendsArrayElementsInOrder(): void
    {
        $result = (new Arr())->concat(new Arr(0, 1), new Arr(2, 3, 4));

        self::assertSame([0, 1, 2, 3, 4], iterator_to_array($result->values()));
    }

    public function testConcatWithPrimitiveArgumentsAppendsPrimitiveValues(): void
    {
        $result = (new Arr('x'))->concat(new Arr(1, 2), -1, true, 'NaN');

        self::assertSame(['x', 1, 2, -1, true, 'NaN'], iterator_to_array($result->values()));
    }

    public function testConcatWithNoArgumentsReturnsCopy(): void
    {
        $array = new Arr(0, 1);
        $result = $array->concat();

        self::assertNotSame($array, $result);
        self::assertSame([0, 1], iterator_to_array($result->values()));
    }

    public function testConcatDoesNotModifyOriginalArray(): void
    {
        $array = new Arr(1, 2);

        $array->concat(new Arr(3, 4));

        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    // Array.prototype.copyWithin

    public function testCopyWithinWithNonNegativeTargetStartAndEnd(): void
    {
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 0, 0)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 0, 2)->values()));
        self::assertSame([1, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, 2)->values()));
        self::assertSame([0, 0, 1, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(1, 0, 2)->values()));
        self::assertSame([0, 3, 4, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 3, 5)->values()));
    }

    public function testCopyWithinWithNegativeTarget(): void
    {
        self::assertSame([0, 1, 2, 0], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(-1, 0)->values()));
        self::assertSame([0, 1, 2, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3, 4))->copyWithin(-2, 2)->values()));
        self::assertSame([0, 1, 2, 2], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(-1, 2)->values()));
    }

    public function testCopyWithinReturnsThisObject(): void
    {
        $array = new Arr(0, 1, 2, 3);

        self::assertSame($array, $array->copyWithin(1, 0, 2));
    }

    public function testCopyWithinUsesArrayLengthWhenEndIsUndefined(): void
    {
        self::assertSame([1, 2, 3, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1)->values()));
        self::assertSame([1, 2, 3, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, null)->values()));
    }

    public function testCopyWithinClampsOutOfBoundsNegativeStart(): void
    {
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, -10)->values()));
        self::assertSame([0, 1, 0, 1, 2], iterator_to_array((new Arr(0, 1, 2, 3, 4))->copyWithin(2, -10)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(-9, -10)->values()));
    }

    public function testCopyWithinClampsOutOfBoundsNegativeTarget(): void
    {
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(-10, 0)->values()));
        self::assertSame([2, 3, 4, 3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->copyWithin(-10, 2)->values()));
    }

    public function testCopyWithinClampsNonNegativeTargetAndStartToLength(): void
    {
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->copyWithin(6, 0)->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->copyWithin(0, 6)->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->copyWithin(10, 10)->values()));
    }

    public function testCopyWithinSupportsNegativeEnd(): void
    {
        self::assertSame([1, 2, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, -1)->values()));
        self::assertSame([0, 1, 0, 1, 2], iterator_to_array((new Arr(0, 1, 2, 3, 4))->copyWithin(2, 0, -1)->values()));
        self::assertSame([0, 2, 2, 3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->copyWithin(1, 2, -2)->values()));
        self::assertSame([2, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, -2, -1)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, -10)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, 0)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(1, 0, -10)->values()));
    }

    public function testCopyWithinClampsEndBeyondLength(): void
    {
        self::assertSame([1, 2, 3, 3], iterator_to_array((new Arr(0, 1, 2, 3))->copyWithin(0, 1, 6)->values()));
        self::assertSame([0, 3, 4, 5, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->copyWithin(1, 3, 6)->values()));
    }

    public function testCopyWithinDeletesTargetWhenSourceIsHole(): void
    {
        $array = new Arr('a', 'b', 'c');
        unset($array[0]);

        $array->copyWithin(1, 0, 1);

        self::assertSame([null, null, 'c'], iterator_to_array($array->values()));
        self::assertFalse(isset($array[1]));
    }

    public function testCopyWithinDoesNotWriteBeyondLength(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $array->copyWithin(2, 0);

        self::assertSame([1, 2, 1, 2], iterator_to_array($array->values()));
        self::assertFalse(isset($array[4]));
    }

    public function testCopyWithinStartsCopyingAtZero(): void
    {
        $array = new Arr('a', 'b', 'c');

        $array->copyWithin(1, 0, 1);

        self::assertSame(['a', 'a', 'c'], iterator_to_array($array->values()));
    }

    // Array.prototype.entries

    public function testEntriesReturnsKeyValuePairs(): void
    {
        self::assertSame(
            [0 => [0, 'a'], 1 => [1, 'b'], 2 => [2, 'c']],
            iterator_to_array((new Arr('a', 'b', 'c'))->entries()),
        );
    }

    public function testEntriesIteratorSeesItemsAddedBeforeConsumption(): void
    {
        $array = new Arr();
        $iterator = $array->entries();
        $array->push('a');

        self::assertSame([0 => [0, 'a']], iterator_to_array($iterator));
    }

    public function testEntriesWithSparseArrayYieldsKeyValuePairsForAllIndices(): void
    {
        $array = new Arr(3);
        $array->offsetSet(1, 'x');

        self::assertSame(
            [0 => [0, null], 1 => [1, 'x'], 2 => [2, null]],
            iterator_to_array($array->entries()),
        );
    }

    // Array.prototype.every

    public function testEveryReturnsTrueForEmptyArray(): void
    {
        self::assertTrue((new Arr())->every(static fn (): bool => false));
    }

    public function testEveryUsesCallbackResultForEachElement(): void
    {
        self::assertFalse((new Arr(2, 4, 5))->every(static fn (int $value): bool => 0 === $value % 2));
        self::assertTrue((new Arr(2, 4, 6))->every(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testEveryBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();
        $dummy->threshold = 4;

        self::assertTrue((new Arr(1, 2, 3))->every($dummy->thresholdCallback(), $dummy));
        self::assertFalse((new Arr(1, 2, 4))->every($dummy->thresholdCallback(), $dummy));
    }

    public function testEveryCallbackReceivesThreeArguments(): void
    {
        self::assertTrue((new Arr(0, 1, true, null, new \stdClass(), 'five'))->every(static fn (...$args): bool => 3 === \func_num_args()));
    }

    public function testEveryTreatsTruthyObjectReturnValueAsTrue(): void
    {
        $accessed = false;
        $array = new Arr();
        $array->push(11);

        self::assertTrue($array->every(static function () use (&$accessed): object {
            $accessed = true;

            return new \stdClass();
        }));
        self::assertTrue($accessed);
    }

    public function testEveryPropagatesPredicateExceptions(): void
    {
        $called = 0;

        try {
            (new Arr(11, 10, 8))->every(static function () use (&$called): bool {
                ++$called;

                throw new \RuntimeException('Exception occurred in callbackfn');
            });

            self::fail('Expected predicate exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertSame(1, $called);
    }

    public function testEverySkipsIndexesRemovedAfterIterationStarts(): void
    {
        $array = new Arr(1, 2, 3, 4, 6);

        self::assertTrue($array->every(static function (int $value, int $index, Arr $receivedArray): bool {
            if (0 === $index) {
                $receivedArray->splice(3);
            }

            return $value < 4;
        }));
    }

    public function testEveryContinuesAfterIndexRemovedDuringIteration(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4);

        self::assertTrue($array->every(static function (int $value, int $index, Arr $receivedArray) use (&$visited): bool {
            $visited[] = $value;

            if (0 === $index) {
                unset($receivedArray[1]);
            }

            return true;
        }));

        self::assertSame([1, 3, 4], $visited);
    }

    // Array.prototype.fill

    public function testFillWritesValueBetweenStartAndEnd(): void
    {
        self::assertSame([0, 1, 'x', 'x'], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', 2)->values()));
        self::assertSame([0, 'x', 'x', 3], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', 1, 3)->values()));
    }

    public function testFillSupportsNegativeStartAndEnd(): void
    {
        self::assertSame([0, 1, 'x', 'x'], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', -2)->values()));
        self::assertSame([0, 'x', 'x', 3], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', -3, -1)->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', -10, -10)->values()));
        self::assertSame(['x', 1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->fill('x', -10, 1)->values()));
    }

    public function testFillReturnsThisObject(): void
    {
        $array = new Arr(0, 1, 2);

        self::assertSame($array, $array->fill('x', 1));
    }

    public function testFillReplacesAllElementsFromDefaultStartAndEnd(): void
    {
        self::assertSame([], iterator_to_array((new Arr())->fill(8)->values()));
        self::assertSame([8, 8, 8], iterator_to_array((new Arr(0, 0, 0))->fill(8)->values()));
    }

    public function testFillUsesRelativeEndWhenProvided(): void
    {
        self::assertSame([8, 0, 0], iterator_to_array((new Arr(0, 0, 0))->fill(8, 0, 1)->values()));
        self::assertSame([8, 8, 0], iterator_to_array((new Arr(0, 0, 0))->fill(8, 0, -1)->values()));
        self::assertSame([8, 8, 8], iterator_to_array((new Arr(0, 0, 0))->fill(8, 0, 5)->values()));
        self::assertSame([0, 0, 0], iterator_to_array((new Arr(0, 0, 0))->fill(8, 0, 0)->values()));
    }

    public function testFillUsesRelativeStartWhenProvided(): void
    {
        self::assertSame([0, 8, 8], iterator_to_array((new Arr(0, 0, 0))->fill(8, 1)->values()));
        self::assertSame([0, 0, 0], iterator_to_array((new Arr(0, 0, 0))->fill(8, 4)->values()));
        self::assertSame([0, 0, 8], iterator_to_array((new Arr(0, 0, 0))->fill(8, -1)->values()));
    }

    public function testFillClampsNegativeStartToZeroWithoutCreatingNegativeIndexes(): void
    {
        $array = new Arr(0, 0, 0);

        $array->fill(8, -5, 1);

        self::assertSame([8, 0, 0], iterator_to_array($array->values()));
        self::assertFalse(isset($array[-1]));
    }

    // Array.prototype.filter

    public function testFilterReturnsNewArrayWithElementsWhereCallbackReturnsTrue(): void
    {
        $result = (new Arr(1, 2, 3, 4, 5))->filter(static fn (int $value): bool => 1 === $value % 2);

        self::assertSame([1, 3, 5], iterator_to_array($result->values()));
    }

    public function testFilterBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();
        $dummy->limit = 3;

        self::assertSame([1, 2], iterator_to_array((new Arr(1, 2, 3, 4))->filter($dummy->limitCallback(), $dummy)->values()));
    }

    public function testFilterDoesNotConsiderNewElementsAddedAfterCall(): void
    {
        $source = new Arr(1, 2, 4, 5);
        $result = $source->filter(static function (int $value, int $index, Arr $array): bool {
            if (0 === $index) {
                $array->push(6);
            }

            return true;
        });

        self::assertCount(4, iterator_to_array($result->values()));
    }

    public function testFilterCallbackReceivesThreeArguments(): void
    {
        $called = false;

        (new Arr(0, 1, 2, 3))->filter(static function (...$args) use (&$called): bool {
            $called = true;

            return 3 === \func_num_args();
        });

        self::assertTrue($called);
    }

    public function testFilterTreatsTruthyObjectReturnValueAsTrue(): void
    {
        $array = new Arr();
        $array->push(11);

        self::assertSame([11], iterator_to_array($array->filter(static fn (): object => new \stdClass())->values()));
    }

    public function testFilterPropagatesPredicateExceptions(): void
    {
        $called = 0;

        try {
            (new Arr(11, 10, 8))->filter(static function () use (&$called): bool {
                ++$called;

                throw new \RuntimeException('Exception occurred in callbackfn');
            });

            self::fail('Expected predicate exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertSame(1, $called);
    }

    public function testFilterHasNoObservableEffectsOnEmptyArray(): void
    {
        $accessed = false;

        $result = (new Arr())->filter(static function () use (&$accessed): bool {
            $accessed = true;

            return true;
        });

        self::assertFalse($accessed);
        self::assertSame([], iterator_to_array($result->values()));
    }

    public function testFilterCanReturnEmptyArray(): void
    {
        $array = new Arr();
        $array->push(11);

        self::assertSame([], iterator_to_array($array->filter(static fn (): mixed => null)->values()));
    }

    public function testFilterSkipsIndexesRemovedAfterIterationStarts(): void
    {
        $array = new Arr(1, 2, 3, 4, 6);

        self::assertSame([1, 2, 3], iterator_to_array($array->filter(static function (int $value, int $index, Arr $receivedArray): bool {
            if (0 === $index) {
                $receivedArray->splice(3);
            }

            return $value < 4;
        })->values()));
    }

    public function testFilterDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $array->filter(static fn (int $value): bool => $value > 2);

        self::assertSame([1, 2, 3, 4], iterator_to_array($array->values()));
    }

    public function testFilterContinuesPastHoles(): void
    {
        $array = new Arr(3);
        $array[1] = 'x';

        self::assertSame(['x'], iterator_to_array($array->filter(static fn (): bool => true)->values()));
    }

    // Array.prototype.find

    public function testFindPassesValueIndexAndArrayToPredicate(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->find(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            $results[] = [$value, $index, $receivedArray];

            return false;
        });

        self::assertCount(3, $results);
        self::assertSame(['Mike', 0, $array], $results[0]);
        self::assertSame(['Rick', 1, $array], $results[1]);
        self::assertSame(['Leo', 2, $array], $results[2]);
    }

    public function testFindReturnsFirstMatchingValue(): void
    {
        self::assertSame(2, (new Arr(1, 2, 3))->find(static fn (int $value): bool => 0 === $value % 2));
        self::assertNull((new Arr(1, 3, 5))->find(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testFindBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        self::assertSame(2, (new Arr(1, 2, 3))->find($dummy->targetCallback(), $dummy));
    }

    public function testFindDoesNotCallPredicateOnEmptyArray(): void
    {
        $called = false;

        self::assertNull((new Arr())->find(static function () use (&$called): bool {
            $called = true;

            return true;
        }));
        self::assertFalse($called);
    }

    public function testFindUsesInitialRangeOfElementsDuringIteration(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $results = [];

        $array->find(static function (?string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->splice(1, 1);
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Shoes', 'Bike', null], $results);

        $array = new Arr('Skateboard', 'Barefoot');
        $results = [];

        $array->find(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->push('Motorcycle');
                $receivedArray->splice(1, 1, 'Magic Carpet');
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Skateboard', 'Magic Carpet'], $results);
    }

    public function testFindPropagatesPredicateExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('predicate failed');

        (new Arr(1))->find(static function (): bool {
            throw new \RuntimeException('predicate failed');
        });
    }

    // Array.prototype.findIndex

    public function testFindIndexPassesValueIndexAndArrayToPredicate(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->findIndex(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            $results[] = [$value, $index, $receivedArray];

            return false;
        });

        self::assertCount(3, $results);
        self::assertSame(['Mike', 0, $array], $results[0]);
        self::assertSame(['Rick', 1, $array], $results[1]);
        self::assertSame(['Leo', 2, $array], $results[2]);
    }

    public function testFindIndexReturnsFirstMatchingIndex(): void
    {
        self::assertSame(1, (new Arr(1, 2, 3))->findIndex(static fn (int $value): bool => 0 === $value % 2));
        self::assertSame(-1, (new Arr(1, 3, 5))->findIndex(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testFindIndexBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        self::assertSame(1, (new Arr(1, 2, 3))->findIndex($dummy->targetCallback(), $dummy));
    }

    public function testFindIndexDoesNotCallPredicateOnEmptyArray(): void
    {
        $called = false;

        self::assertSame(-1, (new Arr())->findIndex(static function () use (&$called): bool {
            $called = true;

            return true;
        }));
        self::assertFalse($called);
    }

    public function testFindIndexUsesInitialRangeOfElementsDuringIteration(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $results = [];

        $array->findIndex(static function (?string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->splice(1, 1);
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Shoes', 'Bike', null], $results);

        $array = new Arr('Skateboard', 'Barefoot');
        $results = [];

        $array->findIndex(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->push('Motorcycle');
                $receivedArray->splice(1, 1, 'Magic Carpet');
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Skateboard', 'Magic Carpet'], $results);
    }

    public function testFindIndexPropagatesPredicateExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('predicate failed');

        (new Arr(1))->findIndex(static function (): bool {
            throw new \RuntimeException('predicate failed');
        });
    }

    // Array.prototype.findLast

    public function testFindLastPassesValueIndexAndArrayToPredicateFromRightToLeft(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->findLast(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            $results[] = [$value, $index, $receivedArray];

            return false;
        });

        self::assertCount(3, $results);
        self::assertSame(['Leo', 2, $array], $results[0]);
        self::assertSame(['Rick', 1, $array], $results[1]);
        self::assertSame(['Mike', 0, $array], $results[2]);
    }

    public function testFindLastReturnsLastMatchingValue(): void
    {
        self::assertSame(4, (new Arr(1, 2, 3, 4))->findLast(static fn (int $value): bool => 0 === $value % 2));
        self::assertNull((new Arr(1, 3, 5))->findLast(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testFindLastBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        self::assertSame(2, (new Arr(1, 2, 3, 2))->findLast($dummy->targetCallback(), $dummy));
    }

    public function testFindLastDoesNotCallPredicateOnEmptyArray(): void
    {
        $called = false;

        self::assertNull((new Arr())->findLast(static function () use (&$called): bool {
            $called = true;

            return true;
        }));
        self::assertFalse($called);
    }

    public function testFindLastUsesInitialRangeOfElementsDuringIteration(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $results = [];

        $array->findLast(static function (?string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->splice(1, 1);
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Bike', 'Bike', 'Shoes'], $results);

        $array = new Arr('Skateboard', 'Barefoot');
        $results = [];

        $array->findLast(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->push('Motorcycle');
                $receivedArray->splice(0, 1, 'Magic Carpet');
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Barefoot', 'Magic Carpet'], $results);
    }

    public function testFindLastPropagatesPredicateExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('predicate failed');

        (new Arr(1))->findLast(static function (): bool {
            throw new \RuntimeException('predicate failed');
        });
    }

    // Array.prototype.findLastIndex

    public function testFindLastIndexPassesValueIndexAndArrayToPredicateFromRightToLeft(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->findLastIndex(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            $results[] = [$value, $index, $receivedArray];

            return false;
        });

        self::assertCount(3, $results);
        self::assertSame(['Leo', 2, $array], $results[0]);
        self::assertSame(['Rick', 1, $array], $results[1]);
        self::assertSame(['Mike', 0, $array], $results[2]);
    }

    public function testFindLastIndexReturnsLastMatchingIndex(): void
    {
        self::assertSame(3, (new Arr(1, 2, 3, 4))->findLastIndex(static fn (int $value): bool => 0 === $value % 2));
        self::assertSame(-1, (new Arr(1, 3, 5))->findLastIndex(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testFindLastIndexBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        self::assertSame(3, (new Arr(1, 2, 3, 2))->findLastIndex($dummy->targetCallback(), $dummy));
    }

    public function testFindLastIndexDoesNotCallPredicateOnEmptyArray(): void
    {
        $called = false;

        self::assertSame(-1, (new Arr())->findLastIndex(static function () use (&$called): bool {
            $called = true;

            return true;
        }));
        self::assertFalse($called);
    }

    public function testFindLastIndexUsesInitialRangeOfElementsDuringIteration(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $results = [];

        $array->findLastIndex(static function (?string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->splice(1, 1);
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Bike', 'Bike', 'Shoes'], $results);

        $array = new Arr('Skateboard', 'Barefoot');
        $results = [];

        $array->findLastIndex(static function (string $value, int $index, Arr $receivedArray) use (&$results): bool {
            if ([] === $results) {
                $receivedArray->push('Motorcycle');
                $receivedArray->splice(0, 1, 'Magic Carpet');
            }

            $results[] = $value;

            return false;
        });

        self::assertSame(['Barefoot', 'Magic Carpet'], $results);
    }

    public function testFindLastIndexPropagatesPredicateExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('predicate failed');

        (new Arr(1))->findLastIndex(static function (): bool {
            throw new \RuntimeException('predicate failed');
        });
    }

    // Array.prototype.flat

    public function testFlatHandlesEmptyNestedArrays(): void
    {
        $object = new \stdClass();
        $one = new Arr();
        $one->push(1);
        $oneAndObject = new Arr();
        $oneAndObject->push(1, $object);

        self::assertSame([], iterator_to_array((new Arr())->flat()->values()));
        self::assertSame([], iterator_to_array((new Arr(new Arr(), new Arr()))->flat()->values()));
        self::assertSame([1], iterator_to_array((new Arr(new Arr(), $one))->flat()->values()));
        self::assertSame([1, $object], iterator_to_array((new Arr(new Arr(), $oneAndObject))->flat()->values()));
    }

    public function testFlatUsesProvidedDepth(): void
    {
        $level3 = new Arr();
        $level3->push(4);
        $level2 = new Arr(3, $level3);
        $level1 = new Arr(2, $level2);
        $array = new Arr(1, $level1);

        self::assertSame([1, 2, $level2], iterator_to_array($array->flat(1)->values()));
        self::assertSame([1, 2, 3, $level3], iterator_to_array($array->flat(2)->values()));
        self::assertSame([1, 2, 3, 4], iterator_to_array($array->flat(10)->values()));
        self::assertSame([1, $level1], iterator_to_array($array->flat(0)->values()));
        self::assertSame([1, $level1], iterator_to_array($array->flat(-1)->values()));
    }

    public function testFlatDefaultDepthFlattensExactlyOneLevel(): void
    {
        $nested = new Arr(2);
        $inner = new Arr(1, $nested);

        self::assertSame([1, $nested], iterator_to_array((new Arr($inner))->flat()->values()));
    }

    public function testFlatDoesNotMutateOriginalArray(): void
    {
        $inner = new Arr(2);
        $array = new Arr(1, $inner);

        $array->flat();

        self::assertSame([1, $inner], iterator_to_array($array->values()));
    }

    // Array.prototype.flatMap

    public function testFlatMapAlwaysFlattensOneLevel(): void
    {
        self::assertSame(
            [1, 2, 2, 4],
            iterator_to_array((new Arr(1, 2))->flatMap(static fn (int $value): Arr => new Arr($value, $value * 2))->values()),
        );

        $result = (new Arr(1, 2, 3))->flatMap(static function (int $value): Arr {
            $inner = new Arr();
            $inner->push($value * 2);

            $outer = new Arr();
            $outer->push($inner);

            return $outer;
        });

        self::assertCount(3, iterator_to_array($result->values()));
        self::assertSame([2], iterator_to_array($result->at(0)->values()));
        self::assertSame([4], iterator_to_array($result->at(1)->values()));
        self::assertSame([6], iterator_to_array($result->at(2)->values()));
    }

    public function testFlatMapUsesThisArg(): void
    {
        $context = new class {
            public mixed $value = 'TestString';

            public function callback(): callable
            {
                return fn (): Arr => new Arr($this->value);
            }
        };

        $result = (new Arr('item'))->flatMap($context->callback(), $context);

        self::assertSame(['TestString'], iterator_to_array($result->values()));
    }

    public function testFlatMapBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();
        $dummy->suffix = '!';

        self::assertSame(['a!', 'b!'], iterator_to_array((new Arr('a', 'b'))->flatMap($dummy->suffixCallback(), $dummy)->values()));
    }

    public function testFlatMapPropagatesMapperExceptions(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('mapper failed');

        (new Arr(0))->concat(0)->flatMap(static function (): Arr {
            throw new \RuntimeException('mapper failed');
        });
    }

    public function testFlatMapDoesNotCallMapperForEmptyArray(): void
    {
        $callCount = 0;

        self::assertSame([], iterator_to_array((new Arr())->flatMap(static function () use (&$callCount): Arr {
            ++$callCount;

            throw new \RuntimeException('mapper failed');
        })->values()));
        self::assertSame(0, $callCount);
    }

    public function testFlatMapDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2);

        $array->flatMap(static fn (int $value): Arr => new Arr($value, $value * 2));

        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    // Array.prototype.forEach

    public function testForEachVisitsIndexesInOrderDuringIteration(): void
    {
        $result = true;
        $visited = [];

        (new Arr(11, 12, 13, 14))->forEach(static function (int $_value, int $index) use (&$result, &$visited): void {
            if (!isset($visited[$index])) {
                if (0 !== $index && !isset($visited[$index - 1])) {
                    $result = false;
                }

                $visited[$index] = true;

                return;
            }

            $result = false;
        });

        self::assertTrue($result);
    }

    public function testForEachBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        (new Arr(1, 2, 3))->forEach($dummy->visitedCallback(), $dummy);

        self::assertSame([1, 2, 3], $dummy->visited);
    }

    public function testForEachDoesNotConsiderNewElementsAddedAfterCall(): void
    {
        $callCount = 0;
        $array = new Arr(1, 2, 4, 5);

        $array->forEach(static function (int $_value, int $index, Arr $receivedArray) use (&$callCount): void {
            ++$callCount;

            if (0 === $index) {
                $receivedArray->push(6);
            }
        });

        self::assertSame(4, $callCount);
    }

    public function testForEachCallbackReceivesThreeArguments(): void
    {
        $called = false;

        (new Arr(0, 1, 2, 3))->forEach(static function (...$args) use (&$called): void {
            $called = true;
            self::assertSame(3, \func_num_args());
        });

        self::assertTrue($called);
    }

    public function testForEachPropagatesCallbackExceptions(): void
    {
        $accessed = false;

        try {
            (new Arr(11, 10, 8))->forEach(static function (int $value, int $index) use (&$accessed): void {
                if ($index > 0) {
                    $accessed = true;
                }

                if (0 === $index) {
                    throw new \RuntimeException('Exception occurred in callbackfn');
                }
            });

            self::fail('Expected callback exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertFalse($accessed);
    }

    public function testForEachHasNoObservableEffectsOnEmptyArray(): void
    {
        $accessed = false;

        (new Arr())->forEach(static function () use (&$accessed): void {
            $accessed = true;
        });

        self::assertFalse($accessed);
    }

    public function testForEachSkipsIndexesRemovedAfterIterationStarts(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 6);

        $array->forEach(static function (int $value, int $index, Arr $receivedArray) use (&$visited): void {
            if (0 === $index) {
                $receivedArray->splice(3);
            }

            $visited[] = $value;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testForEachContinuesAfterIndexRemovedDuringIteration(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4);

        $array->forEach(static function (int $value, int $index, Arr $receivedArray) use (&$visited): void {
            $visited[] = $value;

            if (0 === $index) {
                unset($receivedArray[1]);
            }
        });

        self::assertSame([1, 3, 4], $visited);
    }

    // Array.prototype.includes

    public function testIncludesReturnsTrueForFoundIndex(): void
    {
        $object = new \stdClass();
        $array = [];

        $sample = new Arr(42, 'test262', null, null, true, false, 0, -1, '', $object, $array);

        self::assertTrue($sample->includes(42));
        self::assertTrue($sample->includes('test262'));
        self::assertTrue($sample->includes(null));
        self::assertTrue($sample->includes(true));
        self::assertTrue($sample->includes(false));
        self::assertTrue($sample->includes(0));
        self::assertTrue($sample->includes(-1));
        self::assertTrue($sample->includes(''));
        self::assertTrue($sample->includes($object));
        self::assertTrue($sample->includes($array));
    }

    public function testIncludesUsesSameValueZeroForNaN(): void
    {
        $array = new Arr();
        $array->push(NAN);

        self::assertTrue($array->includes(NAN));
    }

    public function testIncludesUsesSameValueZeroSemantics(): void
    {
        $sample = new Arr(42, 0, 1, NAN);

        self::assertFalse($sample->includes('42'));
        self::assertFalse($sample->includes([42]));
        self::assertTrue($sample->includes(42.0));
        self::assertTrue((new Arr())->concat(1.0)->includes(1));
        self::assertTrue($sample->includes(-0.0));
        self::assertFalse($sample->includes(true));
        self::assertFalse($sample->includes(false));
        self::assertFalse($sample->includes(null));
        self::assertFalse($sample->includes(''));
        self::assertTrue($sample->includes(NAN));
    }

    public function testIncludesDoesNotMatchNaNAgainstOtherNumbers(): void
    {
        self::assertFalse((new Arr(1, 2, 3))->includes(NAN));
        self::assertFalse((new Arr())->concat(NAN)->includes(1));
        self::assertFalse((new Arr('1'))->includes(1));
        self::assertFalse((new Arr(1))->concat('1')->includes(1.0, 1));
    }

    public function testIncludesSearchesUsingFromIndex(): void
    {
        $sample = new Arr('a', 'b', 'c');

        self::assertTrue($sample->includes('a', 0));
        self::assertFalse($sample->includes('a', 1));
        self::assertFalse($sample->includes('a', 2));
        self::assertTrue($sample->includes('b', 0));
        self::assertTrue($sample->includes('b', 1));
        self::assertFalse($sample->includes('b', 2));
        self::assertTrue($sample->includes('c', 0));
        self::assertTrue($sample->includes('c', 1));
        self::assertTrue($sample->includes('c', 2));
        self::assertFalse($sample->includes('a', -1));
        self::assertFalse($sample->includes('a', -2));
        self::assertTrue($sample->includes('a', -3));
        self::assertTrue($sample->includes('a', -4));
        self::assertFalse($sample->includes('b', -1));
        self::assertTrue($sample->includes('b', -2));
        self::assertTrue($sample->includes('b', -3));
        self::assertTrue($sample->includes('b', -4));
        self::assertTrue($sample->includes('c', -1));
        self::assertTrue($sample->includes('c', -2));
        self::assertTrue($sample->includes('c', -3));
        self::assertTrue($sample->includes('c', -4));
        self::assertTrue((new Arr(null))->includes(null, -2));
        self::assertFalse((new Arr('value'))->includes(null, -2));
    }

    public function testIncludesReturnsFalseWhenFromIndexIsAtOrBeyondLengthOrArrayIsEmpty(): void
    {
        self::assertFalse((new Arr(7, 7, 7, 7))->includes(7, 4));
        self::assertFalse((new Arr(7, 7, 7, 7))->includes(7, 5));
        self::assertFalse((new Arr())->includes(0));
        self::assertFalse((new Arr())->includes());
        self::assertFalse((new Arr())->includes(0, 1));
    }

    public function testIncludesWithoutArgumentSearchesForNullLikeUndefined(): void
    {
        self::assertFalse((new Arr(0))->concat()->includes());
        self::assertTrue((new Arr(null))->includes());
    }

    public function testIncludesSearchesHolePositionsAsNullLikeUndefined(): void
    {
        self::assertTrue((new Arr(3))->includes(null));

        $sample = new Arr(5);
        $sample->splice(3, 1, 42);

        self::assertTrue($sample->includes(null));
        self::assertTrue($sample->includes(null, 4));
        self::assertTrue($sample->includes(42, 3));
    }

    // Array.prototype.indexOf

    public function testIndexOfReturnsFirstMatchingIndex(): void
    {
        self::assertSame(1, (new Arr(1, 2, 2, 3))->indexOf(2));
        self::assertSame(0, (new Arr(null, 1))->indexOf());
        self::assertSame(0, (new Arr())->concat(1.0)->indexOf(1));
    }

    public function testIndexOfRespectsFromIndex(): void
    {
        self::assertSame(2, (new Arr(1, 2, 2, 3))->indexOf(2, 2));
        self::assertSame(2, (new Arr(1, 2, 2, 3))->indexOf(2, -2));
        self::assertSame(-1, (new Arr(1, 2, 2, 3))->indexOf(2, 3));
        self::assertSame(0, (new Arr('a', 'b', 'c'))->indexOf('a', -10));
        self::assertSame(0, (new Arr(null))->indexOf(null, -2));
        self::assertSame(-1, (new Arr('value'))->indexOf(null));
    }

    public function testIndexOfReturnsMinusOneForEmptyArray(): void
    {
        self::assertSame(-1, (new Arr())->indexOf(1));
        self::assertSame(-1, (new Arr())->indexOf(2, 1));
    }

    public function testIndexOfDoesNotFindNaN(): void
    {
        $array = new Arr('NaN', null, 0, false, null, 'false');
        $array->push(NAN, NAN);

        self::assertSame(-1, $array->indexOf(NAN));
    }

    public function testIndexOfNegativeFromIndexClampsToZero(): void
    {
        self::assertSame(0, (new Arr('a'))->indexOf('a', -2));
    }

    // Array.prototype.join

    public function testJoinReturnsEmptyStringForLengthZero(): void
    {
        self::assertSame('', (new Arr())->join());
        self::assertSame('', (new Arr(0))->fill(1, 0, 0)->join());
    }

    public function testJoinUsesEmptyStringForNullValues(): void
    {
        self::assertSame(',1,,', (new Arr(null, 1, null, null))->join());
    }

    public function testJoinUsesEmptyStringForHoles(): void
    {
        self::assertSame(',,', (new Arr(3))->join());
    }

    public function testJoinUsesCommaWhenSeparatorIsUndefined(): void
    {
        self::assertSame('0,1,2,3', (new Arr(0, 1, 2, 3))->join());
        $array = new Arr();
        $array->push(0);

        self::assertSame('0', $array->join());
    }

    public function testJoinReturnsStringElementsUnchanged(): void
    {
        self::assertSame('a,b,c', (new Arr('a', 'b', 'c'))->join());
        self::assertSame('x,[object Object]', (new Arr(['x', new \stdClass()]))->join());
    }

    public function testJoinUsesStringSeparatorAndStringifiesValues(): void
    {
        self::assertSame('0123', (new Arr(0, 1, 2, 3))->join(''));
        self::assertSame('0\1\2\3', (new Arr(0, 1, 2, 3))->join('\\'));
        self::assertSame('0&1&2&3', (new Arr(0, 1, 2, 3))->join('&'));
        self::assertSame('true,true,true', (new Arr(true, true, true))->join());
        self::assertSame(',,', (new Arr(null, null, null))->join());
        self::assertSame('Infinity,Infinity,Infinity', (new Arr(INF, INF, INF))->join());
        self::assertSame('NaN,NaN,NaN', (new Arr(NAN, NAN, NAN))->join());
    }

    public function testJoinStringifiesPhpArraysAndNonStringableObjects(): void
    {
        self::assertSame('1,2,[object Object]', (new Arr([1, 2], new \stdClass()))->join());
    }

    public function testJoinReindexesTraversablesInsteadOfPreservingDuplicateKeys(): void
    {
        $iterable = new class implements \IteratorAggregate {
            public function getIterator(): \Traversable
            {
                yield 0 => 'a';

                yield 0 => 'b';
            }
        };

        self::assertSame('a,b', (new Arr($iterable))->join());
    }

    // Array.prototype.keys

    public function testKeysReturnsNumericProperties(): void
    {
        self::assertSame([0, 1, 2], iterator_to_array((new Arr('a', 'b', 'c'))->keys()));
        self::assertSame([], iterator_to_array((new Arr())->keys()));
    }

    public function testKeysIteratorSeesItemsAddedBeforeExhaustion(): void
    {
        $array = new Arr();
        $iterator = $array->keys();
        $array->push('a');

        self::assertSame([0], iterator_to_array($iterator));
    }

    public function testKeysYieldsAllIndicesUpToLengthMinusOneEvenWhenSparse(): void
    {
        $array = new Arr(3);
        $array->offsetSet(1, 'x');

        self::assertSame([0, 1, 2], iterator_to_array($array->keys()));
    }

    // Array.prototype.lastIndexOf

    public function testLastIndexOfReturnsLastMatchingIndex(): void
    {
        self::assertSame(2, (new Arr(1, 2, 2, 3))->lastIndexOf(2));
        self::assertSame(3, (new Arr(1, 2, 2, 3))->lastIndexOf(3));
        self::assertSame(0, (new Arr())->concat(1.0)->lastIndexOf(1));
    }

    public function testLastIndexOfRespectsFromIndex(): void
    {
        self::assertSame(1, (new Arr(1, 2, 2, 3))->lastIndexOf(2, 1));
        self::assertSame(2, (new Arr(1, 2, 2, 3))->lastIndexOf(2, -2));
        self::assertSame(-1, (new Arr(1, 2, 2, 3))->lastIndexOf(2, -4));
        self::assertSame(3, (new Arr(1, 2, 2, 3))->lastIndexOf(3, 99));
        self::assertSame(-1, (new Arr(1, 2, 2, 3))->lastIndexOf(1, -5));
        self::assertSame(-1, (new Arr(1, 2, 2, 3))->lastIndexOf(3, 2));
        self::assertSame(0, (new Arr(1, 2))->lastIndexOf(1, 0));
        self::assertSame(0, (new Arr())->concat(1)->lastIndexOf(1, 0));
        self::assertSame(-1, (new Arr('a', 'b'))->lastIndexOf('b', 0));
        self::assertSame(-1, (new Arr('value'))->lastIndexOf(null));
    }

    public function testLastIndexOfReturnsMinusOneForEmptyArray(): void
    {
        self::assertSame(-1, (new Arr())->lastIndexOf(1));
        self::assertSame(-1, (new Arr())->lastIndexOf(2, 1));
    }

    public function testLastIndexOfDoesNotFindNaN(): void
    {
        $array = new Arr('NaN', null);
        $array->push(NAN, null, 0, false, null, 'false');

        self::assertSame(-1, $array->lastIndexOf(NAN));
    }

    // Array.prototype.map

    public function testMapAccessesValuesDuringEachIteration(): void
    {
        $visited = [];

        $result = (new Arr(11, 12, 13, 14))->map(static function (int $_value, int $index) use (&$visited): bool {
            if (!isset($visited[$index])) {
                if (0 !== $index && !isset($visited[$index - 1])) {
                    return true;
                }

                $visited[$index] = true;

                return false;
            }

            return true;
        });

        self::assertSame([false, false, false, false], iterator_to_array($result->values()));
    }

    public function testMapBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();
        $dummy->multiplier = 3;

        self::assertSame([3, 6, 9], iterator_to_array((new Arr(1, 2, 3))->map($dummy->multiplierCallback(), $dummy)->values()));
    }

    public function testMapDoesNotConsiderNewElementsAddedAfterCall(): void
    {
        $source = new Arr(1, 2, 4, 5);
        $result = $source->map(static function (int $_value, int $index, Arr $array): int {
            if (0 === $index) {
                $array->push(6);
            }

            return 1;
        });

        self::assertCount(4, iterator_to_array($result->values()));
    }

    public function testMapCallbackReceivesThreeArguments(): void
    {
        $called = false;

        (new Arr(0, 1, 2, 3))->map(static function (...$args) use (&$called): bool {
            $called = true;

            return 3 === \func_num_args();
        });

        self::assertTrue($called);
    }

    public function testMapPropagatesMapperExceptions(): void
    {
        $accessed = false;

        try {
            (new Arr(11, 10, 8))->map(static function (int $value, int $index) use (&$accessed): mixed {
                if ($index > 0) {
                    $accessed = true;
                }

                if (0 === $index) {
                    throw new \RuntimeException('Exception occurred in callbackfn');
                }

                return $value;
            });

            self::fail('Expected mapper exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertFalse($accessed);
    }

    public function testMapSkipsIndexesRemovedAfterIterationStarts(): void
    {
        $array = new Arr(1, 2, 3, 4, 6);

        self::assertSame([1, 2, 3, null, null], iterator_to_array($array->map(static function (int $value, int $index, Arr $receivedArray): int {
            if (0 === $index) {
                $receivedArray->splice(3);
            }

            return $value;
        })->values()));
    }

    public function testMapContinuesAfterIndexRemovedDuringIteration(): void
    {
        $array = new Arr(1, 2, 3, 4);

        self::assertSame([1, null, 3, 4], iterator_to_array($array->map(static function (int $value, int $index, Arr $receivedArray): int {
            if (0 === $index) {
                unset($receivedArray[1]);
            }

            return $value;
        })->values()));
    }

    public function testMapDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2, 3);

        $array->map(static fn (int $value): int => $value * 2);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    // Array.prototype.pop

    public function testPopReturnsUndefinedWhenLengthIsZero(): void
    {
        $array = new Arr();

        self::assertNull($array->pop());
        self::assertSame(0, $array->length);
        self::assertCount(0, iterator_to_array($array->values()));
    }

    public function testPopReturnsLastElementAndMutatesArray(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(3, $array->pop());
        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    public function testPopReturnsUndefinedForTrailingHole(): void
    {
        $array = new Arr(1, 2, 3);
        unset($array[2]);

        self::assertNull($array->pop());
        self::assertSame(2, $array->length);
        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    // Array.prototype.push

    public function testPushAppendsArgumentsAndReturnsNewLength(): void
    {
        $array = new Arr();

        self::assertSame(1, $array->push(-1));
        self::assertSame([-1], iterator_to_array($array->values()));
        self::assertSame(3, $array->push(-4, -7));
        self::assertSame([-1, -4, -7], iterator_to_array($array->values()));
    }

    public function testPushWithNoArgumentsKeepsLengthUnchanged(): void
    {
        $array = new Arr();
        $array->push(1);

        self::assertSame(1, $array->push());
        self::assertSame([1], iterator_to_array($array->values()));
        self::assertSame(2, $array->push(-1));
        self::assertSame([1, -1], iterator_to_array($array->values()));
    }

    // Array.prototype.reduce

    public function testReduceThrowsOnEmptyArrayWithoutInitialValue(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Reduce of empty array with no initial value');

        (new Arr())->reduce(static fn (mixed $accumulator, mixed $value): mixed => $accumulator + $value);
    }

    public function testReduceAccumulatesValuesLeftToRight(): void
    {
        self::assertSame(10, (new Arr(1, 2, 3, 4))->reduce(static fn (int $acc, int $value): int => $acc + $value, 0));
        self::assertSame(10, (new Arr(1, 2, 3, 4))->reduce(static fn (int $acc, int $value): int => $acc + $value));
    }

    public function testReduceReturnsInitialValueForEmptyArray(): void
    {
        self::assertSame(5, (new Arr())->reduce(static fn (int $acc, int $value): int => $acc + $value, 5));
    }

    public function testReduceConsidersNewElementValuesDuringIteration(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);

        self::assertSame(3, $array->reduce(static function (int $previousValue, int $currentValue, int $index, Arr $receivedArray): int {
            if (1 === $index) {
                $receivedArray->splice(3, 2, -2, -1);
            }

            return $previousValue + $currentValue;
        }));
    }

    public function testReduceCallbackReceivesFourArguments(): void
    {
        $called = false;

        self::assertTrue((new Arr(0, 1, 2, 3))->reduce(static function (...$args) use (&$called): bool {
            $called = true;

            return 4 === \func_num_args();
        }, true));
        self::assertTrue($called);
    }

    public function testReduceUsesPreviousIterationResultAsAccumulator(): void
    {
        $result = true;
        $preIteration = 1;

        (new Arr(11, 12, 13))->reduce(static function (int $previousValue, int $currentValue) use (&$result, &$preIteration): int {
            if ($preIteration !== $previousValue) {
                $result = false;
            }

            $preIteration = $currentValue;

            return $currentValue;
        }, 1);

        self::assertTrue($result);
    }

    public function testReduceDoesNotCallCallbackForSingleElementWithoutInitialValue(): void
    {
        $callCount = 0;
        $array = new Arr();
        $array->push(1);

        self::assertSame(1, $array->reduce(static function () use (&$callCount): int {
            ++$callCount;

            return 2;
        }));
        self::assertSame(0, $callCount);
    }

    public function testReducePropagatesCallbackExceptions(): void
    {
        $accessed = false;

        try {
            (new Arr(11, 10, 8))->reduce(static function (int $previousValue, int $currentValue, int $index) use (&$accessed): int {
                if ($index > 0) {
                    $accessed = true;
                }

                if (0 === $index) {
                    throw new \RuntimeException('Exception occurred in callbackfn');
                }

                return $previousValue + $currentValue;
            }, 1);

            self::fail('Expected reducer exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertFalse($accessed);
    }

    public function testReduceWithInitialValueHasNoObservableEffectsOnEmptyArray(): void
    {
        $accessed = false;
        $callbackAccessed = false;

        self::assertSame('initialValue', (new Arr())->reduce(static function () use (&$callbackAccessed): mixed {
            $callbackAccessed = true;

            return 'x';
        }, 'initialValue'));
        self::assertFalse($accessed);
        self::assertFalse($callbackAccessed);
    }

    // Array.prototype.reduceRight

    public function testReduceRightThrowsOnEmptyArrayWithoutInitialValue(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Reduce of empty array with no initial value');

        (new Arr())->reduceRight(static fn (mixed $accumulator, mixed $value): mixed => $accumulator + $value);
    }

    public function testReduceRightAccumulatesValuesRightToLeft(): void
    {
        self::assertSame('cba', (new Arr('a', 'b', 'c'))->reduceRight(static fn (string $acc, string $value): string => $acc.$value, ''));
        self::assertSame('cba', (new Arr('a', 'b', 'c'))->reduceRight(static fn (string $acc, string $value): string => $acc.$value));
    }

    public function testReduceRightReturnsInitialValueForEmptyArray(): void
    {
        self::assertSame(5, (new Arr())->reduceRight(static fn (int $acc, int $value): int => $acc + $value, 5));
    }

    public function testReduceRightConsidersNewElementValuesDuringIteration(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);

        self::assertSame(13, $array->reduceRight(static function (int $previousValue, int $currentValue, int $index, Arr $receivedArray): int {
            if (3 === $index) {
                $receivedArray->splice(3, 1, -2);
                $receivedArray->splice(0, 1, -1);
            }

            return $previousValue + $currentValue;
        }));
    }

    public function testReduceRightCallbackReceivesFourArguments(): void
    {
        $called = false;

        self::assertTrue((new Arr(0, 1, 2, 3))->reduceRight(static function (...$args) use (&$called): bool {
            $called = true;

            return 4 === \func_num_args();
        }, true));
        self::assertTrue($called);
    }

    public function testReduceRightUsesPreviousIterationResultAsAccumulator(): void
    {
        $result = true;
        $previousResult = 6;

        (new Arr(11, 12, 13))->reduceRight(static function (int $previousValue, int $currentValue) use (&$result, &$previousResult): int {
            if ($previousResult !== $previousValue) {
                $result = false;
            }

            $previousResult = $currentValue;

            return $currentValue;
        }, 6);

        self::assertTrue($result);
    }

    public function testReduceRightDoesNotCallCallbackForSingleElementWithoutInitialValue(): void
    {
        $callCount = 0;
        $array = new Arr();
        $array->push(1);

        self::assertSame(1, $array->reduceRight(static function () use (&$callCount): int {
            ++$callCount;

            return 2;
        }));
        self::assertSame(0, $callCount);
    }

    public function testReduceRightPropagatesCallbackExceptions(): void
    {
        $accessed = false;

        try {
            (new Arr(11, 10, 8))->reduceRight(static function (int $previousValue, int $currentValue, int $index) use (&$accessed): int {
                if ($index < 2) {
                    $accessed = true;
                }

                if (2 === $index) {
                    throw new \RuntimeException('Exception occurred in callbackfn');
                }

                return $previousValue + $currentValue;
            }, 1);

            self::fail('Expected reducer exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertFalse($accessed);
    }

    // Array.prototype.reverse

    public function testReverseMutatesAndReturnsSameObject(): void
    {
        $array = new Arr(1, 2);
        $result = $array->reverse();

        self::assertSame($array, $result);
        self::assertSame([2, 1], iterator_to_array($array->values()));
    }

    public function testReverseWithZeroOrOneElementReturnsSameObjectWithoutChangingData(): void
    {
        $empty = new Arr();
        $single = new Arr('value');

        self::assertSame($empty, $empty->reverse());
        self::assertSame([], iterator_to_array($empty->values()));
        self::assertSame($single, $single->reverse());
        self::assertSame(['value'], iterator_to_array($single->values()));
    }

    public function testReverseWithSparseArrayReversesAndPreservesLength(): void
    {
        $array = new Arr(4);
        $array->offsetSet(0, 'a');
        $array->offsetSet(2, 'c');
        $array->reverse();

        self::assertSame([null, 'c', null, 'a'], iterator_to_array($array->values()));
    }

    public function testReverseWithSparseArrayKeepsInternalIterationInIndexOrder(): void
    {
        $array = new Arr(4);
        $array->offsetSet(0, 'a');
        $array->offsetSet(2, 'c');

        $array->reverse();

        self::assertSame(['c', 'a'], iterator_to_array($array->flat()->values()));
    }

    // Array.prototype.shift

    public function testShiftReturnsUndefinedForEmptyArray(): void
    {
        $array = new Arr();

        self::assertNull($array->shift());
        self::assertSame(0, $array->length);
        self::assertCount(0, iterator_to_array($array->values()));
    }

    public function testShiftReturnsFirstElementAndMutatesArray(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(1, $array->shift());
        self::assertSame([2, 3], iterator_to_array($array->values()));
    }

    public function testShiftDoesNotCreateNegativeIndexes(): void
    {
        $array = new Arr('a', 'b');

        self::assertSame('a', $array->shift());
        self::assertFalse(isset($array[-1]));
        self::assertSame(['b'], iterator_to_array($array->values()));
    }

    // Array.prototype.slice

    public function testSliceWithPositiveStartAndEndReturnsExpectedValues(): void
    {
        $result = (new Arr(0, 1, 2, 3, 4))->slice(0, 3);

        self::assertSame([0, 1, 2], iterator_to_array($result->values()));
        self::assertNull($result->at(3));
        self::assertSame([0, 1, 2, 3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice()->values()));
    }

    public function testSliceSupportsNegativeIndexes(): void
    {
        self::assertSame([2, 3], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(-3, -1)->values()));
        self::assertSame([], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(-10, -10)->values()));
        self::assertSame([0], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(-10, 1)->values()));
    }

    public function testSliceDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(0, 1, 2, 3);

        $array->slice(1, 3);

        self::assertSame([0, 1, 2, 3], iterator_to_array($array->values()));
    }

    public function testSliceReturnsEmptyArrayWhenStartIsGreaterThanEnd(): void
    {
        self::assertSame([], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(4, 3)->values()));
        self::assertSame([], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(0, 0)->values()));
    }

    public function testSliceClampsNegativeStartBelowZero(): void
    {
        self::assertSame([0, 1, 2, 3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(-9, 5)->values()));
    }

    public function testSliceUsesLengthWhenEndIsAbsent(): void
    {
        self::assertSame([3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(-2)->values()));
    }

    public function testSliceClampsEndBeyondLength(): void
    {
        self::assertSame([3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(3, 6)->values()));
    }

    public function testSliceClampsStartBeyondLength(): void
    {
        self::assertSame([], iterator_to_array((new Arr(0, 1, 2, 3, 4))->slice(10)->values()));
    }

    // Array.prototype.some

    public function testSomeReturnsFalseForEmptyArray(): void
    {
        self::assertFalse((new Arr())->some(static fn (): bool => true));
    }

    public function testSomeReturnsTrueWhenPredicateMatches(): void
    {
        self::assertTrue((new Arr(1, 2, 3))->some(static fn (int $value): bool => 0 === $value % 2));
        self::assertFalse((new Arr(1, 3, 5))->some(static fn (int $value): bool => 0 === $value % 2));
    }

    public function testSomeBindsThisArgForClosures(): void
    {
        $dummy = new Dummy();

        self::assertTrue((new Arr(1, 2, 3))->some($dummy->targetCallback(), $dummy));
        self::assertFalse((new Arr(1, 3, 4))->some($dummy->targetCallback(), $dummy));
    }

    public function testSomeCallbackReceivesThreeArguments(): void
    {
        self::assertFalse((new Arr(0, 1, true, null, new \stdClass(), 'five'))->some(static fn (...$args): bool => 3 !== \func_num_args()));
    }

    public function testSomeTreatsTruthyObjectReturnValueAsTrue(): void
    {
        $array = new Arr();
        $array->push(11);

        self::assertTrue($array->some(static fn (): object => new \stdClass()));
    }

    public function testSomePropagatesPredicateExceptions(): void
    {
        $accessed = false;

        try {
            (new Arr(9, 100, 11))->some(static function (int $value, int $index) use (&$accessed): bool {
                if ($index > 0) {
                    $accessed = true;
                }

                if (0 === $index) {
                    throw new \RuntimeException('Exception occurred in callbackfn');
                }

                return false;
            });

            self::fail('Expected predicate exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('Exception occurred in callbackfn', $exception->getMessage());
        }

        self::assertFalse($accessed);
    }

    public function testSomeHasNoObservableEffectsOnEmptyArray(): void
    {
        $accessed = false;

        self::assertFalse((new Arr())->some(static function () use (&$accessed): bool {
            $accessed = true;

            return true;
        }));
        self::assertFalse($accessed);
    }

    public function testSomeSkipsIndexesRemovedAfterIterationStarts(): void
    {
        $array = new Arr(1, 2, 3, 4, 6);

        self::assertFalse($array->some(static function (int $value, int $index, Arr $receivedArray): bool {
            if (0 === $index) {
                $receivedArray->splice(3);
            }

            return $value > 4;
        }));
    }

    public function testSomeContinuesAfterIndexRemovedDuringIteration(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4);

        self::assertTrue($array->some(static function (int $value, int $index, Arr $receivedArray) use (&$visited): bool {
            $visited[] = $value;

            if (0 === $index) {
                unset($receivedArray[1]);
            }

            return 4 === $value;
        }));

        self::assertSame([1, 3, 4], $visited);
    }

    // Array.prototype.sort

    public function testSortWithoutCompareFnUsesStringComparison(): void
    {
        $array = new Arr(2, 11, 1);

        self::assertSame($array, $array->sort());
        self::assertSame([1, 11, 2], iterator_to_array($array->values()));
    }

    public function testSortUsesProvidedComparator(): void
    {
        $array = new Arr(4, 3, 2, 1);

        $array->sort(static fn (int $a, int $b): int => $a <=> $b);

        self::assertSame([1, 2, 3, 4], iterator_to_array($array->values()));
    }

    public function testSortIsStableForEqualComparatorValues(): void
    {
        $array = new Arr(
            ['name' => 'A', 'rating' => 2],
            ['name' => 'B', 'rating' => 3],
            ['name' => 'C', 'rating' => 2],
            ['name' => 'D', 'rating' => 3],
            ['name' => 'E', 'rating' => 3],
        );

        $array->sort(static fn (array $a, array $b): int => $b['rating'] <=> $a['rating']);

        self::assertSame('BDEAC', implode('', array_map(static fn (array $item): string => $item['name'], iterator_to_array($array->values()))));
    }

    public function testSortDoesNotSwallowExceptionsFromComparator(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('compare failed');

        (new Arr(1, 0))->sort(static function (): int {
            throw new \RuntimeException('compare failed');
        });
    }

    public function testSortMovesSparseHolesToTheEndDroppingLength(): void
    {
        $array = new Arr(4);
        $array[1] = 'b';
        $array[3] = 'a';
        $array[5] = 'c';

        $array->sort();

        self::assertSame(6, $array->length);
        self::assertSame(['a', 'b', 'c', null, null, null], iterator_to_array($array->values()));
        self::assertTrue(isset($array[0]));
        self::assertTrue(isset($array[1]));
        self::assertTrue(isset($array[2]));
        self::assertFalse(isset($array[3]));
        self::assertFalse(isset($array[4]));
        self::assertFalse(isset($array[5]));
    }

    public function testSortWithDescCallbackMovesSparseHolesToTheEndDroppingLength(): void
    {
        $array = new Arr(4);
        $array[1] = 'b';
        $array[3] = 'a';
        $array[5] = 'c';

        $array->sort(static fn ($a, $b) => $b <=> $a);

        self::assertSame(6, $array->length);
        self::assertSame(['c', 'b', 'a', null, null, null], iterator_to_array($array->values()));
        self::assertTrue(isset($array[0]));
        self::assertTrue(isset($array[1]));
        self::assertTrue(isset($array[2]));
        self::assertFalse(isset($array[3]));
        self::assertFalse(isset($array[4]));
        self::assertFalse(isset($array[5]));
    }

    // Array.prototype.splice

    public function testSpliceRemovesRequestedElementsAndMutatesReceiver(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(0, 3);

        self::assertSame([0, 1, 2], iterator_to_array($removed->values()));
        self::assertSame([3], iterator_to_array($array->values()));
    }

    public function testSpliceSupportsInsertion(): void
    {
        $array = new Arr(0, 1, 4, 5);
        $removed = $array->splice(2, 0, 2, 3);

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array($array->values()));
    }

    public function testSpliceWithOmittedDeleteCountRemovesToEnd(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(2);

        self::assertSame([2, 3], iterator_to_array($removed->values()));
        self::assertSame([0, 1], iterator_to_array($array->values()));
    }

    public function testSpliceWithOmittedDeleteCountUsesStartOffset(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(1);

        self::assertSame([1, 2, 3], iterator_to_array($removed->values()));
        self::assertSame([0], iterator_to_array($array->values()));
    }

    public function testSpliceSupportsNamedInsertedArguments(): void
    {
        $array = new Arr('a', 'd');
        $removed = $array->splice(1, 0, first: 'b', second: 'c');

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame(['a', 'b', 'c', 'd'], iterator_to_array($array->values()));
    }

    public function testSpliceWithNegativeStartBeyondLengthStartsAtZero(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(-10);

        self::assertSame([0, 1, 2, 3], iterator_to_array($removed->values()));
        self::assertSame([], iterator_to_array($array->values()));
    }

    public function testSpliceTreatsNegativeDeleteCountAsZero(): void
    {
        $array = new Arr(0, 1);
        $removed = $array->splice(-2, -1);

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame([0, 1], iterator_to_array($array->values()));
    }

    public function testSpliceClampsDeleteCountToRemainingLengthAndSupportsInsertion(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(1, 4, 4, 5);

        self::assertSame([1, 2, 3], iterator_to_array($removed->values()));
        self::assertSame([0, 4, 5], iterator_to_array($array->values()));
    }

    public function testSpliceRemovedArrayDoesNotExposeIndexesOutsideDeleteCount(): void
    {
        $removed = (new Arr(0, 1, 2, 3))->splice(1, 1);

        self::assertSame([1], iterator_to_array($removed->values()));
        self::assertFalse(isset($removed[-1]));
        self::assertFalse(isset($removed[1]));
        self::assertNull($removed[-1]);
        self::assertNull($removed[1]);
    }

    public function testSpliceWithSparseArrayKeepsInternalIterationInIndexOrder(): void
    {
        $array = new Arr(4);
        $array->offsetSet(0, new Arr('a'));
        $array->offsetSet(2, new Arr('c'));

        $array->splice(1, 0, new Arr('b'));

        self::assertSame(['a', 'b', 'c'], iterator_to_array($array->flat()->values()));
    }

    public function testSpliceWithExplicitNullDeleteCountDeletesNothing(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(1, null);

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array($array->values()));
    }

    public function testSpliceClampsStartBeyondLength(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $removed = $array->splice(10, 1, 4, 5);

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array($array->values()));
    }

    // Array.prototype.toLocaleString

    public function testToLocaleStringSkipsNullElements(): void
    {
        self::assertSame('', (new Arr(null))->toLocaleString());
        self::assertSame('1,,3', (new Arr(1, null, 3))->toLocaleString());
    }

    public function testToLocaleStringInvokesElementToLocaleString(): void
    {
        $calls = 0;
        $object = new class($calls) {
            public function __construct(private int &$calls) {}

            public function toLocaleString(): string
            {
                ++$this->calls;

                return 'ok';
            }

            public function __toString(): string
            {
                return 'string-cast';
            }
        };

        (new Arr(null, $object, null, $object, $object))->toLocaleString();

        self::assertSame(3, $calls);
    }

    public function testToLocaleStringFormatsNumbersWithLocalesAndOptions(): void
    {
        self::assertSame(
            '1,000,0.25,1',
            (new Arr(1000, 0.25, 1))->toLocaleString('en-US', ['style' => 'decimal']),
        );
    }

    public function testToLocaleStringInvokesElementToLocaleStringWithNoArguments(): void
    {
        $spy = new class {
            public array $receivedArguments = [];

            public function toLocaleString(mixed ...$arguments): string
            {
                $this->receivedArguments[] = $arguments;

                return 'ok';
            }
        };

        self::assertSame('ok', (new Arr($spy))->toLocaleString('zh', ['x' => 'y']));
        self::assertSame([[]], $spy->receivedArguments);
    }

    public function testToLocaleStringUsesStringCastForNonNumericValuesWithoutToLocaleString(): void
    {
        self::assertSame('a,b,c', (new Arr('a', 'b', 'c'))->toLocaleString());
        self::assertSame('true,false', (new Arr(true, false))->toLocaleString());
        self::assertSame('[object Object]', (new Arr(new \stdClass()))->toLocaleString());
    }

    public function testToLocaleStringStringifiesNestedIterables(): void
    {
        self::assertSame('1,2,3,4', (new Arr([1, 2], new \ArrayIterator([3, 4])))->toLocaleString('en-US'));
        self::assertSame('1,000,0.25', (new Arr([1000, 0.25]))->toLocaleString('en-US', ['style' => 'decimal']));
    }

    public function testToLocaleStringReindexesTraversablesInsteadOfPreservingDuplicateKeys(): void
    {
        $iterable = new class implements \IteratorAggregate {
            public function getIterator(): \Traversable
            {
                yield 0 => 1000;

                yield 0 => 2000;
            }
        };

        self::assertSame('1,000,2,000', (new Arr($iterable))->toLocaleString('en-US', ['style' => 'decimal']));
    }

    public function testToLocaleStringFormatsPercentStyle(): void
    {
        self::assertSame('25%,50%', (new Arr(0.25, 0.5))->toLocaleString('en-US', ['style' => 'percent']));
    }

    public function testToLocaleStringFormatsCurrencyStyle(): void
    {
        self::assertSame('$1,234.50,$56.00', (new Arr(1234.5, 56))->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'USD']));
    }

    public function testToLocaleStringCurrencyResultIsReturned(): void
    {
        self::assertSame('$1.00', (new Arr(1, 2))->slice(0, 1)->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'USD']));
    }

    public function testToLocaleStringUsesDecimalWhenCurrencyOptionHasDecimalStyle(): void
    {
        $array = new Arr();
        $array->push(1);

        self::assertSame('1', $array->toLocaleString('en-US', ['style' => 'decimal']));
        self::assertSame('1', $array->toLocaleString('en-US', ['style' => 'decimal', 'currency' => 123]));
    }

    public function testToLocaleStringReturnsConfiguredCurrencyResult(): void
    {
        self::assertSame('€1.00', (new Arr())->concat(1)->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'EUR']));
    }

    public function testToLocaleStringSupportsFractionDigitOptions(): void
    {
        self::assertSame('1.00,2.00', (new Arr(1, 2))->toLocaleString('en-US', ['minimumFractionDigits' => 2]));
        self::assertSame('1.23,5.68', (new Arr(1.234, 5.678))->toLocaleString('en-US', ['maximumFractionDigits' => 2]));
    }

    public function testToLocaleStringSupportsIntegerAndSignificantDigitOptions(): void
    {
        self::assertSame('001,002', (new Arr(1, 2))->toLocaleString('en-US', ['minimumIntegerDigits' => 3]));
        self::assertSame('23,56', (new Arr(123, 456))->toLocaleString('en-US', ['maximumIntegerDigits' => 2]));
        self::assertSame('1.50,2.70', (new Arr(1.5, 2.7))->toLocaleString('en-US', ['minimumSignificantDigits' => 3]));
        self::assertSame('123,7.89', (new Arr(123.456, 7.89))->toLocaleString('en-US', ['maximumSignificantDigits' => 3]));
    }

    public function testToLocaleStringIgnoresNonNumericNumberOptions(): void
    {
        self::assertSame('1', (new Arr())->concat(1)->toLocaleString('en-US', ['minimumFractionDigits' => '2']));
    }

    public function testToLocaleStringSupportsUseGroupingOption(): void
    {
        self::assertSame('1000,2000', (new Arr(1000, 2000))->toLocaleString('en-US', ['useGrouping' => false]));
    }

    public function testToLocaleStringSupportsUseGroupingAsInt(): void
    {
        self::assertSame('1000,2000', (new Arr(1000, 2000))->toLocaleString('en-US', ['useGrouping' => 0]));
        self::assertSame('1,000,2,000', (new Arr(1000, 2000))->toLocaleString('en-US', ['useGrouping' => 1]));
    }

    public function testToLocaleStringThrowsOnNonStringCurrency(): void
    {
        $this->expectException(NumberFormatError::class);
        $this->expectExceptionMessage('Number formatting failed');

        (new Arr(1, 100))->toLocaleString('en-US', ['style' => 'currency', 'currency' => 123]);
    }

    public function testToLocaleStringThrowsOnFormatCurrencyFailure(): void
    {
        $this->expectException(NumberFormatError::class);
        $this->expectExceptionMessage('Number formatting failed');

        (new Arr(1, 100))->toLocaleString('en-US', ['style' => 'currency', 'currency' => '@@@']);
    }

    // Array.prototype.toReversed

    public function testToReversedDoesNotMutateReceiver(): void
    {
        $array = new Arr(0, 1, 2);
        $result = $array->toReversed();

        self::assertNotSame($array, $result);
        self::assertSame([0, 1, 2], iterator_to_array($array->values()));
        self::assertSame([2, 1, 0], iterator_to_array($result->values()));
    }

    public function testToReversedReturnsNewArrayForZeroOrOneElement(): void
    {
        $zero = new Arr();
        $zeroReversed = $zero->toReversed();
        $one = new Arr('value');
        $oneReversed = $one->toReversed();

        self::assertNotSame($zero, $zeroReversed);
        self::assertSame([], iterator_to_array($zeroReversed->values()));
        self::assertNotSame($one, $oneReversed);
        self::assertSame(['value'], iterator_to_array($oneReversed->values()));
    }

    // Array.prototype.toSorted

    public function testToSortedDoesNotMutateReceiver(): void
    {
        $array = new Arr(2, 0, 1);
        $result = $array->toSorted();

        self::assertNotSame($array, $result);
        self::assertSame([2, 0, 1], iterator_to_array($array->values()));
        self::assertSame([0, 1, 2], iterator_to_array($result->values()));
    }

    public function testToSortedUsesProvidedComparator(): void
    {
        self::assertSame(
            [1, 2, 3, 4],
            iterator_to_array((new Arr(4, 3, 2, 1))->toSorted(static fn (int $a, int $b): int => $a <=> $b)->values()),
        );

        self::assertSame(
            [4, 3, 2, 1],
            iterator_to_array((new Arr(1, 2, 3, 4))->toSorted(static fn (int $a, int $b): int => $b <=> $a)->values()),
        );
    }

    public function testToSortedUsesStringComparisonByDefault(): void
    {
        self::assertSame([1, 2, 3, 4], iterator_to_array((new Arr(4, 3, 2, 1))->toSorted()->values()));
        self::assertSame([1, 2, 'a', 'z'], iterator_to_array((new Arr('a', 2, 1, 'z'))->toSorted()->values()));
        self::assertSame(
            [1, 11, 111, 2, 22, 222, 3, 33, 333],
            iterator_to_array((new Arr(333, 33, 3, 222, 22, 2, 111, 11, 1))->toSorted()->values()),
        );
    }

    public function testToSortedReturnsNewArrayForZeroOrOneElement(): void
    {
        $zero = new Arr();
        $zeroSorted = $zero->toSorted();
        $one = new Arr('value');
        $oneSorted = $one->toSorted();

        self::assertNotSame($zero, $zeroSorted);
        self::assertSame([], iterator_to_array($zeroSorted->values()));
        self::assertNotSame($one, $oneSorted);
        self::assertSame(['value'], iterator_to_array($oneSorted->values()));
    }

    public function testToSortedStopsAfterComparatorError(): void
    {
        $called = 0;

        try {
            (new Arr(1, 2, 3))->toSorted(static function () use (&$called): int {
                ++$called;

                if (1 === $called) {
                    throw new \RuntimeException('compare failed');
                }

                return 0;
            });

            self::fail('Expected comparator exception');
        } catch (\RuntimeException $exception) {
            self::assertSame('compare failed', $exception->getMessage());
        }

        self::assertSame(1, $called);
    }

    public function testToSortedMovesSparseHolesToTheEndDroppingLength(): void
    {
        $array = new Arr(4);
        $array[1] = 'b';
        $array[3] = 'a';
        $array[5] = 'c';

        $sortedArray = $array->toSorted();

        self::assertSame(6, $sortedArray->length);
        self::assertSame(['a', 'b', 'c', null, null, null], iterator_to_array($sortedArray->values()));
        self::assertTrue(isset($sortedArray[0]));
        self::assertTrue(isset($sortedArray[1]));
        self::assertTrue(isset($sortedArray[2]));
        self::assertFalse(isset($sortedArray[3]));
        self::assertFalse(isset($sortedArray[4]));
        self::assertFalse(isset($sortedArray[5]));
    }

    public function testToSortedWithDescCallbackMovesSparseHolesToTheEndDroppingLength(): void
    {
        $array = new Arr(4);
        $array[1] = 'b';
        $array[3] = 'a';
        $array[5] = 'c';

        $sortedArray = $array->toSorted(static fn ($a, $b) => $b <=> $a);

        self::assertSame(6, $sortedArray->length);
        self::assertSame(['c', 'b', 'a', null, null, null], iterator_to_array($sortedArray->values()));
        self::assertTrue(isset($sortedArray[0]));
        self::assertTrue(isset($sortedArray[1]));
        self::assertTrue(isset($sortedArray[2]));
        self::assertFalse(isset($sortedArray[3]));
        self::assertFalse(isset($sortedArray[4]));
        self::assertFalse(isset($sortedArray[5]));
    }

    // Array.prototype.toSpliced

    public function testToSplicedReturnsNewArrayEvenWhenUnmodified(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->toSpliced(1, 0);

        self::assertNotSame($array, $result);
        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
        self::assertSame([1, 2, 3], iterator_to_array($result->values()));
    }

    public function testToSplicedClampsDeleteCountBetweenZeroAndRemainingCount(): void
    {
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->toSpliced(2, -1)->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->toSpliced(-4, -1)->values()));
        self::assertSame([0, 1], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->toSpliced(2, 6)->values()));
        self::assertSame([0, 1], iterator_to_array((new Arr(0, 1, 2, 3, 4, 5))->toSpliced(-4, 6)->values()));
    }

    public function testToSplicedSupportsInsertionWithoutMutatingOriginalArray(): void
    {
        $array = new Arr(0, 1, 4, 5);
        $result = $array->toSpliced(2, 0, 2, 3);

        self::assertSame([0, 1, 4, 5], iterator_to_array($array->values()));
        self::assertSame([0, 1, 2, 3, 4, 5], iterator_to_array($result->values()));
    }

    public function testToSplicedDeletesAfterStartWhenDeleteCountIsMissing(): void
    {
        self::assertSame(['first'], iterator_to_array((new Arr('first', 'second', 'third'))->toSpliced(1)->values()));
        self::assertSame([0], iterator_to_array((new Arr(0, 1, 2, 3))->toSpliced(1)->values()));
        self::assertSame([], iterator_to_array((new Arr('first', 'second', 'third'))->toSpliced(-10)->values()));
    }

    public function testToSplicedTreatsZeroStartAsBeginning(): void
    {
        self::assertSame([1, 2, 3], iterator_to_array((new Arr(0, 1, 2, 3))->toSpliced(0, 1)->values()));
    }

    public function testToSplicedTreatsNegativeStartAsRelativeToEnd(): void
    {
        self::assertSame([0, 1, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->toSpliced(-3, 2)->values()));
    }

    public function testToSplicedClampsStartToArrayLength(): void
    {
        self::assertSame([0, 1, 2, 3, 4, 5, 6], iterator_to_array((new Arr(0, 1, 2, 3, 4))->toSpliced(10, 1, 5, 6)->values()));
    }

    public function testToSplicedTreatsStartLessThanMinusLengthAsZero(): void
    {
        self::assertSame([2, 3, 4], iterator_to_array((new Arr(0, 1, 2, 3, 4))->toSpliced(-20, 2)->values()));
    }

    public function testToSplicedWithExplicitNullDeleteCountReturnsUnchangedCopy(): void
    {
        $array = new Arr(0, 1, 2, 3);
        $result = $array->toSpliced(1, null);

        self::assertNotSame($array, $result);
        self::assertSame([0, 1, 2, 3], iterator_to_array($result->values()));
        self::assertSame([0, 1, 2, 3], iterator_to_array($array->values()));
    }

    // Array.prototype.with

    public function testWithReplacesElementAtPositiveIndex(): void
    {
        self::assertSame([1, 2, 99, 4, 5], iterator_to_array((new Arr(1, 2, 3, 4, 5))->with(2, 99)->values()));
    }

    public function testWithReplacesElementAtNegativeIndex(): void
    {
        self::assertSame([1, 2, 'x'], iterator_to_array((new Arr(1, 2, 3))->with(-1, 'x')->values()));
    }

    public function testWithDoesNotModifyOriginalArray(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->with(1, 99);

        self::assertNotSame($array, $result);
        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
        self::assertSame([1, 99, 3], iterator_to_array($result->values()));
    }

    public function testWithThrowsRangeErrorForOutOfBoundsIndex(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid index: 10');

        (new Arr(1, 2, 3))->with(10, 'x');
    }

    public function testWithThrowsRangeErrorForEmptyArray(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid index: 0');

        (new Arr())->with(0, 'x');
    }

    public function testWithReplacesHoleInSparseArray(): void
    {
        $array = new Arr(5);
        $array[2] = 'present';

        $result = $array->with(3, 'filled');

        self::assertSame('filled', $result->at(3));
    }

    // Array.prototype.toString

    public function testToStringReturnsEmptyStringForEmptyArray(): void
    {
        self::assertSame('', (new Arr())->toString());
    }

    public function testToStringUsesJoinSemantics(): void
    {
        $negativeInfinity = new Arr();
        $negativeInfinity->push(-INF);

        self::assertSame('1,2,3', (new Arr(1, 2, 3))->toString());
        self::assertSame(',,', (new Arr(3))->toString());
        self::assertSame('-Infinity', $negativeInfinity->toString());
        self::assertSame('1,2,3,4', (new Arr(new \ArrayIterator([new Arr(1, 2), new Arr(3, 4)])))->toString());
    }

    // Array.prototype.unshift

    public function testUnshiftPrependsItemsAndReturnsNewLength(): void
    {
        $array = new Arr(2, 3);

        self::assertSame(4, $array->unshift(0, 1));
        self::assertSame([0, 1, 2, 3], iterator_to_array($array->values()));
    }

    public function testUnshiftSupportsNamedArguments(): void
    {
        $array = new Arr('c');

        self::assertSame(3, $array->unshift(first: 'a', second: 'b'));
        self::assertSame(['a', 'b', 'c'], iterator_to_array($array->values()));
    }

    public function testUnshiftWithNoArgumentsKeepsLengthUnchanged(): void
    {
        $array = new Arr();
        $array->unshift(1);

        self::assertSame(1, $array->unshift());
        self::assertSame([1], iterator_to_array($array->values()));
        self::assertSame(2, $array->unshift(-1));
        self::assertSame([-1, 1], iterator_to_array($array->values()));
    }

    // Array.prototype.values

    public function testValuesReturnsIteratorForArrayValues(): void
    {
        self::assertSame(['a', 'b', 'c'], iterator_to_array((new Arr('a', 'b', 'c'))->values()));
    }

    public function testValuesWithSparseArrayYieldsNullForHoles(): void
    {
        $array = new Arr(3);
        $array->offsetSet(1, 'x');

        self::assertSame([null, 'x', null], iterator_to_array($array->values()));
    }

    public function testValuesIteratorSeesItemsAddedBeforeExhaustion(): void
    {
        $array = new Arr();
        $iterator = $array->values();
        $array->push('a');

        self::assertSame(['a'], iterator_to_array($iterator));
    }

    public function testClosureThisArgDoesNotBindStaticClosures(): void
    {
        $context = new class {
            public int $value = 3;
        };

        self::assertSame([1, 2], iterator_to_array((new Arr(1, 2))->map(static fn (int $value): int => $value, $context)->values()));
    }

    public function testNonClosureCallbackIgnoresThisArg(): void
    {
        $context = new class {
            public int $value = 99;
        };

        $callback = new class {
            public function __invoke(int $value): int
            {
                return $value;
            }
        };

        self::assertSame([1, 2], iterator_to_array((new Arr(1, 2))->map($callback, $context)->values()));
    }

    public function testClosureThisArgRebindsNonStaticClosuresToProvidedObject(): void
    {
        $source = new Dummy();
        $source->threshold = 10;

        $context = new Dummy();
        $context->threshold = 3;

        self::assertFalse((new Arr(1, 2, 3))->every($source->thresholdCallback(), $context));
    }

    // toArray

    public function testToArrayReturnsInternalDataAsArray(): void
    {
        $array = new Arr(1, 'two', null, true);

        self::assertSame([1, 'two', null, true], $array->toArray());
    }

    public function testToArrayReturnsListForSparseArray(): void
    {
        $array = new Arr();
        $array[2] = 'x';

        self::assertSame([null, null, 'x'], $array->toArray());
    }

    public function testToArrayReturnsListForSparseArrayByUnset(): void
    {
        $array = new Arr(1, 2, 3);
        unset($array[1]);

        self::assertSame([1, null, 3], $array->toArray());
    }

    public function testToArrayReturnsListForSparseArrayByOnlyProvidingItsLength(): void
    {
        $array = new Arr(5);

        self::assertSame([null, null, null, null, null], $array->toArray());
    }

    public function testToArrayRecursivelyConvertsNestedArr(): void
    {
        $nested = new Arr('a', 'b');
        $array = new Arr(1, $nested, true);

        self::assertSame([1, ['a', 'b'], true], $array->toArray());
    }
}
