<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Tests\Typescript\Stub\Dummy;
use Chubbyphp\Typescript\Arr;
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
    // Array constructor - no arguments

    public function testArrayConstructorNoArgumentsSetsLengthToZero(): void
    {
        $array = new Arr();

        self::assertCount(0, iterator_to_array($array->values()));
    }

    // Array constructor - single argument (length)

    public function testArrayConstructorWithLengthCreatesArrayWithThatManyHoles(): void
    {
        $array = new Arr(5);

        $values = iterator_to_array($array->values());
        self::assertCount(5, $values);
        self::assertSame([null, null, null, null, null], $values);
    }

    public function testArrayConstructorWithLengthZeroCreatesEmptyArray(): void
    {
        $array = new Arr(0);

        self::assertCount(0, iterator_to_array($array->values()));
    }

    public function testArrayConstructorThrowsRangeErrorForNegativeLength(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(-1);
    }

    public function testArrayConstructorThrowsRangeErrorForLengthAboveMax(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(2 ** 32);
    }

    public function testArrayConstructorThrowsRangeErrorForNonIntegerNumericArgument(): void
    {
        $this->expectException(RangeError::class);
        $this->expectExceptionMessage('Invalid array length');

        new Arr(1.5);
    }

    // Array constructor - multiple arguments

    public function testArrayConstructorWithMultipleArgumentsSetsElements(): void
    {
        $array = new Arr(0, 1, 2, 3);

        self::assertSame([0, 1, 2, 3], iterator_to_array($array->values()));
    }

    public function testArrayConstructorWithMultipleArgumentsSetsCorrectLength(): void
    {
        $array = new Arr(0, 1, 0, 1);

        self::assertCount(4, iterator_to_array($array->values()));
    }

    public function testArrayConstructorWithSingleUndefinedArgument(): void
    {
        $array = new Arr(null, null);

        self::assertCount(2, iterator_to_array($array->values()));
    }

    // Array constructor - single non-numeric argument

    public function testArrayConstructorWithSingleNonNumericArgumentCreatesSingleElementArray(): void
    {
        $array = new Arr('hello');

        self::assertSame(['hello'], iterator_to_array($array->values()));
    }

    // __toString

    public function testToStringOfEmptyArrayReturnsEmptyString(): void
    {
        $array = new Arr();

        self::assertSame('', $array->__toString());
    }

    public function testToStringOfArrayWithElementsReturnsCommaSeparatedString(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame('1,2,3', $array->__toString());
    }

    public function testToStringOfSparseArrayCommasForNullElements(): void
    {
        $array = new Arr(3);

        self::assertSame(',,', $array->__toString());
    }

    // Array.prototype.at

    public function testAtReturnsItemAtSpecifiedIndex(): void
    {
        $array = new Arr(1, 2, 3, 4, null, 5);

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
        self::assertSame(4, $array->at(3));
        self::assertNull($array->at(4));
        self::assertSame(5, $array->at(5));
    }

    public function testAtReturnsItemAtSpecifiedRelativeIndex(): void
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

    // Array.prototype.concat

    public function testConcatWithArrayArgumentsSpreadsElementsInOrder(): void
    {
        $x = new Arr();
        $y = new Arr(0, 1);
        $z = new Arr(2, 3, 4);
        $arr = $x->concat($y, $z);

        $values = iterator_to_array($arr->values());
        self::assertSame(0, $values[0]);
        self::assertSame(1, $values[1]);
        self::assertSame(2, $values[2]);
        self::assertSame(3, $values[3]);
        self::assertSame(4, $values[4]);
        self::assertCount(5, $values);
    }

    public function testConcatWithArrayObjectAndPrimitiveArguments(): void
    {
        $x = new Arr('x');
        $y = new Arr(1, 2);
        $arr = $x->concat($y, -1, true, 'NaN');

        $values = iterator_to_array($arr->values());
        self::assertSame('x', $values[0]);
        self::assertSame(1, $values[1]);
        self::assertSame(2, $values[2]);
        self::assertSame(-1, $values[3]);
        self::assertTrue($values[4]);
        self::assertSame('NaN', $values[5]);
        self::assertCount(6, $values);
    }

    public function testConcatWithNoItemsReturnsCopyOfArray(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->concat();

        $values = iterator_to_array($arr->values());
        self::assertSame(0, $values[0]);
        self::assertSame(1, $values[1]);
        self::assertCount(2, $values);
    }

    public function testConcatWithHoleyArrayPreservesHolesAsNull(): void
    {
        $x = new Arr(null, 1);
        $arr = $x->concat(new Arr(), new Arr(1));

        $values = iterator_to_array($arr->values());
        self::assertNull($values[0]);
        self::assertSame(1, $values[1]);
        self::assertNull($values[2]);
        self::assertCount(3, $values);
    }

    public function testConcatDoesNotModifyOriginalArray(): void
    {
        $a = new Arr(1, 2);
        $a->concat(new Arr(3, 4));

        self::assertSame([1, 2], iterator_to_array($a->values()));
    }

    // Array.prototype.copyWithin

    public function testCopyWithinWithNonNegativeTargetAndStartCopiesCorrectValues(): void
    {
        $array = new Arr('a', 'b', 'c', 'd', 'e', 'f');

        self::assertSame(
            ['a', 'b', 'c', 'd', 'e', 'f'],
            iterator_to_array($array->copyWithin(0, 0)->values()),
        );

        $array2 = new Arr('a', 'b', 'c', 'd', 'e', 'f');
        self::assertSame(
            ['c', 'd', 'e', 'f', 'e', 'f'],
            iterator_to_array($array2->copyWithin(0, 2)->values()),
        );

        $array3 = new Arr('a', 'b', 'c', 'd', 'e', 'f');
        self::assertSame(
            ['a', 'b', 'c', 'a', 'b', 'c'],
            iterator_to_array($array3->copyWithin(3, 0)->values()),
        );

        $array4 = new Arr(0, 1, 2, 3, 4, 5);
        self::assertSame(
            [0, 4, 5, 3, 4, 5],
            iterator_to_array($array4->copyWithin(1, 4)->values()),
        );
    }

    public function testCopyWithinWithNonNegativeTargetStartAndEndCopiesCorrectValues(): void
    {
        $array = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 1, 2, 3],
            iterator_to_array($array->copyWithin(0, 0, 0)->values()),
        );

        $array2 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 1, 2, 3],
            iterator_to_array($array2->copyWithin(0, 0, 2)->values()),
        );

        $array3 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [1, 1, 2, 3],
            iterator_to_array($array3->copyWithin(0, 1, 2)->values()),
        );

        $array4 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 0, 1, 3],
            iterator_to_array($array4->copyWithin(1, 0, 2)->values()),
        );

        $array5 = new Arr(0, 1, 2, 3, 4, 5);
        self::assertSame(
            [0, 3, 4, 3, 4, 5],
            iterator_to_array($array5->copyWithin(1, 3, 5)->values()),
        );
    }

    public function testCopyWithinWithNegativeTargetCopiesCorrectly(): void
    {
        $array = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 1, 2, 0],
            iterator_to_array($array->copyWithin(-1, 0)->values()),
        );

        $array2 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 2, 2, 3],
            iterator_to_array($array2->copyWithin(-2, 2)->values()),
        );

        $array3 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 1, 2, 2],
            iterator_to_array($array3->copyWithin(-1, 2)->values()),
        );
    }

    public function testCopyWithinWithNegativeStartCopiesCorrectly(): void
    {
        $array = new Arr(0, 1, 2, 3);
        self::assertSame(
            [3, 1, 2, 3],
            iterator_to_array($array->copyWithin(0, -1)->values()),
        );

        $array2 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 3, 4, 4],
            iterator_to_array($array2->copyWithin(2, -2)->values()),
        );

        $array3 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 3, 4, 3, 4],
            iterator_to_array($array3->copyWithin(1, -2)->values()),
        );

        $array4 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 1, 2, 2],
            iterator_to_array($array4->copyWithin(-1, -2)->values()),
        );

        $array5 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 2, 2, 3],
            iterator_to_array($array5->copyWithin(-2, -3)->values()),
        );

        $array6 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [3, 4, 2, 3, 4],
            iterator_to_array($array6->copyWithin(-5, -2)->values()),
        );
    }

    public function testCopyWithinWithNegativeEndCopiesCorrectly(): void
    {
        $array = new Arr(0, 1, 2, 3);
        self::assertSame(
            [1, 2, 2, 3],
            iterator_to_array($array->copyWithin(0, 1, -1)->values()),
        );

        $array2 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 0, 1, 2],
            iterator_to_array($array2->copyWithin(2, 0, -1)->values()),
        );

        $array3 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 2, 2, 3, 4],
            iterator_to_array($array3->copyWithin(1, 2, -2)->values()),
        );

        $array4 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [2, 1, 2, 3],
            iterator_to_array($array4->copyWithin(0, -2, -1)->values()),
        );

        $array5 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 3, 3, 4],
            iterator_to_array($array5->copyWithin(2, -2, -1)->values()),
        );

        $array6 = new Arr(0, 1, 2, 3);
        self::assertSame(
            [0, 2, 2, 3],
            iterator_to_array($array6->copyWithin(-3, -2, -1)->values()),
        );

        $array7 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [0, 1, 2, 2, 3],
            iterator_to_array($array7->copyWithin(-2, -3, -1)->values()),
        );

        $array8 = new Arr(0, 1, 2, 3, 4);
        self::assertSame(
            [3, 1, 2, 3, 4],
            iterator_to_array($array8->copyWithin(-5, -2, -1)->values()),
        );
    }

    public function testCopyWithinReturnsThis(): void
    {
        $array = new Arr();
        $result = $array->copyWithin(0, 0);

        self::assertSame($array, $result);

        $array2 = new Arr(0, 1, 2);
        $result2 = $array2->copyWithin(0, 0);

        self::assertSame($array2, $result2);
    }

    public function testCopyWithinCopiesNullValuesFromHoleySource(): void
    {
        $array = new Arr(0, 1, null, null, 1);
        $array->copyWithin(0, 1, 4);

        self::assertCount(5, iterator_to_array($array->values()));
        self::assertSame(1, $array->at(0));
        self::assertNull($array->at(1));
        self::assertNull($array->at(2));
        self::assertNull($array->at(3));
        self::assertSame(1, $array->at(4));
    }

    public function testCopyWithinWithZeroCountReturnsArrayUnmodified(): void
    {
        $array = new Arr(0, 1, 2);
        $result = $array->copyWithin(0, 3);
        self::assertSame($array, $result);
        self::assertSame([0, 1, 2], iterator_to_array($array->values()));
    }

    // Array.prototype.entries

    public function testEntriesReturnsGenerator(): void
    {
        $array = new Arr();
        $iterator = $array->entries();

        self::assertInstanceOf(\Generator::class, $iterator);
    }

    public function testEntriesYieldsKeyValuePairs(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->entries();

        self::assertSame([0, 'a'], $iterator->current());
        $iterator->next();
        self::assertSame([1, 'b'], $iterator->current());
        $iterator->next();
        self::assertSame([2, 'c'], $iterator->current());
    }

    public function testEntriesIteratesAllEntries(): void
    {
        $array = new Arr('a', 'b', 'c');
        $entries = [];

        foreach ($array->entries() as $entry) {
            $entries[] = $entry;
        }

        self::assertSame([[0, 'a'], [1, 'b'], [2, 'c']], $entries);
    }

    public function testEntriesReturnsExhaustedGeneratorForEmptyArray(): void
    {
        $array = new Arr();
        $iterator = $array->entries();

        self::assertNull($iterator->current());
    }

    public function testEntriesIterationMutableBeforeFirstNext(): void
    {
        $array = new Arr();
        $iterator = $array->entries();

        $array->push('a');

        self::assertSame([0, 'a'], $iterator->current());

        $iterator->next();
        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());

        $array->push('b');

        $iterator->next();
        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());
    }

    // Array.prototype.every

    public function testEveryReturnsTrueWhenAllElementsPass(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);

        $result = $array->every(static fn (int $value): bool => 0 < $value);

        self::assertTrue($result);
    }

    public function testEveryReturnsFalseWhenAnyElementFails(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);

        $result = $array->every(static fn (int $value): bool => 4 > $value);

        self::assertFalse($result);
    }

    public function testEveryStopsIteratingAfterFirstFalse(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 5);

        $array->every(static function (int $value) use (&$visited): bool {
            $visited[] = $value;

            return 2 !== $value;
        });

        self::assertSame([1, 2], $visited);
    }

    public function testEveryReturnsTrueForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->every(static function () use (&$called): bool {
            $called = true;

            return false;
        });

        self::assertTrue($result);
        self::assertFalse($called);
    }

    public function testEveryCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->every(static function (mixed $value, int $index, Arr $arr) use (&$captured): bool {
            $captured[] = [$value, $index, $arr];

            return true;
        });

        self::assertCount(3, $captured);
        self::assertSame('a', $captured[0][0]);
        self::assertSame(0, $captured[0][1]);
        self::assertSame($array, $captured[0][2]);
        self::assertSame('b', $captured[1][0]);
        self::assertSame(1, $captured[1][1]);
        self::assertSame($array, $captured[1][2]);
        self::assertSame('c', $captured[2][0]);
        self::assertSame(2, $captured[2][1]);
        self::assertSame($array, $captured[2][2]);
    }

    public function testEveryDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);

        $array->every(static fn (int $value): bool => 0 < $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testEveryReceivesArrayInstanceAsThirdArgument(): void
    {
        $array = new Arr(1, 2, 3);
        $captured = null;

        $array->every(static function (mixed $value, int $index, Arr $arr) use (&$captured): bool {
            $captured = $arr;

            return true;
        });

        self::assertSame($array, $captured);
    }

    public function testEveryWithThisArgBindsClosure(): void
    {
        $context = new Dummy();

        self::assertTrue((new Arr(1, 2, 3))->every($context->thresholdCallback(), $context));
    }

    // Array.prototype.fill

    public function testFillAllElementsWithValueWhenNoStartEndGiven(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8);

        self::assertSame([8, 8, 8], iterator_to_array($result->values()));
    }

    public function testFillReturnsEmptyArrayWhenArrayIsEmpty(): void
    {
        $array = new Arr();
        $result = $array->fill(8);

        self::assertSame([], iterator_to_array($result->values()));
    }

    public function testFillWithCustomStartAndEnd(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8, 1, 2);

        self::assertSame([0, 8, 0], iterator_to_array($result->values()));
    }

    public function testFillWithNegativeStart(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8, -1);

        self::assertSame([0, 0, 8], iterator_to_array($result->values()));
    }

    public function testFillWithOutOfBoundsStartDoesNothing(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8, 4);

        self::assertSame([0, 0, 0], iterator_to_array($result->values()));
    }

    public function testFillWithRelativeEnd(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8, 0, -1);

        self::assertSame([8, 8, 0], iterator_to_array($result->values()));
    }

    public function testFillWithEndBeyondLengthFillsAll(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8, 0, 5);

        self::assertSame([8, 8, 8], iterator_to_array($result->values()));
    }

    public function testFillWithNegativeStartAndPositiveEnd(): void
    {
        $array = new Arr(0, 0, 0, 0, 0);
        $result = $array->fill(8, -3, 4);

        self::assertSame([0, 0, 8, 8, 0], iterator_to_array($result->values()));
    }

    public function testFillWithNegativeStartAndNegativeEnd(): void
    {
        $array = new Arr(0, 0, 0, 0, 0);
        $result = $array->fill(8, -2, -1);

        self::assertSame([0, 0, 0, 8, 0], iterator_to_array($result->values()));
    }

    public function testFillWithStartGreaterThanEndDoesNothing(): void
    {
        $array = new Arr(0, 0, 0, 0, 0);
        $result = $array->fill(8, -1, -3);

        self::assertSame([0, 0, 0, 0, 0], iterator_to_array($result->values()));
    }

    public function testFillReturnsThis(): void
    {
        $array = new Arr(0, 0, 0);
        $result = $array->fill(8);

        self::assertSame($array, $result);
    }

    // Array.prototype.filter

    public function testFilterReturnsNewArrayWithAllElementsWhenAllPass(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->filter(static fn (int $value): bool => 0 < $value);

        self::assertSame([1, 2, 3], iterator_to_array($result->values()));
    }

    public function testFilterReturnsNewArrayWithOnlyPassingElements(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);
        $result = $array->filter(static fn (int $value): bool => 3 < $value);

        self::assertSame([4, 5], iterator_to_array($result->values()));
    }

    public function testFilterReturnsEmptyArrayWhenNoElementsPass(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->filter(static fn (int $value): bool => false);

        self::assertSame([], iterator_to_array($result->values()));
    }

    public function testFilterCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->filter(static function (mixed $value, int $index, Arr $arr) use (&$captured): bool {
            $captured[] = [$value, $index, $arr];

            return true;
        });

        self::assertCount(3, $captured);
        self::assertSame('a', $captured[0][0]);
        self::assertSame(0, $captured[0][1]);
        self::assertSame($array, $captured[0][2]);
    }

    public function testFilterReturnsNewInstanceNotOriginal(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->filter(static fn (int $value): bool => 0 < $value);

        self::assertNotSame($array, $result);
    }

    public function testFilterDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->filter(static fn (int $value): bool => 2 !== $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testFilterReturnsEmptyArrayAndDoesNotCallCallbackForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->filter(static function () use (&$called): bool {
            $called = true;

            return true;
        });

        self::assertSame([], iterator_to_array($result->values()));
        self::assertFalse($called);
    }

    public function testFilterWithThisArgBindsClosure(): void
    {
        $context = new Dummy();
        $array = new Arr(1, 2, 3, 4, 5);

        self::assertSame([1, 2], iterator_to_array($array->filter($context->limitCallback(), $context)->values()));
    }

    // Array.prototype.find

    public function testFindReturnsElementWhenPredicateMatches(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);
        $result = $array->find(static fn (int $value): bool => 3 === $value);

        self::assertSame(3, $result);
    }

    public function testFindReturnsFirstMatchingElement(): void
    {
        $array = new Arr(1, 2, 3, 4, 5);
        $result = $array->find(static fn (int $value): bool => 2 < $value);

        self::assertSame(3, $result);
    }

    public function testFindReturnsNullWhenNoElementMatches(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->find(static fn (int $value): bool => false);

        self::assertNull($result);
    }

    public function testFindShortCircuitsAfterFirstMatch(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 5);

        $array->find(static function (int $value) use (&$visited): bool {
            $visited[] = $value;

            return 3 === $value;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testFindCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->find(static function (mixed $value, int $index, Arr $arr) use (&$captured): bool {
            $captured = [$value, $index, $arr];

            return true;
        });

        self::assertSame('a', $captured[0]);
        self::assertSame(0, $captured[1]);
        self::assertSame($array, $captured[2]);
    }

    public function testFindReturnsNullAndDoesNotCallCallbackForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->find(static function () use (&$called): bool {
            $called = true;

            return true;
        });

        self::assertNull($result);
        self::assertFalse($called);
    }

    public function testFindDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->find(static fn (int $value): bool => 2 === $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testFindWithThisArgBindsClosure(): void
    {
        $context = new Dummy();

        self::assertSame(2, (new Arr(1, 2, 3))->find($context->targetCallback(), $context));
    }

    // Array.prototype.findIndex

    public function testFindIndexReturnsZeroWhenPredicateReturnsTrue(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return true;
        });

        self::assertSame(0, $result);
        self::assertSame(1, $called);
    }

    public function testFindIndexReturnsIndexWhenPredicateMatchesValue(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return 'Bike' === $val;
        });

        self::assertSame(2, $result);
        self::assertSame(3, $called);
    }

    public function testFindIndexReturnsNegativeOneWhenPredicateAlwaysReturnsFalse(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return false;
        });

        self::assertSame(-1, $result);
        self::assertSame(3, $called);
    }

    public function testFindIndexCoercesReturnValueToBoolean(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');

        $result = $array->findIndex(static fn (string $val): mixed => 'string');
        self::assertSame(0, $result);

        $result = $array->findIndex(static fn (string $val): mixed => 1);
        self::assertSame(0, $result);

        $result = $array->findIndex(static fn (string $val): mixed => -1);
        self::assertSame(0, $result);

        $result = $array->findIndex(static fn (string $val): mixed => '');
        self::assertSame(-1, $result);

        $result = $array->findIndex(static fn (string $val): mixed => 0);
        self::assertSame(-1, $result);

        $result = $array->findIndex(static fn (string $val): mixed => null);
        self::assertSame(-1, $result);
    }

    public function testFindIndexCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->findIndex(static function (mixed $value, int $index, Arr $arr) use (&$captured): bool {
            $captured = [$value, $index, $arr];

            return true;
        });

        self::assertSame('a', $captured[0]);
        self::assertSame(0, $captured[1]);
        self::assertSame($array, $captured[2]);
    }

    public function testFindIndexShortCircuitsAfterFirstMatch(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 5);

        $array->findIndex(static function (int $value) use (&$visited): bool {
            $visited[] = $value;

            return 3 === $value;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testFindIndexReturnsNegativeOneAndDoesNotCallCallbackForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->findIndex(static function () use (&$called): bool {
            $called = true;

            return true;
        });

        self::assertSame(-1, $result);
        self::assertFalse($called);
    }

    public function testFindIndexDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->findIndex(static fn (int $value): bool => 2 === $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testFindIndexWithThisArgBindsClosure(): void
    {
        $context = new Dummy();

        self::assertSame(1, (new Arr(1, 2, 3))->findIndex($context->targetCallback(), $context));
    }

    // Array.prototype.findLast

    public function testFindLastReturnsLastElementWhenPredicateReturnsTrue(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLast(static function (string $val) use (&$called): bool {
            ++$called;

            return true;
        });

        self::assertSame('Bike', $result);
        self::assertSame(1, $called);
    }

    public function testFindLastReturnsFirstMatchingFromEndWhenPredicateMatchesValue(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLast(static function (string $val) use (&$called): bool {
            ++$called;

            return 'Shoes' === $val;
        });

        self::assertSame('Shoes', $result);
        self::assertSame(3, $called);
    }

    public function testFindLastReturnsNullWhenPredicateAlwaysReturnsFalse(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLast(static function (string $val) use (&$called): bool {
            ++$called;

            return false;
        });

        self::assertNull($result);
        self::assertSame(3, $called);
    }

    public function testFindLastCoercesReturnValueToBoolean(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');

        $result = $array->findLast(static fn (string $val): mixed => 'string');
        self::assertSame('Bike', $result);

        $result = $array->findLast(static fn (string $val): mixed => 1);
        self::assertSame('Bike', $result);

        $result = $array->findLast(static fn (string $val): mixed => -1);
        self::assertSame('Bike', $result);

        $result = $array->findLast(static fn (string $val): mixed => '');
        self::assertNull($result);

        $result = $array->findLast(static fn (string $val): mixed => 0);
        self::assertNull($result);

        $result = $array->findLast(static fn (string $val): mixed => null);
        self::assertNull($result);
    }

    public function testFindLastCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->findLast(static function (mixed ...$args) use (&$results): bool {
            $results[] = $args;

            return false;
        });

        self::assertCount(3, $results);

        self::assertSame('Leo', $results[0][0]);
        self::assertSame(2, $results[0][1]);
        self::assertSame($array, $results[0][2]);

        self::assertSame('Rick', $results[1][0]);
        self::assertSame(1, $results[1][1]);
        self::assertSame($array, $results[1][2]);

        self::assertSame('Mike', $results[2][0]);
        self::assertSame(0, $results[2][1]);
        self::assertSame($array, $results[2][2]);
    }

    public function testFindLastShortCircuitsAfterFirstMatch(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 5);

        $array->findLast(static function (int $value) use (&$visited): bool {
            $visited[] = $value;

            return 3 === $value;
        });

        self::assertSame([5, 4, 3], $visited);
    }

    public function testFindLastReturnsNullAndDoesNotCallCallbackForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->findLast(static function () use (&$called): bool {
            $called = true;

            return true;
        });

        self::assertNull($result);
        self::assertFalse($called);
    }

    public function testFindLastDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->findLast(static fn (int $value): bool => 2 === $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testFindLastWithThisArgBindsClosure(): void
    {
        $context = new Dummy();

        self::assertSame(2, (new Arr(1, 2, 3))->findLast($context->targetCallback(), $context));
    }

    // Array.prototype.findLastIndex

    public function testFindLastIndexReturnsLastIndexWhenPredicateReturnsTrue(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLastIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return true;
        });

        self::assertSame(2, $result);
        self::assertSame(1, $called);
    }

    public function testFindLastIndexReturnsIndexOfFirstMatchFromEnd(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');

        $result = $array->findLastIndex(static fn (string $val): bool => 'Car' === $val);
        self::assertSame(1, $result);
    }

    public function testFindLastIndexReturnsLastIndexOfDuplicateValue(): void
    {
        $array = new Arr('a', 'b', 'c', 'b', 'a');

        $result = $array->findLastIndex(static fn (string $val): bool => 'b' === $val);
        self::assertSame(3, $result);
    }

    public function testFindLastIndexReturnsCorrectIndexWhenPredicateMatchesFirstFromEnd(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLastIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return 'Shoes' === $val;
        });

        self::assertSame(0, $result);
        self::assertSame(3, $called);
    }

    public function testFindLastIndexReturnsNegativeOneWhenPredicateAlwaysReturnsFalse(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');
        $called = 0;

        $result = $array->findLastIndex(static function (string $val) use (&$called): bool {
            ++$called;

            return false;
        });

        self::assertSame(-1, $result);
        self::assertSame(3, $called);
    }

    public function testFindLastIndexCoercesReturnValueToBoolean(): void
    {
        $array = new Arr('Shoes', 'Car', 'Bike');

        $result = $array->findLastIndex(static fn (string $val): mixed => 'string');
        self::assertSame(2, $result);

        $result = $array->findLastIndex(static fn (string $val): mixed => 1);
        self::assertSame(2, $result);

        $result = $array->findLastIndex(static fn (string $val): mixed => -1);
        self::assertSame(2, $result);

        $result = $array->findLastIndex(static fn (string $val): mixed => '');
        self::assertSame(-1, $result);

        $result = $array->findLastIndex(static fn (string $val): mixed => 0);
        self::assertSame(-1, $result);

        $result = $array->findLastIndex(static fn (string $val): mixed => null);
        self::assertSame(-1, $result);
    }

    public function testFindLastIndexCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('Mike', 'Rick', 'Leo');
        $results = [];

        $array->findLastIndex(static function (mixed ...$args) use (&$results): bool {
            $results[] = $args;

            return false;
        });

        self::assertCount(3, $results);

        self::assertSame('Leo', $results[0][0]);
        self::assertSame(2, $results[0][1]);
        self::assertSame($array, $results[0][2]);

        self::assertSame('Rick', $results[1][0]);
        self::assertSame(1, $results[1][1]);
        self::assertSame($array, $results[1][2]);

        self::assertSame('Mike', $results[2][0]);
        self::assertSame(0, $results[2][1]);
        self::assertSame($array, $results[2][2]);
    }

    public function testFindLastIndexShortCircuitsAfterFirstMatch(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3, 4, 5);

        $array->findLastIndex(static function (int $value) use (&$visited): bool {
            $visited[] = $value;

            return 3 === $value;
        });

        self::assertSame([5, 4, 3], $visited);
    }

    public function testFindLastIndexReturnsNegativeOneAndDoesNotCallCallbackForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $result = $array->findLastIndex(static function () use (&$called): bool {
            $called = true;

            return true;
        });

        self::assertSame(-1, $result);
        self::assertFalse($called);
    }

    public function testFindLastIndexDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->findLastIndex(static fn (int $value): bool => 2 === $value);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testFindLastIndexWithThisArgBindsClosure(): void
    {
        $context = new Dummy();

        self::assertSame(1, (new Arr(1, 2, 3))->findLastIndex($context->targetCallback(), $context));
    }

    // Array.prototype.flat

    public function testFlatWithDefaultDepthFlattensOneLevel(): void
    {
        $inner = new Arr(2, 3);
        $array = new Arr(1, $inner, 4);

        self::assertSame([1, 2, 3, 4], iterator_to_array($array->flat()->values()));
    }

    public function testFlatDoesNotFlattenNonArrayElements(): void
    {
        $array = new Arr(1, 'hello', 3);

        self::assertSame([1, 'hello', 3], iterator_to_array($array->flat()->values()));
    }

    public function testFlatWithDepthZeroDoesNotFlatten(): void
    {
        $inner = new Arr(2, 3);
        $array = new Arr(1, $inner, 4);

        $values = iterator_to_array($array->flat(0)->values());
        self::assertSame(1, $values[0]);
        self::assertSame($inner, $values[1]);
        self::assertSame(4, $values[2]);
        self::assertCount(3, $values);
    }

    public function testFlatWithDepthGreaterThanOneFlattensNestedArrays(): void
    {
        $inner3 = new Arr();
        $inner3->push(4);
        $inner2 = new Arr(3, $inner3);
        $inner1 = new Arr(2, $inner2);
        $array = new Arr(1, $inner1);

        $values = iterator_to_array($array->flat(2)->values());
        self::assertCount(4, $values);
        self::assertSame(1, $values[0]);
        self::assertSame(2, $values[1]);
        self::assertSame(3, $values[2]);
        self::assertSame($inner3, $values[3]);
    }

    public function testFlatWithInfinityDepthFlattensCompletely(): void
    {
        $inner2 = new Arr();
        $inner2->push(4);
        $inner1 = new Arr(3, $inner2);
        $array = new Arr(1, new Arr(2, $inner1));

        self::assertSame([1, 2, 3, 4], iterator_to_array($array->flat(PHP_INT_MAX)->values()));
    }

    public function testFlatOfEmptyArrayReturnsEmptyArray(): void
    {
        $array = new Arr();

        self::assertSame([], iterator_to_array($array->flat()->values()));
    }

    public function testFlatWithEmptyNestedArraysRemovesThem(): void
    {
        $array = new Arr(new Arr(), new Arr());

        self::assertSame([], iterator_to_array($array->flat()->values()));
    }

    public function testFlatWithMixedEmptyAndNonEmptyNestedArrays(): void
    {
        $inner = new Arr();
        $inner->push(1);
        $array = new Arr(new Arr(), $inner);

        self::assertSame([1], iterator_to_array($array->flat()->values()));
    }

    public function testFlatDoesNotMutateOriginalArray(): void
    {
        $inner = new Arr(2, 3);
        $array = new Arr(1, $inner, 4);
        $array->flat();

        $values = iterator_to_array($array->values());
        self::assertSame(1, $values[0]);
        self::assertSame($inner, $values[1]);
        self::assertSame(4, $values[2]);
        self::assertCount(3, $values);
    }

    public function testFlatReturnsNewInstance(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->flat();

        self::assertNotSame($array, $result);
    }

    public function testFlatPreservesNullElements(): void
    {
        $array = new Arr(null, 1, new Arr(null, 2));

        $values = iterator_to_array($array->flat()->values());
        self::assertNull($values[0]);
        self::assertSame(1, $values[1]);
        self::assertNull($values[2]);
        self::assertSame(2, $values[3]);
    }

    public function testFlatWithNegativeDepthDoesNotFlatten(): void
    {
        $inner = new Arr(2, 3);
        $array = new Arr(1, $inner, 4);

        $values = iterator_to_array($array->flat(-1)->values());
        self::assertSame(1, $values[0]);
        self::assertSame($inner, $values[1]);
        self::assertSame(4, $values[2]);
        self::assertCount(3, $values);
    }

    public function testFlatPreservesOriginalValuesWhenNoNesting(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame([1, 2, 3], iterator_to_array($array->flat()->values()));
    }

    // Array.prototype.flatMap

    public function testFlatMapReturnsMappedAndFlattenedResult(): void
    {
        $array = new Arr(1, 2);
        $result = $array->flatMap(static fn (int $value): Arr => new Arr($value, $value * 2));

        self::assertSame([1, 2, 2, 4], iterator_to_array($result->values()));
    }

    public function testFlatMapWithNonArrayReturnMaintainsElements(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->flatMap(static fn (int $value): int => $value * 2);

        self::assertSame([2, 4, 6], iterator_to_array($result->values()));
    }

    public function testFlatMapFlattensOnlyOneLevelDeep(): void
    {
        $inner = new Arr();
        $inner->push(2);
        $array = new Arr(1, 3);

        $result = $array->flatMap(static fn (int $value): Arr => new Arr(new Arr($value)));

        $values = iterator_to_array($result->values());
        self::assertCount(2, $values);
        self::assertInstanceOf(Arr::class, $values[0]);
        self::assertInstanceOf(Arr::class, $values[1]);
    }

    public function testFlatMapCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b');
        $captured = [];

        $array->flatMap(static function (mixed $value, int $index, Arr $arr) use (&$captured): Arr {
            $captured[] = [$value, $index, $arr];
            $result = new Arr();
            $result->push($value);

            return $result;
        });

        self::assertCount(2, $captured);
        self::assertSame('a', $captured[0][0]);
        self::assertSame(0, $captured[0][1]);
        self::assertSame($array, $captured[0][2]);
        self::assertSame('b', $captured[1][0]);
        self::assertSame(1, $captured[1][1]);
        self::assertSame($array, $captured[1][2]);
    }

    public function testFlatMapReturnsNewInstance(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->flatMap(static function (int $value): Arr {
            $r = new Arr();
            $r->push($value);

            return $r;
        });

        self::assertNotSame($array, $result);
    }

    public function testFlatMapDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2);
        $array->flatMap(static fn (int $value): Arr => new Arr($value, $value * 2));

        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    public function testFlatMapReturnsEmptyArrayForEmptyArray(): void
    {
        $array = new Arr();
        $result = $array->flatMap(static fn (mixed $value): mixed => $value);

        self::assertSame([], iterator_to_array($result->values()));
    }

    public function testFlatMapCallbackIsCalledForEachElementInOrder(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3);

        $array->flatMap(static function (int $value) use (&$visited): Arr {
            $visited[] = $value;
            $r = new Arr();
            $r->push($value);

            return $r;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testFlatMapPreservesNullElements(): void
    {
        $array = new Arr(null, 1);
        $result = $array->flatMap(static function (?int $value): Arr {
            $r = new Arr();
            $r->push($value);

            return $r;
        });

        $values = iterator_to_array($result->values());
        self::assertNull($values[0]);
        self::assertSame(1, $values[1]);
        self::assertCount(2, $values);
    }

    public function testFlatMapWithThisArgBindsClosure(): void
    {
        $context = new Dummy();
        $array = new Arr('a', 'b');

        $result = $array->flatMap($context->suffixCallback(), $context);

        self::assertSame(['a!', 'b!'], iterator_to_array($result->values()));
    }

    public function testFlatMapWithMultipleReturnedElementsSpreadsThem(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->flatMap(static fn (int $value): Arr => new Arr($value, $value, $value));

        self::assertSame([1, 1, 1, 2, 2, 2, 3, 3, 3], iterator_to_array($result->values()));
    }

    // Array.prototype.forEach

    public function testForEachCallsCallbackForEachElement(): void
    {
        $array = new Arr(1, 2, 3);
        $visited = [];

        $array->forEach(static function (int $value) use (&$visited): void {
            $visited[] = $value;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testForEachCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->forEach(static function (mixed $value, int $index, Arr $arr) use (&$captured): void {
            $captured[] = [$value, $index, $arr];
        });

        self::assertCount(3, $captured);
        self::assertSame('a', $captured[0][0]);
        self::assertSame(0, $captured[0][1]);
        self::assertSame($array, $captured[0][2]);
        self::assertSame('b', $captured[1][0]);
        self::assertSame(1, $captured[1][1]);
        self::assertSame($array, $captured[1][2]);
        self::assertSame('c', $captured[2][0]);
        self::assertSame(2, $captured[2][1]);
        self::assertSame($array, $captured[2][2]);
    }

    public function testForEachDoesNotMutateArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->forEach(static function (int $value): void {});

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testForEachDoesNothingForEmptyArray(): void
    {
        $array = new Arr();

        $called = false;
        $array->forEach(static function () use (&$called): void {
            $called = true;
        });

        self::assertFalse($called);
    }

    public function testForEachReturnsVoid(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->forEach(static function (int $value): void {});

        self::assertNull($result);
    }

    public function testForEachWithThisArgBindsClosure(): void
    {
        $context = new Dummy();
        $array = new Arr(1, 2, 3);

        $array->forEach($context->visitedCallback(), $context);

        self::assertSame([1, 2, 3], $context->visited);
    }

    // Array.prototype.includes

    public function testIncludesReturnsTrueWhenElementFound(): void
    {
        $array = new Arr(42, 'test262', null, true, false, 0, -1, '');

        self::assertTrue($array->includes(42));
        self::assertTrue($array->includes('test262'));
        self::assertTrue($array->includes(null));
        self::assertTrue($array->includes(true));
        self::assertTrue($array->includes(false));
        self::assertTrue($array->includes(0));
        self::assertTrue($array->includes(-1));
        self::assertTrue($array->includes(''));
    }

    public function testIncludesReturnsFalseWhenElementNotFound(): void
    {
        self::assertFalse((new Arr(42))->includes(43));
        self::assertFalse((new Arr('test262'))->includes('test'));
        self::assertFalse((new Arr(0, 'test262', null))->includes(''));
        self::assertFalse((new Arr('true', false))->includes(true));
        self::assertFalse((new Arr('', true))->includes(false));
        self::assertFalse((new Arr(null, false, 0, 1))->includes(10));
    }

    public function testIncludesWithObjectComparesByReference(): void
    {
        $obj = new \stdClass();
        $array = new Arr($obj);

        self::assertTrue($array->includes($obj));
        self::assertFalse($array->includes(new \stdClass()));
    }

    public function testIncludesFindsNaN(): void
    {
        $array = new Arr(42, 0, 1, NAN);

        self::assertTrue($array->includes(NAN));
    }

    public function testIncludesWithNegativeZeroFindsZero(): void
    {
        $array = new Arr(42, 0, 1);

        self::assertTrue($array->includes(-0));
    }

    public function testIncludesWithPositiveFromIndexReturnsTrueWhenFoundAtOrAfter(): void
    {
        $array = new Arr('a', 'b', 'c');

        self::assertTrue($array->includes('a', 0));
        self::assertFalse($array->includes('a', 1));
        self::assertFalse($array->includes('a', 2));

        self::assertTrue($array->includes('b', 0));
        self::assertTrue($array->includes('b', 1));
        self::assertFalse($array->includes('b', 2));

        self::assertTrue($array->includes('c', 0));
        self::assertTrue($array->includes('c', 1));
        self::assertTrue($array->includes('c', 2));
    }

    public function testIncludesWithNegativeFromIndex(): void
    {
        $array = new Arr('a', 'b', 'c');

        self::assertFalse($array->includes('a', -1));
        self::assertFalse($array->includes('a', -2));
        self::assertTrue($array->includes('a', -3));
        self::assertTrue($array->includes('a', -4));

        self::assertFalse($array->includes('b', -1));
        self::assertTrue($array->includes('b', -2));
        self::assertTrue($array->includes('b', -3));
        self::assertTrue($array->includes('b', -4));

        self::assertTrue($array->includes('c', -1));
        self::assertTrue($array->includes('c', -2));
        self::assertTrue($array->includes('c', -3));
        self::assertTrue($array->includes('c', -4));
    }

    public function testIncludesFromIndexEqualToLengthReturnsFalse(): void
    {
        $array = new Arr(7, 7, 7, 7);

        self::assertFalse($array->includes(7, 4));
        self::assertFalse($array->includes(7, 5));
    }

    public function testIncludesWithNoArgumentSearchesForNull(): void
    {
        self::assertFalse((new Arr(0))->includes());
        self::assertTrue((new Arr(null))->includes());
    }

    public function testIncludesNegativeFromIndexBelowZeroStartFromZero(): void
    {
        $array = new Arr(42, 43);

        self::assertTrue($array->includes(42, -10));
        self::assertTrue($array->includes(43, -10));
    }

    // Array.prototype.indexOf

    public function testIndexOfReturnsCorrectIndexWhenElementFound(): void
    {
        $array = new Arr(42, 'test262', null, true, false, 0, -1, '');

        self::assertSame(0, $array->indexOf(42));
        self::assertSame(1, $array->indexOf('test262'));
        self::assertSame(2, $array->indexOf(null));
        self::assertSame(3, $array->indexOf(true));
        self::assertSame(4, $array->indexOf(false));
        self::assertSame(5, $array->indexOf(0));
        self::assertSame(6, $array->indexOf(-1));
        self::assertSame(7, $array->indexOf(''));
    }

    public function testIndexOfReturnsNegativeOneWhenElementNotFound(): void
    {
        self::assertSame(-1, (new Arr(42))->indexOf(43));
        self::assertSame(-1, (new Arr('test262'))->indexOf('test'));
        self::assertSame(-1, (new Arr(0, 'test262', null))->indexOf(''));
        self::assertSame(-1, (new Arr('true', false))->indexOf(true));
        self::assertSame(-1, (new Arr('', true))->indexOf(false));
        self::assertSame(-1, (new Arr(null, false, 0, 1))->indexOf(10));
    }

    public function testIndexOfWithObjectComparesByReference(): void
    {
        $obj = new \stdClass();
        $array = new Arr($obj);

        self::assertSame(0, $array->indexOf($obj));
        self::assertSame(-1, $array->indexOf(new \stdClass()));
    }

    public function testIndexOfDoesNotFindNaN(): void
    {
        $array = new Arr(42, 0, 1, NAN);

        self::assertSame(-1, $array->indexOf(NAN));
    }

    public function testIndexOfFindsNegativeZeroAsZero(): void
    {
        $array = new Arr(42, 0, 1);

        self::assertSame(1, $array->indexOf(-0));
    }

    public function testIndexOfReturnsFirstMatchOnly(): void
    {
        $array = new Arr(1, 2, 3, 2, 1);

        self::assertSame(1, $array->indexOf(2));
    }

    public function testIndexOfWithPositiveFromIndex(): void
    {
        $array = new Arr('a', 'b', 'c');

        self::assertSame(0, $array->indexOf('a', 0));
        self::assertSame(-1, $array->indexOf('a', 1));
        self::assertSame(-1, $array->indexOf('a', 2));
        self::assertSame(1, $array->indexOf('b', 0));
        self::assertSame(1, $array->indexOf('b', 1));
        self::assertSame(-1, $array->indexOf('b', 2));
        self::assertSame(2, $array->indexOf('c', 0));
        self::assertSame(2, $array->indexOf('c', 1));
        self::assertSame(2, $array->indexOf('c', 2));
    }

    public function testIndexOfWithNegativeFromIndex(): void
    {
        $array = new Arr('a', 'b', 'c');

        self::assertSame(-1, $array->indexOf('a', -1));
        self::assertSame(-1, $array->indexOf('a', -2));
        self::assertSame(0, $array->indexOf('a', -3));
        self::assertSame(0, $array->indexOf('a', -4));
        self::assertSame(-1, $array->indexOf('b', -1));
        self::assertSame(1, $array->indexOf('b', -2));
        self::assertSame(1, $array->indexOf('b', -3));
        self::assertSame(1, $array->indexOf('b', -4));
        self::assertSame(2, $array->indexOf('c', -1));
        self::assertSame(2, $array->indexOf('c', -2));
        self::assertSame(2, $array->indexOf('c', -3));
        self::assertSame(2, $array->indexOf('c', -4));
    }

    public function testIndexOfFromIndexEqualToLengthReturnsNegativeOne(): void
    {
        $array = new Arr(7, 7, 7, 7);

        self::assertSame(-1, $array->indexOf(7, 4));
        self::assertSame(-1, $array->indexOf(7, 5));
    }

    public function testIndexOfWithNoArgumentSearchesForNull(): void
    {
        self::assertSame(-1, (new Arr(0))->indexOf());
        self::assertSame(0, (new Arr(null))->indexOf());
    }

    public function testIndexOfNegativeFromIndexBelowZeroStartFromZero(): void
    {
        $array = new Arr(42, 43);

        self::assertSame(0, $array->indexOf(42, -10));
        self::assertSame(1, $array->indexOf(43, -10));
    }

    // Array.prototype.join

    public function testJoinReturnsEmptyStringForEmptyArray(): void
    {
        $array = new Arr();

        self::assertSame('', $array->join());
    }

    public function testJoinWithDefaultSeparator(): void
    {
        $array = new Arr(0, 1, 2, 3);

        self::assertSame('0,1,2,3', $array->join());
    }

    public function testJoinWithCustomStringSeparator(): void
    {
        $array = new Arr(0, 1, 2, 3);

        self::assertSame('0|1|2|3', $array->join('|'));
    }

    public function testJoinWithEmptyStringSeparator(): void
    {
        $array = new Arr(0, 1, 2, 3);

        self::assertSame('0123', $array->join(''));
    }

    public function testJoinWithSingleElement(): void
    {
        $array = new Arr();
        $array->push(42);

        self::assertSame('42', $array->join());
        self::assertSame('42', $array->join('-'));
    }

    public function testJoinConvertsNullElementsToEmptyString(): void
    {
        $array = new Arr(null, null, null);

        self::assertSame(',,', $array->join());
    }

    public function testJoinConvertsBooleanElementsToString(): void
    {
        $array = new Arr(true, false);

        self::assertSame('true,false', $array->join());
    }

    public function testJoinConvertsNanToString(): void
    {
        $array = new Arr();
        $array->push(NAN);

        self::assertSame('NaN', $array->join());
    }

    public function testJoinConvertsInfinityToString(): void
    {
        $array = new Arr(INF, -INF);

        self::assertSame('Infinity,-Infinity', $array->join());
    }

    public function testJoinConvertsNonStringableObjectToString(): void
    {
        $array = new Arr();
        $array->push(new \stdClass());

        self::assertSame('[object Object]', $array->join());
    }

    public function testJoinWithMixedTypes(): void
    {
        $array = new Arr(1, 'hello', true, null, 3.14);

        self::assertSame('1,hello,true,,3.14', $array->join());
    }

    public function testJoinWithNestedArr(): void
    {
        $inner = new Arr();
        $inner->push(2);
        $inner->push(3);
        $array = new Arr(1, $inner, 4);

        self::assertSame('1,2,3,4', $array->join());
    }

    public function testJoinWithArrayElement(): void
    {
        $array = new Arr(1, [2, 3], 4);

        self::assertSame('1,2,3,4', $array->join());
    }

    public function testJoinSeparatorNotPropagatedToNestedArr(): void
    {
        $inner = new Arr();
        $inner->push(2);
        $inner->push(3);
        $array = new Arr(1, $inner, 4);

        self::assertSame('1|2,3|4', $array->join('|'));
    }

    // Array.prototype.keys

    public function testKeysReturnsGenerator(): void
    {
        $array = new Arr();
        $iterator = $array->keys();

        self::assertInstanceOf(\Generator::class, $iterator);
    }

    public function testKeysYieldsIndices(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->keys();

        self::assertSame(0, $iterator->current());
        $iterator->next();
        self::assertSame(1, $iterator->current());
        $iterator->next();
        self::assertSame(2, $iterator->current());
    }

    public function testKeysIteratesAllKeys(): void
    {
        $array = new Arr('a', 'b', 'c');
        $keys = [];

        foreach ($array->keys() as $key) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2], $keys);
    }

    public function testKeysReturnsExhaustedGeneratorForEmptyArray(): void
    {
        $array = new Arr();
        $iterator = $array->keys();

        self::assertNull($iterator->current());
    }

    public function testKeysIterationMutableBeforeFirstNext(): void
    {
        $array = new Arr();
        $iterator = $array->keys();

        $array->push('a');

        self::assertSame(0, $iterator->current());

        $iterator->next();
        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());

        $array->push('b');

        $iterator->next();
        self::assertNull($iterator->current());
        self::assertFalse($iterator->valid());
    }

    // Array.prototype.lastIndexOf

    public function testLastIndexOfReturnsCorrectIndexWhenElementFound(): void
    {
        $array = new Arr(1, 2, 3, 2, 1);

        self::assertSame(3, $array->lastIndexOf(2));
    }

    public function testLastIndexOfReturnsNegativeOneWhenElementNotFound(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(-1, $array->lastIndexOf(4));
    }

    public function testLastIndexOfWithObjectComparesByReference(): void
    {
        $obj1 = new \stdClass();
        $obj2 = new \stdClass();
        $array = new Arr($obj1, $obj2);

        self::assertSame(1, $array->lastIndexOf($obj2));
        self::assertSame(-1, $array->lastIndexOf(new \stdClass()));
    }

    public function testLastIndexOfDoesNotFindNaN(): void
    {
        $array = new Arr();
        $array->push(NAN);

        self::assertSame(-1, $array->lastIndexOf(NAN));
    }

    public function testLastIndexOfFindsNegativeZeroAsZero(): void
    {
        $array = new Arr();
        $array->push(0);
        $array->push(42);

        self::assertSame(0, $array->lastIndexOf(-0));
    }

    public function testLastIndexOfReturnsLastMatchOnly(): void
    {
        $array = new Arr(1, 2, 3, 2, 1);

        self::assertSame(3, $array->lastIndexOf(2));
        self::assertNotSame(1, $array->lastIndexOf(2));
    }

    public function testLastIndexOfWithPositiveFromIndex(): void
    {
        $array = new Arr(1, 2, 3, 2, 1);

        self::assertSame(1, $array->lastIndexOf(2, 2));
    }

    public function testLastIndexOfWithNegativeFromIndex(): void
    {
        $array = new Arr(1, 2, 3, 2, 1);

        self::assertSame(3, $array->lastIndexOf(2, -2));
        self::assertSame(1, $array->lastIndexOf(2, -3));
    }

    public function testLastIndexOfSearchesEntireArrayWhenFromIndexExceedsLength(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(0, $array->lastIndexOf(1, 10));
        self::assertSame(2, $array->lastIndexOf(3, 10));
    }

    public function testLastIndexOfWithFromIndexLessThanNegativeLengthReturnsNegativeOne(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(-1, $array->lastIndexOf(1, -10));
        self::assertSame(-1, $array->lastIndexOf(2, -10));
    }

    public function testLastIndexOfWithNoArgumentSearchesForNull(): void
    {
        $array = new Arr(null, 42);

        self::assertSame(0, $array->lastIndexOf());
    }

    public function testLastIndexOfReturnsNegativeOneForEmptyArray(): void
    {
        $array = new Arr();

        self::assertSame(-1, $array->lastIndexOf(1));
    }

    // Array.prototype.map

    public function testMapReturnsArrayWithTransformedValues(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->map(static fn (int $value): int => $value * 2);

        self::assertSame([2, 4, 6], iterator_to_array($result->values()));
    }

    public function testMapReturnsArrayWithSameLengthAsOriginal(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->map(static fn (int $value): string => (string) $value);

        self::assertCount(3, iterator_to_array($result->values()));
    }

    public function testMapCallbackReceivesValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $captured = [];

        $array->map(static function (mixed $value, int $index, Arr $arr) use (&$captured): string {
            $captured[] = [$value, $index, $arr];

            return (string) $value;
        });

        self::assertCount(3, $captured);
        self::assertSame('a', $captured[0][0]);
        self::assertSame(0, $captured[0][1]);
        self::assertSame($array, $captured[0][2]);
        self::assertSame('b', $captured[1][0]);
        self::assertSame(1, $captured[1][1]);
        self::assertSame($array, $captured[1][2]);
        self::assertSame('c', $captured[2][0]);
        self::assertSame(2, $captured[2][1]);
        self::assertSame($array, $captured[2][2]);
    }

    public function testMapReturnsNewArrayNotOriginal(): void
    {
        $array = new Arr(1, 2, 3);
        $result = $array->map(static fn (int $value): int => $value);

        self::assertNotSame($array, $result);
    }

    public function testMapDoesNotMutateOriginalArray(): void
    {
        $array = new Arr(1, 2, 3);
        $array->map(static fn (int $value): int => $value * 2);

        self::assertSame([1, 2, 3], iterator_to_array($array->values()));
    }

    public function testMapReturnsEmptyArrayForEmptyArray(): void
    {
        $array = new Arr();
        $result = $array->map(static fn (mixed $value): mixed => $value);

        self::assertSame([], iterator_to_array($result->values()));
    }

    public function testMapCallbackIsCalledForEachElementInOrder(): void
    {
        $visited = [];
        $array = new Arr(1, 2, 3);

        $array->map(static function (int $value) use (&$visited): int {
            $visited[] = $value;

            return $value;
        });

        self::assertSame([1, 2, 3], $visited);
    }

    public function testMapPreservesNullElementsThroughMapping(): void
    {
        $array = new Arr(null, 1, null, 2);
        $result = $array->map(static fn (?int $value): ?int => null === $value ? -1 : $value * 2);

        $values = iterator_to_array($result->values());
        self::assertSame(-1, $values[0]);
        self::assertSame(2, $values[1]);
        self::assertSame(-1, $values[2]);
        self::assertSame(4, $values[3]);
    }

    public function testMapWithThisArgBindsClosure(): void
    {
        $context = new Dummy();
        $array = new Arr(1, 2, 3);

        $result = $array->map($context->multiplierCallback(), $context);

        self::assertSame([2, 4, 6], iterator_to_array($result->values()));
    }

    // Array.prototype.pop

    public function testPopReturnsLastElementAndRemovesIt(): void
    {
        $array = new Arr(1, 2, 3);

        self::assertSame(3, $array->pop());
        self::assertSame([1, 2], iterator_to_array($array->values()));
    }

    public function testPopReturnsNullForEmptyArray(): void
    {
        $array = new Arr();

        self::assertNull($array->pop());
    }

    public function testPopDecreasesLengthAfterEachCall(): void
    {
        $array = new Arr('a', 'b', 'c');

        self::assertSame('c', $array->pop());
        self::assertSame('b', $array->pop());
        self::assertSame('a', $array->pop());
        self::assertNull($array->pop());
    }

    public function testPopModifiesArrayInPlace(): void
    {
        $array = new Arr(1, 2, 3);

        $array->pop();
        $array->push(4);

        self::assertSame([1, 2, 4], iterator_to_array($array->values()));
    }

    // Array.prototype.push

    public function testPushAppendsOneArgumentAndReturnsNewLength(): void
    {
        $x = new Arr();
        $push = $x->push(1);

        self::assertSame(1, $push);
        self::assertSame(1, $x->at(0));

        $push = $x->push();
        self::assertSame(1, $push);
        self::assertNull($x->at(1));

        $push = $x->push(-1);
        self::assertSame(2, $push);
        self::assertSame(-1, $x->at(1));
        self::assertCount(2, iterator_to_array($x->values()));
    }

    public function testPushWithManyArgumentsAppendsAllAndReturnsLength(): void
    {
        $x = new Arr(0, 0);
        $push = $x->push(true, -1, 'NaN', '1');

        $values = iterator_to_array($x->values());
        self::assertSame(6, $push);
        self::assertSame(0, $values[0]);
        self::assertSame(0, $values[1]);
        self::assertTrue($values[2]);
        self::assertSame(-1, $values[3]);
        self::assertSame('NaN', $values[4]);
        self::assertSame('1', $values[5]);
        self::assertCount(6, $values);
    }

    public function testPushModifiesArrayInPlace(): void
    {
        $x = new Arr('a', 'b');
        $x->push('c', 'd');

        $values = iterator_to_array($x->values());
        self::assertSame(['a', 'b', 'c', 'd'], $values);
    }

    public function testPushOnEmptyArrayReturnsCorrectLength(): void
    {
        $x = new Arr();

        self::assertSame(0, $x->push());
        self::assertSame(1, $x->push('first'));
        self::assertSame(2, $x->push('second'));
    }

    // Array.prototype.reduce

    public function testReduceWithoutInitialValueSumsArray(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value);

        self::assertSame(10, $result);
    }

    public function testReduceWithInitialValue(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value, 10);

        self::assertSame(16, $result);
    }

    public function testReduceWithoutInitialValueOnEmptyArrayThrowsTypeError(): void
    {
        $array = new Arr();

        $this->expectException(\TypeError::class);

        $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value);
    }

    public function testReduceWithInitialValueOnEmptyArrayReturnsInitialValue(): void
    {
        $array = new Arr();

        $result = $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value, 0);

        self::assertSame(0, $result);
    }

    public function testReduceWithSingleElementWithoutInitialValueReturnsElement(): void
    {
        $array = new Arr();
        $array->push(42);

        $result = $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value);

        self::assertSame(42, $result);
    }

    public function testReduceWithSingleElementWithInitialValueCallsCallback(): void
    {
        $array = new Arr();
        $array->push(42);

        $result = $array->reduce(static fn (int $accumulator, int $value): int => $accumulator + $value, 10);

        self::assertSame(52, $result);
    }

    public function testReduceCallbackReceivesAccumulatorValueIndexAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $received = [];

        $array->reduce(static function (mixed $accumulator, mixed $value, int $index, Arr $arr) use (&$received): string {
            $received[] = [$accumulator, $value, $index, $arr];

            return $accumulator.$value;
        }, '');

        self::assertCount(3, $received);
        self::assertSame(['', 'a', 0, $array], $received[0]);
        self::assertSame(['a', 'b', 1, $array], $received[1]);
        self::assertSame(['ab', 'c', 2, $array], $received[2]);
    }

    public function testReduceReturnsAccumulatedString(): void
    {
        $array = new Arr('a', 'b', 'c');

        $result = $array->reduce(static fn (string $accumulator, string $value): string => $accumulator.$value);

        self::assertSame('abc', $result);
    }

    // Array.prototype.reduceRight

    public function testReduceRightWithoutInitialValueSumsArray(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value);

        self::assertSame(10, $result);
    }

    public function testReduceRightWithInitialValue(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value, 10);

        self::assertSame(16, $result);
    }

    public function testReduceRightWithoutInitialValueOnEmptyArrayThrowsTypeError(): void
    {
        $array = new Arr();

        $this->expectException(\TypeError::class);

        $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value);
    }

    public function testReduceRightWithInitialValueOnEmptyArrayReturnsInitialValue(): void
    {
        $array = new Arr();

        $result = $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value, 0);

        self::assertSame(0, $result);
    }

    public function testReduceRightWithSingleElementWithoutInitialValueReturnsElement(): void
    {
        $array = new Arr();
        $array->push(42);

        $result = $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value);

        self::assertSame(42, $result);
    }

    public function testReduceRightWithSingleElementWithInitialValueCallsCallback(): void
    {
        $array = new Arr();
        $array->push(42);

        $result = $array->reduceRight(static fn (int $accumulator, int $value): int => $accumulator + $value, 10);

        self::assertSame(52, $result);
    }

    public function testReduceRightCallbackReceivesAccumulatorValueIndexInReverse(): void
    {
        $array = new Arr('a', 'b', 'c');
        $received = [];

        $array->reduceRight(static function (mixed $accumulator, mixed $value, int $index, Arr $arr) use (&$received): string {
            $received[] = [$accumulator, $value, $index, $arr];

            return $accumulator.$value;
        }, '');

        self::assertCount(3, $received);
        self::assertSame(['', 'c', 2, $array], $received[0]);
        self::assertSame(['c', 'b', 1, $array], $received[1]);
        self::assertSame(['cb', 'a', 0, $array], $received[2]);
    }

    public function testReduceRightReturnsReversedString(): void
    {
        $array = new Arr('a', 'b', 'c');

        $result = $array->reduceRight(static fn (string $accumulator, string $value): string => $accumulator.$value);

        self::assertSame('cba', $result);
    }

    // Array.prototype.reverse

    public function testReverseReturnsSelf(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->reverse();

        self::assertSame($array, $result);
    }

    public function testReverseReversesElements(): void
    {
        $array = new Arr(1, 2, 3);

        $array->reverse();

        self::assertSame(3, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(1, $array->at(2));
    }

    public function testReverseOnEmptyArray(): void
    {
        $array = new Arr();

        $array->reverse();

        self::assertSame(0, iterator_count($array->values()));
    }

    public function testReverseOnSingleElement(): void
    {
        $array = new Arr();
        $array->push(42);

        $array->reverse();

        self::assertSame(42, $array->at(0));
    }

    // Array.prototype.shift

    public function testShiftRemovesFirstElementAndReturnsIt(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->shift();

        self::assertSame(1, $result);
        self::assertSame(2, $array->at(0));
        self::assertSame(3, $array->at(1));
    }

    public function testShiftOnEmptyArrayReturnsNull(): void
    {
        $array = new Arr();

        $result = $array->shift();

        self::assertNull($result);
    }

    public function testShiftDecreasesLength(): void
    {
        $array = new Arr(1, 2, 3);

        $array->shift();

        self::assertSame(2, iterator_count($array->values()));
    }

    public function testShiftOnSingleElementMakesArrayEmpty(): void
    {
        $array = new Arr();
        $array->push(42);

        $array->shift();

        self::assertSame(0, iterator_count($array->values()));
    }

    // Array.prototype.slice

    public function testSliceWithoutArgumentsReturnsCopy(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->slice();

        self::assertNotSame($array, $result);
        self::assertSame(1, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(3, $result->at(2));
        self::assertSame(3, iterator_count($result->values()));
    }

    public function testSliceWithStartIndex(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->slice(2);

        self::assertSame(3, $result->at(0));
        self::assertSame(4, $result->at(1));
    }

    public function testSliceWithStartAndEnd(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->slice(1, 3);

        self::assertSame(2, $result->at(0));
        self::assertSame(3, $result->at(1));
    }

    public function testSliceWithNegativeStart(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->slice(-2);

        self::assertSame(3, $result->at(0));
        self::assertSame(4, $result->at(1));
    }

    public function testSliceWithNegativeEnd(): void
    {
        $array = new Arr(1, 2, 3, 4);

        $result = $array->slice(0, -1);

        self::assertSame(1, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(3, $result->at(2));
    }

    public function testSliceDoesNotMutateOriginal(): void
    {
        $array = new Arr(1, 2, 3);

        $array->slice(1);

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
    }

    public function testSliceReturnsEmptyArrayWhenStartIsGreaterThanLength(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->slice(10);

        self::assertSame(0, iterator_count($result->values()));
    }

    public function testSliceWithStartEqualToEndReturnsEmpty(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->slice(1, 1);

        self::assertSame(0, iterator_count($result->values()));
    }

    public function testSliceWithEndGreaterThanLengthClampsToLength(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->slice(0, 10);

        self::assertSame(1, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(3, $result->at(2));
    }

    // Array.prototype.some

    public function testSomeReturnsTrueWhenElementPasses(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->some(static fn (int $value): bool => 0 === $value % 2);

        self::assertTrue($result);
    }

    public function testSomeReturnsFalseWhenNoElementPasses(): void
    {
        $array = new Arr(1, 3, 5);

        $result = $array->some(static fn (int $value): bool => 0 === $value % 2);

        self::assertFalse($result);
    }

    public function testSomeStopsIteratingAfterFirstMatch(): void
    {
        $calledCount = 0;

        $array = new Arr(1, 2, 3, 4, 5);

        $array->some(static function (int $value) use (&$calledCount): bool {
            ++$calledCount;

            return 0 === $value % 2;
        });

        self::assertSame(2, $calledCount);
    }

    public function testSomeOnEmptyArrayReturnsFalse(): void
    {
        $array = new Arr();

        $result = $array->some(static fn (): bool => true);

        self::assertFalse($result);
    }

    public function testSomeCallbackReceivesValueKeyAndArray(): void
    {
        $array = new Arr('a', 'b', 'c');
        $received = [];

        $array->some(static function (mixed $value, int $key, Arr $arr) use (&$received): bool {
            $received[] = [$value, $key, $arr];

            return false;
        });

        self::assertCount(3, $received);
        self::assertSame(['a', 0, $array], $received[0]);
        self::assertSame(['b', 1, $array], $received[1]);
        self::assertSame(['c', 2, $array], $received[2]);
    }

    public function testSomeWithThisArgBindsCallback(): void
    {
        $dummy = new Dummy();
        $array = new Arr(1, 2, 3);

        $result = $array->some($dummy->targetCallback(), $dummy);

        self::assertTrue($result);
    }

    // Array.prototype.sort

    public function testSortWithoutCallbackSortsLexicographically(): void
    {
        $array = new Arr(1, 2, 10, 9);

        $array->sort();

        self::assertSame(1, $array->at(0));
        self::assertSame(10, $array->at(1));
        self::assertSame(2, $array->at(2));
        self::assertSame(9, $array->at(3));
    }

    public function testSortWithCallbackSortsNumerically(): void
    {
        $array = new Arr(3, 1, 2);

        $array->sort(static fn (int $a, int $b): int => $a <=> $b);

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
    }

    public function testSortReturnsSelf(): void
    {
        $array = new Arr(3, 1, 2);

        $result = $array->sort();

        self::assertSame($array, $result);
    }

    public function testSortMutatesOriginal(): void
    {
        $array = new Arr(3, 1, 2);

        $array->sort(static fn (int $a, int $b): int => $a <=> $b);

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
    }

    public function testSortOnEmptyArray(): void
    {
        $array = new Arr();

        $array->sort();

        self::assertSame(0, iterator_count($array->values()));
    }

    public function testSortOnSingleElement(): void
    {
        $array = new Arr();
        $array->push(42);

        $array->sort();

        self::assertSame(42, $array->at(0));
    }

    // Array.prototype.splice

    public function testSpliceRemovesElementsAndReturnsThem(): void
    {
        $array = new Arr('a', 'b', 'c', 'd');

        $removed = $array->splice(1, 2);

        self::assertSame(['b', 'c'], iterator_to_array($removed->values()));
        self::assertSame(['a', 'd'], iterator_to_array($array->values()));
    }

    public function testSpliceWithoutDeleteCountRemovesAllFromStart(): void
    {
        $array = new Arr('a', 'b', 'c');

        $removed = $array->splice(1);

        self::assertSame(['b', 'c'], iterator_to_array($removed->values()));
        self::assertSame(['a'], iterator_to_array($array->values()));
    }

    public function testSpliceWithNegativeStart(): void
    {
        $array = new Arr('a', 'b', 'c', 'd');

        $removed = $array->splice(-2, 1);

        self::assertSame(['c'], iterator_to_array($removed->values()));
        self::assertSame(['a', 'b', 'd'], iterator_to_array($array->values()));
    }

    public function testSpliceInsertsElements(): void
    {
        $array = new Arr('a', 'b');

        $removed = $array->splice(1, 0, 'x', 'y');

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame(['a', 'x', 'y', 'b'], iterator_to_array($array->values()));
    }

    public function testSpliceReplacesElements(): void
    {
        $array = new Arr('a', 'b', 'c');

        $removed = $array->splice(1, 1, 'x');

        self::assertSame(['b'], iterator_to_array($removed->values()));
        self::assertSame(['a', 'x', 'c'], iterator_to_array($array->values()));
    }

    public function testSpliceWithStartGreaterThanLengthAppendsToEnd(): void
    {
        $array = new Arr('a', 'b');

        $removed = $array->splice(10, 0, 'c');

        self::assertSame([], iterator_to_array($removed->values()));
        self::assertSame(['a', 'b', 'c'], iterator_to_array($array->values()));
    }

    // Array.prototype.toLocaleString

    public function testToLocaleStringOnEmptyArrayReturnsEmptyString(): void
    {
        $array = new Arr();

        $result = $array->toLocaleString();

        self::assertSame('', $result);
    }

    public function testToLocaleStringWithSingleNullReturnsEmptyString(): void
    {
        $array = new Arr();
        $array->push(null);

        $result = $array->toLocaleString();

        self::assertSame('', $result);
    }

    public function testToLocaleStringReturnsCommaSeparatedString(): void
    {
        $array = new Arr('a', 'b', 'c');

        $result = $array->toLocaleString();

        self::assertSame('a,b,c', $result);
    }

    public function testToLocaleStringWithNumbers(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->toLocaleString();

        self::assertSame('1,2,3', $result);
    }

    public function testToLocaleStringWithNullReturnsEmptyStringForNull(): void
    {
        $array = new Arr();
        $array->push('a', null, 'b');

        $result = $array->toLocaleString();

        self::assertSame('a,,b', $result);
    }

    public function testToLocaleStringWithConsecutiveNulls(): void
    {
        $array = new Arr();
        $array->push('a', null, null, 'b');

        $result = $array->toLocaleString();

        self::assertSame('a,,,b', $result);
    }

    public function testToLocaleStringOnSingleElement(): void
    {
        $array = new Arr();
        $array->push(42);

        $result = $array->toLocaleString();

        self::assertSame('42', $result);
    }

    public function testToLocaleStringWithLocalesAndOptionsFormatsNumbers(): void
    {
        $array = new Arr(1000, 0.25, 1);

        $result = $array->toLocaleString('en-US', ['style' => 'decimal']);

        self::assertSame('1,000,0.25,1', $result);
    }

    public function testToLocaleStringWithPercentStyle(): void
    {
        $array = new Arr(0.25, 0.5);

        $result = $array->toLocaleString('en-US', ['style' => 'percent']);

        self::assertSame('25%,50%', $result);
    }

    public function testToLocaleStringWithCurrencyStyle(): void
    {
        $array = new Arr(1234.5, 56);

        $result = $array->toLocaleString('en-US', ['style' => 'currency', 'currency' => 'USD']);

        self::assertSame('$1,234.50,$56.00', $result);
    }

    public function testToLocaleStringWithLocaleSpecificFormatting(): void
    {
        $array = new Arr();
        $array->push(1234.5);

        $result = $array->toLocaleString('de-DE');

        self::assertSame('1.234,5', $result);
    }

    public function testToLocaleStringWithMinimumFractionDigits(): void
    {
        $array = new Arr(1, 2);

        $result = $array->toLocaleString('en-US', ['minimumFractionDigits' => 2]);

        self::assertSame('1.00,2.00', $result);
    }

    public function testToLocaleStringWithMaximumFractionDigits(): void
    {
        $array = new Arr();
        $array->push(1.234, 5.678);

        $result = $array->toLocaleString('en-US', ['maximumFractionDigits' => 2]);

        self::assertSame('1.23,5.68', $result);
    }

    public function testToLocaleStringWithMinimumIntegerDigits(): void
    {
        $array = new Arr(1, 2);

        $result = $array->toLocaleString('en-US', ['minimumIntegerDigits' => 3]);

        self::assertSame('001,002', $result);
    }

    public function testToLocaleStringWithMinimumSignificantDigits(): void
    {
        $array = new Arr();
        $array->push(1.5, 2.7);

        $result = $array->toLocaleString('en-US', ['minimumSignificantDigits' => 3]);

        self::assertSame('1.50,2.70', $result);
    }

    public function testToLocaleStringWithMaximumIntegerDigits(): void
    {
        $array = new Arr(123, 456);

        $result = $array->toLocaleString('en-US', ['maximumIntegerDigits' => 2]);

        self::assertSame('23,56', $result);
    }

    public function testToLocaleStringWithMaximumSignificantDigits(): void
    {
        $array = new Arr();
        $array->push(123.456, 7.89);

        $result = $array->toLocaleString('en-US', ['maximumSignificantDigits' => 3]);

        self::assertSame('123,7.89', $result);
    }

    public function testToLocaleStringWithUseGroupingDisabled(): void
    {
        $array = new Arr(1000, 2000);

        $result = $array->toLocaleString('en-US', ['useGrouping' => false]);

        self::assertSame('1000,2000', $result);
    }

    public function testToLocaleStringWithBooleans(): void
    {
        $array = new Arr(true, false);

        $result = $array->toLocaleString();

        self::assertSame('1,', $result);
    }

    // Array.prototype.toReversed

    public function testToReversedReturnsReversedCopy(): void
    {
        $array = new Arr(1, 2, 3);

        $result = $array->toReversed();

        self::assertNotSame($array, $result);
        self::assertSame(3, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(1, $result->at(2));
    }

    public function testToReversedDoesNotMutateOriginal(): void
    {
        $array = new Arr(1, 2, 3);

        $array->toReversed();

        self::assertSame(1, $array->at(0));
        self::assertSame(2, $array->at(1));
        self::assertSame(3, $array->at(2));
    }

    public function testToReversedOnEmptyArrayReturnsEmpty(): void
    {
        $array = new Arr();

        $result = $array->toReversed();

        self::assertNotSame($array, $result);
        self::assertSame(0, iterator_count($result->values()));
    }

    // Array.prototype.toSorted

    public function testToSortedReturnsSortedCopy(): void
    {
        $array = new Arr(3, 1, 2);

        $result = $array->toSorted();

        self::assertNotSame($array, $result);
        self::assertSame(1, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(3, $result->at(2));
    }

    public function testToSortedDoesNotMutateOriginal(): void
    {
        $array = new Arr(3, 1, 2);

        $array->toSorted();

        self::assertSame(3, $array->at(0));
        self::assertSame(1, $array->at(1));
        self::assertSame(2, $array->at(2));
    }

    public function testToSortedWithCallback(): void
    {
        $array = new Arr(3, 1, 2);

        $result = $array->toSorted(static fn (int $a, int $b): int => $a <=> $b);

        self::assertSame(1, $result->at(0));
        self::assertSame(2, $result->at(1));
        self::assertSame(3, $result->at(2));
    }

    // Array.prototype.toSpliced

    public function testToSplicedReturnsSplicedCopy(): void
    {
        $array = new Arr('a', 'b', 'c', 'd');

        $result = $array->toSpliced(1, 2);

        self::assertNotSame($array, $result);
        self::assertSame('a', $result->at(0));
        self::assertSame('d', $result->at(1));
    }

    public function testToSplicedDoesNotMutateOriginal(): void
    {
        $array = new Arr('a', 'b', 'c', 'd');

        $array->toSpliced(1, 2);

        self::assertSame('a', $array->at(0));
        self::assertSame('b', $array->at(1));
        self::assertSame('c', $array->at(2));
        self::assertSame('d', $array->at(3));
    }

    public function testToSplicedInsertsItems(): void
    {
        $array = new Arr('a', 'b');

        $result = $array->toSpliced(1, 0, 'x', 'y');

        self::assertSame(['a', 'x', 'y', 'b'], iterator_to_array($result->values()));
    }

    public function testToSplicedWithoutDeleteCountRemovesAllFromStart(): void
    {
        $array = new Arr('a', 'b', 'c');

        $result = $array->toSpliced(1);

        self::assertSame(['a'], iterator_to_array($result->values()));
    }

    public function testToSplicedWithNegativeStart(): void
    {
        $array = new Arr('a', 'b', 'c', 'd');

        $result = $array->toSpliced(-2, 1);

        self::assertSame(['a', 'b', 'd'], iterator_to_array($result->values()));
    }

    public function testToSplicedWithStartGreaterThanLengthAppendsToEnd(): void
    {
        $array = new Arr('a', 'b');

        $result = $array->toSpliced(10, 0, 'c');

        self::assertSame(['a', 'b', 'c'], iterator_to_array($result->values()));
    }

    // Array.prototype.toString

    public function testToStringDelegatesToJoin(): void
    {
        $array = new Arr('a', 'b', 'c');

        $result = $array->toString();

        self::assertSame('a,b,c', $result);
    }

    public function testToStringOfEmptyArray(): void
    {
        $array = new Arr();

        $result = $array->toString();

        self::assertSame('', $result);
    }

    public function testToStringWithNullElements(): void
    {
        $array = new Arr(3);

        $result = $array->toString();

        self::assertSame(',,', $result);
    }

    // Array.prototype.unshift

    public function testUnshiftPrependsElementsAndReturnsNewLength(): void
    {
        $array = new Arr('a', 'b');

        $length = $array->unshift('x', 'y');

        self::assertSame(4, $length);
        self::assertSame('x', $array->at(0));
        self::assertSame('y', $array->at(1));
        self::assertSame('a', $array->at(2));
        self::assertSame('b', $array->at(3));
    }

    public function testUnshiftOnEmptyArray(): void
    {
        $array = new Arr();

        $length = $array->unshift('a', 'b');

        self::assertSame(2, $length);
        self::assertSame('a', $array->at(0));
        self::assertSame('b', $array->at(1));
    }

    public function testUnshiftWithNoArgumentsReturnsCurrentLength(): void
    {
        $array = new Arr('a', 'b');

        $length = $array->unshift();

        self::assertSame(2, $length);
    }

    // Array.prototype.values

    public function testValuesReturnsIterator(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->values();

        self::assertInstanceOf(\Generator::class, $iterator);
    }

    public function testValuesIteratorYieldsArrayValues(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->values();

        self::assertSame('a', $iterator->current());
        $iterator->next();
        self::assertSame('b', $iterator->current());
        $iterator->next();
        self::assertSame('c', $iterator->current());
        $iterator->next();
        self::assertNull($iterator->current());
    }
}
