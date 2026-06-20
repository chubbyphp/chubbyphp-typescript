<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.keys tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeKeysTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/keys/iteration-mutable.js.
     */
    public function testIterationMutable(): void
    {
        $array = new Arr();
        $iterator = $array->keys();

        $array->push('a');

        self::assertTrue($iterator->valid(), 'First result `done` flag');
        self::assertSame(0, $iterator->current(), 'First result `value`');

        $iterator->next();
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
        self::assertNull($iterator->current(), 'Exhausted result `value`');

        $array->push('b');

        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag (after push)');
        self::assertNull($iterator->current(), 'Exhausted result `value` (after push)');
    }

    /**
     * test/built-ins/Array/prototype/keys/iteration.js.
     */
    public function testIteration(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->keys();

        self::assertSame(0, $iterator->current(), 'First result `value`');
        self::assertTrue($iterator->valid(), 'First result `done` flag');

        $iterator->next();
        self::assertSame(1, $iterator->current(), 'Second result `value`');
        self::assertTrue($iterator->valid(), 'Second result `done` flag');

        $iterator->next();
        self::assertSame(2, $iterator->current(), 'Third result `value`');
        self::assertTrue($iterator->valid(), 'Third result `done` flag');

        $iterator->next();
        self::assertNull($iterator->current(), 'Exhausted result `value`');
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
    }

    // SKIPPED: test/built-ins/Array/prototype/keys/length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/prop-desc.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/resizable-buffer-grow-mid-iteration.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/resizable-buffer-shrink-mid-iteration.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/resizable-buffer.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/return-abrupt-from-this.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/keys/returns-iterator-from-object.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/keys/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        // Adapted: Arr::keys() returns a \Generator instead of an %ArrayIteratorPrototype% object
        $iter = (new Arr())->keys();

        self::assertInstanceOf(\Generator::class, $iter, 'The result of (new Arr())->keys() is a \Generator');
    }
}
