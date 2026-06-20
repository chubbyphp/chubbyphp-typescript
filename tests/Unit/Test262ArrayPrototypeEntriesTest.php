<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.entries tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeEntriesTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/entries/iteration-mutable.js.
     */
    public function testIterationMutable(): void
    {
        $array = new Arr();
        $iterator = $array->entries();

        $array->push('a');

        self::assertTrue($iterator->valid(), 'First result `done` flag');
        $value = $iterator->current();
        self::assertSame(0, $value[0], 'First result `value` (array key)');
        self::assertSame('a', $value[1], 'First result `value (array value)');
        self::assertCount(2, $value, 'First result `value` (length)');

        $iterator->next();
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
        self::assertNull($iterator->current(), 'Exhausted result `value`');

        $array->push('b');

        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag (after push)');
        self::assertNull($iterator->current(), 'Exhausted result `value` (after push)');
    }

    /**
     * test/built-ins/Array/prototype/entries/iteration.js.
     */
    public function testIteration(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->entries();

        self::assertTrue($iterator->valid(), 'First result `done` flag');
        $value = $iterator->current();
        self::assertSame(0, $value[0], 'First result `value` (array key)');
        self::assertSame('a', $value[1], 'First result `value` (array value)');
        self::assertCount(2, $value, 'First result `value` (length)');

        $iterator->next();
        self::assertTrue($iterator->valid(), 'Second result `done` flag');
        $value = $iterator->current();
        self::assertSame(1, $value[0], 'Second result `value` (array key)');
        self::assertSame('b', $value[1], 'Second result `value` (array value)');
        self::assertCount(2, $value, 'Second result `value` (length)');

        $iterator->next();
        self::assertTrue($iterator->valid(), 'Third result `done` flag');
        $value = $iterator->current();
        self::assertSame(2, $value[0], 'Third result `value` (array key)');
        self::assertSame('c', $value[1], 'Third result `value` (array value)');
        self::assertCount(2, $value, 'Third result `value` (length)');

        $iterator->next();
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
        self::assertNull($iterator->current(), 'Exhausted result `value`');
    }

    // SKIPPED: test/built-ins/Array/prototype/entries/length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/prop-desc.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/resizable-buffer-grow-mid-iteration.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/resizable-buffer-shrink-mid-iteration.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/resizable-buffer.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/return-abrupt-from-this.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/entries/returns-iterator-from-object.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/entries/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        // Adapted: Arr::entries() returns a \Generator instead of an %ArrayIteratorPrototype% object
        $iter = (new Arr())->entries();

        self::assertInstanceOf(\Generator::class, $iter, 'The result of (new Arr())->entries() is a \Generator');
    }
}
