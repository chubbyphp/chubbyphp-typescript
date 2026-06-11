<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.values tests, plus the markers for the
 * Array.prototype root, Symbol.iterator and Symbol.unscopables tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeValuesTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/values/iteration-mutable.js.
     */
    public function testIterationMutable(): void
    {
        $array = new Arr();
        $iterator = $array->values();

        $array->push('a');

        self::assertTrue($iterator->valid(), 'First result `done` flag');
        self::assertSame('a', $iterator->current(), 'First result `value`');

        $iterator->next();
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
        self::assertNull($iterator->current(), 'Exhausted result `value`');

        $array->push('b');

        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag (after push)');
        self::assertNull($iterator->current(), 'Exhausted result `value` (after push)');
    }

    /**
     * test/built-ins/Array/prototype/values/iteration.js.
     */
    public function testIteration(): void
    {
        $array = new Arr('a', 'b', 'c');
        $iterator = $array->values();

        self::assertSame('a', $iterator->current(), 'First result `value`');
        self::assertTrue($iterator->valid(), 'First result `done` flag');

        $iterator->next();
        self::assertSame('b', $iterator->current(), 'Second result `value`');
        self::assertTrue($iterator->valid(), 'Second result `done` flag');

        $iterator->next();
        self::assertSame('c', $iterator->current(), 'Third result `value`');
        self::assertTrue($iterator->valid(), 'Third result `done` flag');

        $iterator->next();
        self::assertNull($iterator->current(), 'Exhausted result `value`');
        self::assertFalse($iterator->valid(), 'Exhausted result `done` flag');
    }

    // SKIPPED: test/built-ins/Array/prototype/values/length.js

    // SKIPPED: test/built-ins/Array/prototype/values/name.js

    // SKIPPED: test/built-ins/Array/prototype/values/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/values/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/values/resizable-buffer-grow-mid-iteration.js

    // SKIPPED: test/built-ins/Array/prototype/values/resizable-buffer-shrink-mid-iteration.js

    // SKIPPED: test/built-ins/Array/prototype/values/resizable-buffer.js

    // SKIPPED: test/built-ins/Array/prototype/values/returns-iterator-from-object.js

    /**
     * test/built-ins/Array/prototype/values/returns-iterator.js.
     */
    public function testReturnsIterator(): void
    {
        // Adapted: Arr::values() returns a \Generator instead of an %ArrayIteratorPrototype% object
        $iter = (new Arr())->values();

        self::assertInstanceOf(\Generator::class, $iter, 'The result of (new Arr())->values() is a \Generator');
    }

    // SKIPPED: test/built-ins/Array/prototype/values/this-val-non-obj-coercible.js

    // ===== test/built-ins/Array/prototype (root), Symbol.iterator, Symbol.unscopables =====

    // SKIPPED: test/built-ins/Array/prototype/Symbol.iterator/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/prototype/Symbol.unscopables/array-find-from-last.js

    // SKIPPED: test/built-ins/Array/prototype/Symbol.unscopables/change-array-by-copy.js

    // SKIPPED: test/built-ins/Array/prototype/Symbol.unscopables/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/Symbol.unscopables/value.js

    /**
     * test/built-ins/Array/prototype/Symbol.iterator.js.
     */
    public function testSymbolIterator(): void
    {
        // Adapted: iterating an Arr (its default iterator) yields the same sequence as values()
        $array = new Arr(3);
        $array[0] = 'a';
        $array[2] = 'c';

        self::assertSame(
            iterator_to_array($array->values(), false),
            iterator_to_array($array->getIterator(), false),
            'The default iterator of Arr is expected to yield the same sequence as Arr::values()'
        );
    }

    // SKIPPED: test/built-ins/Array/prototype/constructor.js

    // SKIPPED: test/built-ins/Array/prototype/exotic-array.js

    // SKIPPED: test/built-ins/Array/prototype/length.js

    // SKIPPED: test/built-ins/Array/prototype/methods-called-as-functions.js

    // SKIPPED: test/built-ins/Array/prototype/prop-desc.js

    // SKIPPED: test/built-ins/Array/prototype/proto.js
}
