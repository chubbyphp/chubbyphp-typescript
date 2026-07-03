<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Map;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Map.prototype.forEach tests.
 *
 * @covers \Chubbyphp\Typescript\Map
 *
 * @internal
 */
final class Test262MapPrototypeForEachTest extends TestCase
{
    /**
     * test/built-ins/Map/prototype/forEach/callback-parameters.js.
     */
    public function testCallbackParameters(): void
    {
        $map = new Map();
        $map->set('foo', 42);
        $map->set('bar', 'baz');

        $results = [];

        $callback = static function (mixed $value, mixed $key, Map $m) use (&$results): void {
            $results[] = [
                'value' => $value,
                'key' => $key,
                'thisArg' => $m,
            ];
        };

        $map->forEach($callback);

        self::assertSame(42, $results[0]['value'], 'results[0].value');
        self::assertSame('foo', $results[0]['key'], 'results[0].key');
        self::assertSame($map, $results[0]['thisArg'], 'results[0].thisArg');

        self::assertSame('baz', $results[1]['value'], 'results[1].value');
        self::assertSame('bar', $results[1]['key'], 'results[1].key');
        self::assertSame($map, $results[1]['thisArg'], 'results[1].thisArg');

        self::assertCount(2, $results, 'results.length');
    }

    /**
     * test/built-ins/Map/prototype/forEach/callback-result-is-abrupt.js.
     */
    public function testCallbackResultIsAbrupt(): void
    {
        $map = new Map([[0, 0]]);

        $exception = new \Exception('Test262Error');

        try {
            $map->forEach(static function () use ($exception): void {
                throw $exception;
            });

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    /**
     * test/built-ins/Map/prototype/forEach/callback-this-non-strict.js.
     */
    public function testCallbackThisNonStrict(): void
    {
        // Adapted: when thisArg is not passed a non-static Closure keeps its original
        // $this (the JS non-strict test expects the global object rather than a local binding).
        $_this = [];
        $map = new Map();

        $map->set(0, 0);
        $map->set(1, 1);
        $map->set(2, 2);

        $map->forEach(function () use (&$_this): void {
            $_this[] = $this;
        });

        self::assertSame($this, $_this[0], '_this[0]');
        self::assertSame($this, $_this[1], '_this[1]');
        self::assertSame($this, $_this[2], '_this[2]');
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/callback-this-strict.js
    // Reason: strict-mode `this === undefined` semantics do not map to PHP; a non-static
    // Closure without thisArg keeps its original $this (see callback-this-non-strict.js)

    /**
     * test/built-ins/Map/prototype/forEach/deleted-values-during-foreach.js.
     */
    public function testDeletedValuesDuringForeach(): void
    {
        $map = new Map();
        $map->set('foo', 0);
        $map->set('bar', 1);

        $count = 0;
        $results = [];

        $map->forEach(static function (mixed $value, mixed $key) use (&$count, &$results, $map): void {
            if (0 === $count) {
                $map->delete('bar');
            }
            $results[] = [
                'value' => $value,
                'key' => $key,
            ];
            ++$count;
        });

        self::assertCount(1, $results, 'results.length');
        self::assertSame('foo', $results[0]['key'], 'results[0].key');
        self::assertSame(0, $results[0]['value'], 'results[0].value');
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/does-not-have-mapdata-internal-slot-set.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/forEach/does-not-have-mapdata-internal-slot-weakmap.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/forEach/does-not-have-mapdata-internal-slot.js
    // Reason: methods are invoked on Map instances, not generic this values

    // SKIPPED: test/built-ins/Map/prototype/forEach/first-argument-is-not-callable.js
    // Reason: the native `callable` parameter type already enforces the TypeError

    /**
     * test/built-ins/Map/prototype/forEach/forEach.js.
     */
    public function testForEach(): void
    {
        // Adapted: property descriptors do not exist in PHP; only the
        // `typeof Map.prototype.forEach` is `function` part is portable.
        self::assertIsCallable(
            [new Map(), 'forEach'],
            '`typeof Map.prototype.forEach` is `function`'
        );
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-in-key-insertion-order.js.
     */
    public function testIteratesInKeyInsertionOrder(): void
    {
        $map = new Map([
            ['foo', 'valid foo'],
            ['bar', false],
            ['baz', 'valid baz'],
        ]);
        $map->set(0, false);
        $map->set(1, false);
        $map->set(2, 'valid 2');
        $map->delete(1);
        $map->delete('bar');

        // Not setting a new key, just changing the value
        $map->set(0, 'valid 0');

        $results = [];
        $callback = static function (mixed $value) use (&$results): void {
            $results[] = $value;
        };

        $map->forEach($callback);

        self::assertSame('valid foo', $results[0], 'results[0]');
        self::assertSame('valid baz', $results[1], 'results[1]');
        self::assertSame('valid 0', $results[2], 'results[2]');
        self::assertSame('valid 2', $results[3], 'results[3]');
        self::assertCount(4, $results, 'results.length');

        $map->clear();
        $results = [];

        $map->forEach($callback);
        self::assertCount(0, $results, 'results.length');
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-values-added-after-foreach-begins.js.
     */
    public function testIteratesValuesAddedAfterForeachBegins(): void
    {
        $map = new Map();
        $map->set('foo', 0);
        $map->set('bar', 1);

        $count = 0;
        $results = [];

        $map->forEach(static function (mixed $value, mixed $key) use (&$count, &$results, $map): void {
            if (0 === $count) {
                $map->set('baz', 2);
            }
            $results[] = [
                'value' => $value,
                'key' => $key,
            ];
            ++$count;
        });

        self::assertSame(3, $count, 'count');
        self::assertSame(3, $map->size, 'map.size');

        self::assertSame('foo', $results[0]['key'], 'results[0].key');
        self::assertSame(0, $results[0]['value'], 'results[0].value');

        self::assertSame('bar', $results[1]['key'], 'results[1].key');
        self::assertSame(1, $results[1]['value'], 'results[1].value');

        self::assertSame('baz', $results[2]['key'], 'results[2].key');
        self::assertSame(2, $results[2]['value'], 'results[2].value');
    }

    /**
     * test/built-ins/Map/prototype/forEach/iterates-values-deleted-then-readded.js.
     */
    public function testIteratesValuesDeletedThenReadded(): void
    {
        $map = new Map();
        $map->set('foo', 0);
        $map->set('bar', 1);

        $count = 0;
        $results = [];

        $map->forEach(static function (mixed $value, mixed $key) use (&$count, &$results, $map): void {
            if (0 === $count) {
                $map->delete('foo');
                $map->set('foo', 'baz');
            }
            $results[] = [
                'value' => $value,
                'key' => $key,
            ];
            ++$count;
        });

        self::assertSame(3, $count, 'count');
        self::assertSame(2, $map->size, 'map.size');

        self::assertSame('foo', $results[0]['key'], 'results[0].key');
        self::assertSame(0, $results[0]['value'], 'results[0].value');

        self::assertSame('bar', $results[1]['key'], 'results[1].key');
        self::assertSame(1, $results[1]['value'], 'results[1].value');

        self::assertSame('foo', $results[2]['key'], 'results[2].key');
        self::assertSame('baz', $results[2]['value'], 'results[2].value');
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/length.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/forEach/name.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    // SKIPPED: test/built-ins/Map/prototype/forEach/not-a-constructor.js
    // Reason: property descriptor / function identity tests are not portable to PHP

    /**
     * test/built-ins/Map/prototype/forEach/return-undefined.js.
     */
    public function testReturnUndefined(): void
    {
        // Adapted: Map::forEach() has a void return type, so PHP itself guarantees the
        // callback's `return true` cannot leak; the call expression evaluates to null.
        $map = new Map();

        $result = $map->forEach(static fn (): bool => true);

        self::assertNull($result, 'Empty map#forEach returns undefined');

        $map->set(1, 1);
        $result = $map->forEach(static fn (): bool => true);

        self::assertNull($result, 'map#forEach returns undefined');
    }

    /**
     * test/built-ins/Map/prototype/forEach/second-parameter-as-callback-context.js.
     */
    public function testSecondParameterAsCallbackContext(): void
    {
        // thisArg binding works because the callback is a non-static Closure.
        $expectedThis = new \stdClass();
        $_this = [];

        $map = new Map();
        $map->set(0, 0);
        $map->set(1, 1);
        $map->set(2, 2);

        $callback = function () use (&$_this): void {
            $_this[] = $this;
        };

        $map->forEach($callback, $expectedThis);

        self::assertSame($expectedThis, $_this[0], '_this[0]');
        self::assertSame($expectedThis, $_this[1], '_this[1]');
        self::assertSame($expectedThis, $_this[2], '_this[2]');
    }

    // SKIPPED: test/built-ins/Map/prototype/forEach/this-not-object-throw.js
    // Reason: methods are invoked on Map instances, not generic this values
}
