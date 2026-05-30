<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use Chubbyphp\Typescript\RangeError;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array constructor and statics tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayTest extends TestCase
{
    /**
     * test/built-ins/Array/15.4.5.1-5-1.js.
     */
    public function test1545151(): void
    {
        $a = new Arr();
        $a[4294967295] = 'not an array element';

        self::assertSame('not an array element', $a[4294967295], 'The value of $a[4294967295] is expected to be "not an array element"');
    }

    /**
     * test/built-ins/Array/15.4.5.1-5-2.js.
     */
    public function test1545152(): void
    {
        $a = new Arr(0, 1, 2);
        $a[4294967295] = 'not an array element';

        self::assertSame(3, $a->length, 'The value of $a->length is expected to be 3');
    }

    // SKIPPED: test/built-ins/Array/15.4.5-1.js

    // SKIPPED: test/built-ins/Array/constructor.js

    // SKIPPED: test/built-ins/Array/from/Array.from_arity.js

    // SKIPPED: test/built-ins/Array/from/Array.from-descriptor.js

    // SKIPPED: test/built-ins/Array/from/Array.from_forwards-length-for-array-likes.js

    // SKIPPED: test/built-ins/Array/from/Array.from-name.js

    // SKIPPED: test/built-ins/Array/from/array-like-has-length-but-no-indexes-with-values.js

    /**
     * test/built-ins/Array/from/calling-from-valid-1-noStrict.js.
     */
    public function testCallingFromValid1NoStrict(): void
    {
        $list = new Arr(41, 42, 43);
        $calls = new Arr();

        $mapFn = function (int $value) use ($calls): int {
            $calls->push([
                'args' => \func_get_args(),
                'thisArg' => $this,
            ]);

            return $value * 2;
        };

        $result = Arr::from($list, $mapFn);

        self::assertCount(3, $result, 'The value of $result->length is expected to be 3');
        self::assertSame(82, $result[0], 'The value of $result[0] is expected to be 82');
        self::assertSame(84, $result[1], 'The value of $result[1] is expected to be 84');
        self::assertSame(86, $result[2], 'The value of $result[2] is expected to be 86');

        self::assertCount(3, $calls, 'The value of $calls length is expected to be 3');

        self::assertCount(2, $calls[0]['args'], 'The value of $calls[0]["args"] length is expected to be 2');
        self::assertSame(41, $calls[0]['args'][0], 'The value of $calls[0]["args"][0] is expected to be 41');
        self::assertSame(0, $calls[0]['args'][1], 'The value of $calls[0]["args"][1] is expected to be 0');
        self::assertSame($this, $calls[0]['thisArg'], 'The value of $calls[0]["thisArg"] is expected to be this');

        self::assertCount(2, $calls[1]['args'], 'The value of $calls[0]["args"] length is expected to be 2');
        self::assertSame(42, $calls[1]['args'][0], 'The value of $calls[1]["args"][0] is expected to be 42');
        self::assertSame(1, $calls[1]['args'][1], 'The value of $calls[1]["args"][1] is expected to be 1');
        self::assertSame($this, $calls[1]['thisArg'], 'The value of $calls[1]["thisArg"] is expected to be this');

        self::assertCount(2, $calls[2]['args'], 'The value of $calls[2]["args"] length is expected to be 2');
        self::assertSame(43, $calls[2]['args'][0], 'The value of $calls[2]["args"][0] is expected to be 43');
        self::assertSame(2, $calls[2]['args'][1], 'The value of $calls[2]["args"][1] is expected to be 2');
        self::assertSame($this, $calls[2]['thisArg'], 'The value of $calls[2]["thisArg"] is expected to be this');
    }

    // SKIPPED: test/built-ins/Array/from/calling-from-valid-1-onlyStrict.js

    /**
     * test/built-ins/Array/from/calling-from-valid-2.js.
     */
    public function testCallingFromValid2(): void
    {
        $list = new Arr(41, 42, 43);
        $calls = new Arr();
        $thisArg = new \stdClass();

        $mapFn = function (int $value) use ($calls): int {
            $calls->push([
                'args' => \func_get_args(),
                'thisArg' => $this,
            ]);

            return $value * 2;
        };

        $result = Arr::from($list, $mapFn, $thisArg);

        self::assertCount(3, $result, 'The value of $result->length is expected to be 3');
        self::assertSame(82, $result[0], 'The value of $result[0] is expected to be 82');
        self::assertSame(84, $result[1], 'The value of $result[1] is expected to be 84');
        self::assertSame(86, $result[2], 'The value of $result[2] is expected to be 86');

        self::assertCount(3, $calls, 'The value of $calls length is expected to be 3');

        self::assertCount(2, $calls[0]['args'], 'The value of $calls[0]["args"] length is expected to be 2');
        self::assertSame(41, $calls[0]['args'][0], 'The value of $calls[0]["args"][0] is expected to be 41');
        self::assertSame(0, $calls[0]['args'][1], 'The value of $calls[0]["args"][1] is expected to be 0');
        self::assertSame($thisArg, $calls[0]['thisArg'], 'The value of $calls[0]["thisArg"] is expected to be this');

        self::assertCount(2, $calls[1]['args'], 'The value of $calls[0]["args"] length is expected to be 2');
        self::assertSame(42, $calls[1]['args'][0], 'The value of $calls[1]["args"][0] is expected to be 42');
        self::assertSame(1, $calls[1]['args'][1], 'The value of $calls[1]["args"][1] is expected to be 1');
        self::assertSame($thisArg, $calls[1]['thisArg'], 'The value of $calls[1]["thisArg"] is expected to be this');

        self::assertCount(2, $calls[2]['args'], 'The value of $calls[2]["args"] length is expected to be 2');
        self::assertSame(43, $calls[2]['args'][0], 'The value of $calls[2]["args"][0] is expected to be 43');
        self::assertSame(2, $calls[2]['args'][1], 'The value of $calls[2]["args"][1] is expected to be 2');
        self::assertSame($thisArg, $calls[2]['thisArg'], 'The value of $calls[2]["thisArg"] is expected to be this');
    }

    /**
     * test/built-ins/Array/from/elements-added-after.js.
     */
    public function testElementsAddedAfter(): void
    {
        $arrayIndex = -1;
        $originalLength = 7;
        $obj = [2, 4, 8, 16, 32, 64, 128];
        $array = new Arr(2, 4, 8, 16, 32, 64, 128);

        $mapFn = static function (int $value, int $index) use (&$arrayIndex, &$obj, $originalLength): int {
            ++$arrayIndex;
            self::assertSame($obj[$arrayIndex], $value, 'The value of value is expected to equal the value of $obj[$arrayIndex]');
            self::assertSame($arrayIndex, $index, 'The value of index is expected to equal the value of arrayIndex');

            $obj[$originalLength + $arrayIndex] = 2 * $arrayIndex + 1;

            return $obj[$arrayIndex];
        };

        $a = Arr::from($obj, $mapFn);
        self::assertSame($array->length, $a->length, 'The value of $a->length is expected to equal the value of $array->length');

        for ($j = 0; $j < $a->length; ++$j) {
            self::assertSame($array[$j], $a[$j], 'The value of $a[$j] is expected to equal the value of $array[$j]');
        }
    }

    /**
     * test/built-ins/Array/from/elements-deleted-after.js.
     */
    public function testElementsDeletedAfter(): void
    {
        $originalArray = new Arr(0, 1, -2, 4, -8, 16);
        $array = new Arr(0, 1, -2, 4, -8, 16);
        $arrayIndex = -1;

        $mapFn = static function (int $value, int $index) use (&$arrayIndex, $array): int {
            ++$arrayIndex;
            self::assertSame($array[$arrayIndex], $value, 'The value of value is expected to equal the value of $array[$arrayIndex]');
            self::assertSame($arrayIndex, $index, 'The value of index is expected to equal the value of arrayIndex');

            $array->splice($array->length - 1, 1);

            return 127;
        };

        $a = Arr::from($array, $mapFn, $this);
        self::assertSame($originalArray->length / 2, $a->length, 'The value of $a->length is expected to be $originalArray->length / 2');

        for ($j = 0; $j < $originalArray->length / 2; ++$j) {
            self::assertSame(127, $a[$j], 'he value of $a[$j] is expected to be 127');
        }
    }

    /**
     * test/built-ins/Array/from/elements-updated-after.js.
     */
    public function testElementsUpdatedAfter(): void
    {
        $array = new Arr(127, 4, 8, 16, 32, 64, 128);
        $arrayIndex = -1;

        $mapFn = static function (int $value, int $index) use (&$arrayIndex, $array): int {
            ++$arrayIndex;

            if ($index + 1 < $array->length) {
                $array[$index + 1] = 127;
            }

            self::assertSame(127, $value, 'The value of value is expected to be 127');
            self::assertSame($arrayIndex, $index, 'The value of index is expected to equal the value of arrayIndex');

            return $value;
        };

        $a = Arr::from($array, $mapFn);
        self::assertSame($array->length, $a->length, 'The value of $a->length is expected to equal the value of $array->length');

        for ($j = 0; $j < (int) ($a->length / 2); ++$j) {
            self::assertSame(127, $a[$j], 'he value of $a[$j] is expected to be 127');
        }
    }

    /**
     * test/built-ins/Array/from/from-array.js.
     */
    public function testFromArray(): void
    {
        $array = new Arr(0, 'foo', null, INF);
        $result = Arr::from($array);

        self::assertSame(4, $result->length, 'The value of $result->length is expected to be 4');
        self::assertSame(0, $result[0], 'The value of $result[0] is expected to be 0');
        self::assertSame('foo', $result[1], 'The value of $result[1] is expected to be "foo"');
        self::assertNull($result[2], 'The value of $result[2] is expected to equal null');
        self::assertSame(INF, $result[3], 'The value of $result[3] is expected to equal INF');

        self::assertNotSame($result, $array, 'The value of result is expected to not equal the value of `array`');
        self::assertInstanceOf(Arr::class, $result, 'The result of evaluating ($result instanceof Array) is expected to be true');
    }

    /**
     * test/built-ins/Array/from/from-string.js.
     */
    public function testFromString(): void
    {
        $arrLikeSource = 'Test';
        $result = Arr::from($arrLikeSource);

        self::assertSame(4, $result->length, 'The value of $result->length is expected to be 4');
        self::assertSame('T', $result[0], 'The value of $result[0] is expected to be "T"');
        self::assertSame('e', $result[1], 'The value of $result[1] is expected to be "e"');
        self::assertSame('s', $result[2], 'The value of $result[2] is expected to be "s"');
        self::assertSame('t', $result[3], 'The value of $result[3] is expected to be "t"');
    }

    /**
     * test/built-ins/Array/from/get-iter-method-err.js.
     */
    public function testGetIterMethodErr(): void
    {
        $exception = new \Exception();

        $items = (static function () use ($exception): \Generator {
            for ($i = 0; $i < 10; ++$i) {
                if (5 === $i) {
                    throw $exception;
                }

                yield $i;
            }
        })();

        try {
            Arr::from($items);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/from/items-is-arraybuffer.js

    /**
     * test/built-ins/Array/from/items-is-null-throws.js.
     */
    public function testItemsIsNullThrows(): void
    {
        $this->expectException(\TypeError::class);
        Arr::from(null);
    }

    // SKIPPED: test/built-ins/Array/from/iter-adv-err.js

    // SKIPPED: test/built-ins/Array/from/iter-cstm-ctor-err.js

    // SKIPPED: test/built-ins/Array/from/iter-cstm-ctor.js

    // SKIPPED: test/built-ins/Array/from/iter-get-iter-err.js

    // SKIPPED: test/built-ins/Array/from/iter-get-iter-val-err.js

    /**
     * test/built-ins/Array/from/iter-map-fn-args.js.
     */
    public function testIterMapFnArgs(): void
    {
        $args = new Arr();

        $firstResult = [
            'done' => false,
            'value' => [],
        ];

        $secondResult = [
            'done' => false,
            'value' => [],
        ];

        $mapFn = static function (mixed $value, int $idx) use ($args): void {
            $args->push(\func_get_args());
        };

        $items = (static function () use ($firstResult, $secondResult): \Generator {
            $nextResult = $firstResult;
            $nextNextResult = $secondResult;

            while (true) {
                $result = $nextResult;
                $nextResult = $nextNextResult;
                $nextNextResult = [
                    'done' => true,
                ];

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        Arr::from($items, $mapFn);

        self::assertSame(
            2,
            $args->length,
            'The value of $args->length is expected to be 2',
        );

        self::assertCount(
            2,
            $args[0],
            'The value of $args[0] length is expected to be 2',
        );

        self::assertSame(
            $firstResult['value'],
            $args[0][0],
            'The value of $args[0][0] is expected to equal the value of $firstResult["value"]',
        );

        self::assertSame(
            0,
            $args[0][1],
            'The value of $args[0][1] is expected to be 0',
        );

        self::assertCount(
            2,
            $args[1],
            'The value of $args[1] length is expected to be 2',
        );

        self::assertSame(
            $secondResult['value'],
            $args[1][0],
            'The value of $args[1][0] is expected to equal the value of $secondResult["value"]',
        );

        self::assertSame(
            1,
            $args[1][1],
            'The value of $args[1][1] is expected to be 1',
        );
    }

    /**
     * test/built-ins/Array/from/iter-map-fn-err.js.
     */
    public function testIteratorIsClosedWhenMapFnThrows(): void
    {
        $closeCount = 0;

        $exception = new \Exception();

        $mapFn = static function () use ($exception): never {
            throw $exception;
        };

        $items = (static function () use (&$closeCount): \Generator {
            ++$closeCount;

            yield null;
        })();

        try {
            Arr::from($items, $mapFn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e, 'Arr::from(items, mapFn) throws a exception');
        }

        self::assertSame(
            1,
            $closeCount,
            'The value of $closeCount is expected to be 1',
        );
    }

    /**
     * test/built-ins/Array/from/iter-map-fn-return.js.
     */
    public function testIterMapFnReturn(): void
    {
        $nextResult = [
            'done' => false,
            'value' => [],
        ];

        $nextNextResult = [
            'done' => false,
            'value' => [],
        ];

        $firstReturnVal = [];
        $secondReturnVal = [];

        $nextReturnVal = $firstReturnVal;
        $nextNextReturnVal = $secondReturnVal;

        $mapFn = static function (mixed $value, int $idx) use (
            &$nextReturnVal,
            &$nextNextReturnVal
        ): mixed {
            $returnVal = $nextReturnVal;
            $nextReturnVal = $nextNextReturnVal;
            $nextNextReturnVal = null;

            return $returnVal;
        };

        $items = (static function () use (&$nextResult, &$nextNextResult): \Generator {
            while (true) {
                $result = $nextResult;
                $nextResult = $nextNextResult;
                $nextNextResult = [
                    'done' => true,
                ];

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        $result = Arr::from($items, $mapFn);

        self::assertSame(
            2,
            $result->length,
            'The value of $result->length is expected to be 2',
        );

        self::assertSame(
            $firstReturnVal,
            $result[0],
            'The value of $result[0] is expected to equal the value of $firstReturnVal',
        );

        self::assertSame(
            $secondReturnVal,
            $result[1],
            'The value of $result[1] is expected to equal the value of $secondReturnVal',
        );
    }

    /**
     * test/built-ins/Array/from/iter-map-fn-this-arg.js.
     */
    public function testIterMapFnThisArg(): void
    {
        $thisVals = new Arr();

        $nextResult = [
            'done' => false,
            'value' => [],
        ];

        $nextNextResult = [
            'done' => false,
            'value' => [],
        ];

        $thisVal = new \stdClass();

        $mapFn = function () use ($thisVals): void {
            $thisVals->push($this);
        };

        $items = (static function () use (&$nextResult, &$nextNextResult): \Generator {
            while (true) {
                $result = $nextResult;
                $nextResult = $nextNextResult;
                $nextNextResult = [
                    'done' => true,
                ];

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        Arr::from($items, $mapFn, $thisVal);

        self::assertSame(
            2,
            $thisVals->length,
            'The value of $thisVals->length is expected to be 2',
        );

        self::assertSame(
            $thisVal,
            $thisVals[0],
            'The value of $thisVals[0] is expected to equal the value of $thisVal',
        );

        self::assertSame(
            $thisVal,
            $thisVals[1],
            'The value of $thisVals[1] is expected to equal the value of $thisVal',
        );
    }

    /**
     * test/built-ins/Array/from/iter-map-fn-this-non-strict.js.
     */
    public function testIterMapFnThisNonStrict(): void
    {
        $thisVals = new Arr();

        $nextResult = [
            'done' => false,
            'value' => [],
        ];

        $nextNextResult = [
            'done' => false,
            'value' => [],
        ];

        $mapFn = static function (
            mixed $value,
            int $idx,
            mixed $thisArg = null
        ) use ($thisVals): void {
            $thisVals->push($thisArg);
        };

        $items = (static function () use (&$nextResult, &$nextNextResult): \Generator {
            while (true) {
                $result = $nextResult;
                $nextResult = $nextNextResult;
                $nextNextResult = [
                    'done' => true,
                ];

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        Arr::from($items, $mapFn);

        self::assertSame(
            2,
            $thisVals->length,
            'The value of $thisVals->length is expected to be 2',
        );

        self::assertNull(
            $thisVals[0],
            'The value of $thisVals[0] is expected to be null',
        );

        self::assertNull(
            $thisVals[1],
            'The value of $thisVals[1] is expected to be null',
        );
    }

    /**
     * test/built-ins/Array/from/iter-map-fn-this-strict.js.
     */
    public function testIterMapFnThisStrict(): void
    {
        $thisVals = new Arr();

        $nextResult = [
            'done' => false,
            'value' => [],
        ];

        $nextNextResult = [
            'done' => false,
            'value' => [],
        ];

        $mapFn = static function (
            mixed $value,
            int $idx,
            mixed $thisArg = null
        ) use ($thisVals): void {
            $thisVals->push($thisArg);
        };

        $items = (static function () use (&$nextResult, &$nextNextResult): \Generator {
            while (true) {
                $result = $nextResult;
                $nextResult = $nextNextResult;
                $nextNextResult = [
                    'done' => true,
                ];

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        Arr::from($items, $mapFn);

        self::assertSame(
            2,
            $thisVals->length,
            'The value of $thisVals->length is expected to be 2',
        );

        self::assertNull(
            $thisVals[0],
            'The value of $thisVals[0] is expected to be null',
        );

        self::assertNull(
            $thisVals[1],
            'The value of $thisVals[1] is expected to be null',
        );
    }

    // SKIPPED: test/built-ins/Array/from/iter-set-elem-prop-err.js.

    /**
     * test/built-ins/Array/from/iter-set-elem-prop.js.
     */
    public function testIterSetElemProp(): void
    {
        $firstIterResult = [
            'done' => false,
            'value' => [],
        ];

        $secondIterResult = [
            'done' => false,
            'value' => [],
        ];

        $thirdIterResult = [
            'done' => true,
            'value' => [],
        ];

        $items = (static function () use (
            $firstIterResult,
            $secondIterResult,
            $thirdIterResult
        ): \Generator {
            $nextIterResult = $firstIterResult;
            $nextNextIterResult = $secondIterResult;

            while (true) {
                $result = $nextIterResult;

                $nextIterResult = $nextNextIterResult;
                $nextNextIterResult = $thirdIterResult;

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'];
            }
        })();

        $result = Arr::from($items);

        self::assertSame(
            $firstIterResult['value'],
            $result[0],
            'The value of $result[0] is expected to equal the value of $firstIterResult["value"]',
        );

        self::assertSame(
            $secondIterResult['value'],
            $result[1],
            'The value of $result[1] is expected to equal the value of $secondIterResult["value"]',
        );
    }

    // SKIPPED: test/built-ins/Array/from/iter-set-elem-prop-non-writable.js

    // SKIPPED: test/built-ins/Array/from/iter-set-length-err.js

    /**
     * test/built-ins/Array/from/iter-set-length.js.
     */
    public function testIterSetLength(): void
    {
        $itemsFactory = static function (array $initialResult, array $finalResult): \Generator {
            $nextIterResult = $initialResult;
            $lastIterResult = $finalResult;

            while (true) {
                $result = $nextIterResult;
                $nextIterResult = $lastIterResult;

                if ($result['done'] ?? false) {
                    return;
                }

                yield $result['value'] ?? null;
            }
        };

        $result = Arr::from($itemsFactory(
            [
                'done' => true,
            ],
            [
                'done' => true,
            ],
        ));

        self::assertSame(
            0,
            $result->length,
            'The value of $result->length is expected to be 0',
        );

        $result = Arr::from($itemsFactory(
            [
                'done' => false,
            ],
            [
                'done' => true,
            ],
        ));

        self::assertSame(
            1,
            $result->length,
            'The value of $result->length is expected to be 1',
        );
    }

    /**
     * test/built-ins/Array/from/mapfn-is-not-callable-typeerror.js.
     */
    public function testMapFnIsNotCallableTypeerror(): void
    {
        // Arr::from([], null); is allowed

        try {
            Arr::from([], []);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(\TypeError::class, $e);
        }

        try {
            Arr::from([], 'unknown');

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(\TypeError::class, $e);
        }

        try {
            Arr::from([], true);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(\TypeError::class, $e);
        }

        try {
            Arr::from([], 42);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(\TypeError::class, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/from/mapfn-is-symbol-throws.js

    /**
     * test/built-ins/Array/from/mapfn-throws-exception.js.
     */
    public function testMapFnThrowsException(): void
    {
        $exception = new \Exception();
        $array = new Arr(2, 4, 8, 16, 32, 64, 128);

        $mapFnThrows = static function (int $value, int $index, Arr $obj) use ($exception): void {
            throw $exception;
        };

        try {
            Arr::from($array, $mapFnThrows);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(\TypeError::class, $e);
        }
    }

    // SKIPPED: test/built-ins/Array/from/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/from/proto-from-ctor-realm.js

    /**
     * test/built-ins/Array/from/source-array-boundary.js.
     */
    public function testSourceArrayBoundary(): void
    {
        $array = new Arr(PHP_FLOAT_MAX, PHP_FLOAT_MIN, NAN, -INF, INF);
        $arrayIndex = -1;

        $mapFn = static function (float|int $value, int $index) use ($array, &$arrayIndex): float|int {
            ++$arrayIndex;

            if (is_nan($array[$arrayIndex])) {
                self::assertNan($value, 'The value of $value is expected to equal the value of $array[$arrayIndex]');
            } else {
                self::assertSame($array[$arrayIndex], $value, 'The value of $value is expected to equal the value of $array[$arrayIndex]');
            }

            self::assertSame($arrayIndex, $index, 'The value of $index is expected to equal the value of $arrayIndex');

            return $value;
        };

        $a = Arr::from($array, $mapFn, $this);

        self::assertSame($array->length, $a->length, 'The value of $a->length is expected to equal the value of $array->length');
        self::assertSame(PHP_FLOAT_MAX, $a[0], 'The value of $a[0] is expected to equal the value of Number.MAX_VALUE');
        self::assertSame(PHP_FLOAT_MIN, $a[1], 'The value of $a[1] is expected to equal the value of Number.MIN_VALUE');
        self::assertNan($a[2], 'The value of $a[2] is expected to equal the value of Number.NaN');
        self::assertSame(-INF, $a[3], 'The value of $a[3] is expected to equal the value of Number.NEGATIVE_INFINITY');
        self::assertSame(INF, $a[4], 'The value of $a[4] is expected to equal the value of Number.POSITIVE_INFINITY');
    }

    // SKIPPED: test/built-ins/Array/from/source-object-constructor.js

    /**
     * test/built-ins/Array/from/source-object-iterator-1.js.
     */
    public function testSourceObjectIterator1(): void
    {
        $exception = new \Exception();

        $obj = static function () use ($exception): \Generator {
            $index = 0;
            $isDone = false;

            while (!$isDone) {
                ++$index;

                if (5 === $index) {
                    throw $exception;
                }

                if ($index > 7) {
                    $isDone = true;

                    return;
                }

                yield 1 << $index;
            }
        };

        try {
            Arr::from($obj());

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e);
        }
    }

    /**
     * test/built-ins/Array/from/source-object-iterator-2.js.
     */
    public function testSourceObjectIterator2(): void
    {
        $array = [2, 4, 8, 16, 32, 64, 128];

        $obj = static function (): \Generator {
            $index = 0;
            $isDone = false;

            while (!$isDone) {
                ++$index;

                if ($index > 7) {
                    $isDone = true;

                    return;
                }

                yield 1 << $index;
            }
        };

        $a = Arr::from($obj());

        self::assertInstanceOf(Arr::class, $a, 'The value of $a is expected to be an object');

        for ($j = 0; $j < $a->length; ++$j) {
            self::assertSame($array[$j], $a[$j], 'The value of $a[$j] is expected to equal the value of $array[$j]');
        }
    }

    /**
     * test/built-ins/Array/from/source-object-length.js.
     */
    public function testSourceObjectLength(): void
    {
        $expectedArray = new Arr(4);
        $expectedArray[0] = 2;
        $expectedArray[1] = 4;
        // JS: expectedArray[2] is a hole
        $expectedArray[3] = 16;

        $obj = new Arr(2);
        $obj[0] = 2;
        $obj[1] = 4;
        $obj[2] = 0;
        $obj[3] = 16;

        // JS: delete obj[2]
        unset($obj[2]);

        $a = Arr::from($obj);

        for ($j = 0; $j < $expectedArray->length; ++$j) {
            self::assertSame(
                $expectedArray[$j],
                $a[$j],
                'The value of $a[$j] is expected to equal the value of $expectedArray[$j]'
            );
        }
    }

    // SKIPPED: test/built-ins/Array/from/source-object-length-set-elem-prop-err.js

    // SKIPPED: test/built-ins/Array/from/source-object-length-set-elem-prop-non-writable.js

    /**
     * test/built-ins/Array/from/source-object-missing.js.
     */
    public function testSourceObjectMissing(): void
    {
        $array = new Arr(4);
        $array[0] = 2;
        $array[1] = 4;
        $array[3] = 16;

        $obj = new Arr(4);
        $obj[0] = 2;
        $obj[1] = 4;
        $obj[3] = 16;

        $a = Arr::from($obj);

        self::assertIsObject($a);
        self::assertInstanceOf(Arr::class, $a);

        for ($j = 0; $j < $a->length; ++$j) {
            self::assertSame(
                $array[$j],
                $a[$j],
                'The value of $a[$j] is expected to equal the value of $array[$j]'
            );
        }
    }

    // SKIPPED: test/built-ins/Array/from/source-object-without.js

    // SKIPPED: test/built-ins/Array/from/this-null.js

    // SKIPPED: test/built-ins/Array/is-a-constructor.js

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-1.js

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-2.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-3.js.
     */
    public function test1543203(): void
    {
        self::assertTrue(Arr::isArray(new Arr()), 'Arr::isArray(new Arr()) must return true');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-4.js.
     */
    public function test1543204(): void
    {
        self::assertFalse(Arr::isArray(42), 'Arr::isArray(42) must return false');
        self::assertFalse(Arr::isArray(null), 'Arr::isArray(null) must return false');
        self::assertFalse(Arr::isArray(true), 'Arr::isArray(true) must return false');
        self::assertFalse(Arr::isArray('abc'), 'Arr::isArray("abc") must return false');
        self::assertFalse(Arr::isArray(new \stdClass()), 'Arr::isArray(new \stdClass) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-0-5.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-6.js.
     */
    public function test1543206(): void
    {
        self::assertTrue(Arr::isArray(new Arr(10)), 'Arr::isArray(new Arr(10)) must return true');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-0-7.js.
     */
    public function test1543207(): void
    {
        self::assertFalse(Arr::isArray((object) []), 'Arr::isArray((object) []) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-10.js

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-11.js

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-12.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-13.js.
     */
    public function test15432113(): void
    {
        $arg = (static fn (): array => \func_get_args())(1, 2, 3);

        self::assertFalse(Arr::isArray($arg), 'Arr::isArray($arguments) must return false');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-15.js.
     */
    public function test15432115(): void
    {
        // In JS this is the global object; in PHPUnit $this is the test instance.
        self::assertFalse(Arr::isArray($this), 'Arr::isArray($this) must return false');
    }

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-1.js.
     */
    public function test1543211(): void
    {
        self::assertFalse(Arr::isArray(true), 'Arr::isArray(true) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-2.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-3.js.
     */
    public function test1543213(): void
    {
        self::assertFalse(Arr::isArray(5), 'Arr::isArray(5) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-4.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-5.js.
     */
    public function test1543215(): void
    {
        self::assertFalse(Arr::isArray('abc'), 'Arr::isArray("abc") must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-6.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-7.js.
     */
    public function test1543217(): void
    {
        self::assertFalse(Arr::isArray(static function (): void {}), 'Arr::isArray(static function() {}) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-1-8.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-1-9.js.
     */
    public function test1543219(): void
    {
        self::assertFalse(Arr::isArray(new \DateTimeImmutable()), 'Arr::isArray(new \DateTimeImmutable()) must return false');
    }

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-2-1.js

    // SKIPPED: test/built-ins/Array/isArray/15.4.3.2-2-2.js

    /**
     * test/built-ins/Array/isArray/15.4.3.2-2-3.js.
     */
    public function test1543223(): void
    {
        self::assertFalse(Arr::isArray(['0' => 12, '1' => 9, 'length' => 2]));
    }

    // SKIPPED: test/built-ins/Array/isArray/descriptor.js

    // SKIPPED: test/built-ins/Array/isArray/name.js

    // SKIPPED: test/built-ins/Array/isArray/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/isArray/proxy.js

    // SKIPPED: test/built-ins/Array/isArray/proxy-revoked.js

    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-1.js.
     */
    public function test154513D1(): void
    {
        try {
            $a = new Arr();
            $a->length = 4294967296;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e);
            self::assertSame('Invalid array length: 4294967296', $e->getMessage());
        }
    }

    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-2.js.
     */
    public function test154513D2(): void
    {
        try {
            $a = new Arr();
            $a->length = 4294967297;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e);
            self::assertSame('Invalid array length: 4294967297', $e->getMessage());
        }
    }

    /**
     * test/built-ins/Array/length/15.4.5.1-3.d-3.js.
     */
    public function test154513D3(): void
    {
        $a = new Arr();
        $a->length = 4294967295;
        self::assertSame(4294967295, $a->length);
    }

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-coercion-order.js

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-coercion-order-set.js

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-error.js

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-no-value-order.js

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-overflow-order.js

    // SKIPPED: test/built-ins/Array/length/define-own-prop-length-overflow-realm.js

    // SKIPPED: test/built-ins/Array/length.js

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A1.2_T1.js

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.1_T1.js.
     */
    public function testS15422A21T1(): void
    {
        $x = new Arr(0);
        self::assertSame(0, $x->length);

        $x = new Arr(1);
        self::assertSame(1, $x->length);

        $x = new Arr(4294967295);
        self::assertSame(4294967295, $x->length);
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T1.js.
     */
    public function testS15422A22T1(): void
    {
        try {
            new Arr(-1);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(4294967296);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(4294967297);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T2.js.
     */
    public function testS15422A22T2(): void
    {
        try {
            new Arr(NAN);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(INF);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(-INF);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.2_T3.js.
     */
    public function testS15422A22T3(): void
    {
        try {
            new Arr(1.5);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(PHP_FLOAT_MAX);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            new Arr(PHP_FLOAT_MIN);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T1.js.
     */
    public function testS15422A23T1(): void
    {
        $x = new Arr(null);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertNull($x[0], 'The value of $x[0] is expected to be null');
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T2.js.
     */
    public function testS15422A23T2(): void
    {
        $x = new Arr(true);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertTrue($x[0], 'The value of $x[0] is expected to be true');

        $x = new Arr(false);
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertFalse($x[0], 'The value of $x[0] is expected to be false');
    }

    /**
     * test/built-ins/Array/length/S15.4.2.2_A2.3_T3.js.
     */
    public function testS15422A23T3(): void
    {
        $x = new Arr('1');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame('1', $x[0], 'The value of $x[0] is expected to be "1"');

        $x = new Arr('0');
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
        self::assertSame('0', $x[0], 'The value of $x[0] is expected to be "0"');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A2.3_T4.js

    // SKIPPED: test/built-ins/Array/length/S15.4.2.2_A2.3_T5.js

    // SKIPPED: test/built-ins/Array/length/S15.4.4_A1.3_T1.js

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.1_T1.js.
     */
    public function testS15451A11T1(): void
    {
        try {
            $x = new Arr();
            $x->length = 4294967296;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = -1;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = 1.5;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.1_T2.js.
     */
    public function testS15451A11T2(): void
    {
        try {
            $x = new Arr();
            $x->length = NAN;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = INF;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }

        try {
            $x = new Arr();
            $x->length = -INF;

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.2_T1.js.
     */
    public function testS15451A12T1(): void
    {
        $x = new Arr(0, null, 2, null, 4);
        $x->length = 4;
        self::assertNull($x[4], 'The value of $x[4] is expected to equal null');

        $x->length = 3;
        self::assertNull($x[3], 'The value of $x[3] is expected to equal null');
        self::assertSame(2, $x[2], 'The value of $x[2] is expected to be 2');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.5.1_A1.2_T3.js

    /**
     * test/built-ins/Array/length/S15.4.5.1_A1.3_T1.js.
     */
    public function testS15451A13T1(): void
    {
        $x = new Arr();
        $x->length = true;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x = new Arr(null);
        $x->length = null;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x = new Arr(null);
        $x->length = false;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x = new Arr();
        $x->length = '1';
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/length/S15.4.5.1_A1.3_T2.js

    /**
     * test/built-ins/Array/length/S15.4.5.2_A3_T4.js.
     */
    public function testS15452A3T4(): void
    {
        $x = new Arr(0, 1, 2);
        $x[4294967294] = 4294967294;
        $x->length = 2;

        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
        self::assertNull($x[2], 'The value of $x[2] is expected to equal null');
        self::assertNull($x[4294967294], 'The value of $x[4294967294] is expected to equal null');
    }

    // SKIPPED: test/built-ins/Array/name.js

    // SKIPPED: test/built-ins/Array/of/construct-this-with-the-number-of-arguments.js

    /**
     * test/built-ins/Array/of/creates-a-new-array-from-arguments.js.
     */
    public function testCreatesANewArrayFromArguments(): void
    {
        $a1 = Arr::of('Mike', 'Rick', 'Leo');
        self::assertSame(3, $a1->length, 'The value of $a1->length is expected to be 3');
        self::assertSame('Mike', $a1[0], 'The value of $a1[0] is expected to be "Mike"');
        self::assertSame('Rick', $a1[1], 'The value of $a1[1] is expected to be "Rick"');
        self::assertSame('Leo', $a1[2], 'The value of $a1[2] is expected to be "Leo"');

        $a2 = Arr::of(null, false, null, null);
        self::assertSame(4, $a2->length, 'The value of $a2->length is expected to be 4');
        self::assertNull($a2[0], 'The value of a2[0] is expected to equal null');
        self::assertFalse($a2[1], 'The value of $a2[1] is expected to be false');
        self::assertNull($a2[2], 'The value of $a2[2] is expected to be null');
        self::assertNull($a2[3], 'The value of a2[3] is expected to equal null');

        $a3 = Arr::of();
        self::assertSame(0, $a3->length, 'The value of $a3->length is expected to be 0');
    }

    // SKIPPED: test/built-ins/Array/of/does-not-use-prototype-properties.js

    // SKIPPED: test/built-ins/Array/of/does-not-use-set-for-indices.js

    // SKIPPED: test/built-ins/Array/of/length.js

    // SKIPPED: test/built-ins/Array/of/name.js

    // SKIPPED: test/built-ins/Array/of/not-a-constructor.js

    // SKIPPED: test/built-ins/Array/of/of.js

    // SKIPPED: test/built-ins/Array/of/proto-from-ctor-realm.js

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-contructor.js

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-data-property.js

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-data-property-using-proxy.js

    // SKIPPED: test/built-ins/Array/of/return-abrupt-from-setting-length.js

    /**
     * test/built-ins/Array/of/return-a-custom-instance.js.
     */
    public function testReturnACustomInstance(): void
    {
        $coop = Arr::of('Mike', 'Rick', 'Leo');

        self::assertSame(3, $coop->length, 'The value of $coop->length is expected to be 3');

        self::assertSame('Mike', $coop[0], 'The value of $coop[0] is expected to be "Mike"');
        self::assertSame('Rick', $coop[1], 'The value of $coop[0] is expected to be "Rick"');
        self::assertSame('Leo', $coop[2], 'The value of $coop[0] is expected to be "Leo"');
    }

    // SKIPPED: test/built-ins/Array/of/return-a-new-array-object.js

    // SKIPPED: test/built-ins/Array/of/sets-length.js

    // SKIPPED: test/built-ins/Array/prop-desc.js

    /**
     * test/built-ins/Array/property-cast-boolean-primitive.js.
     */
    public function testPropertyCastBooleanPrimitive(): void
    {
        $x = new Arr();

        $x[true] = 1;
        self::assertNull($x[1], 'The value of $x[1] is expected to equal null');
        self::assertSame(1, $x['true'], 'The value of $x["true"] is expected to be 1');

        $x[false] = 0;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(0, $x['false'], 'The value of $x["false"] is expected to be 0');
    }

    /**
     * test/built-ins/Array/property-cast-nan-infinity.js.
     */
    public function testPropertyCastNanInfinity(): void
    {
        $x = new Arr();

        // In Arr, non-finite float offsets are ignored (normalizeOffset does not convert them)
        $x[NAN] = 1;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(1, $x['NAN'], 'The value of x["NAN"] is expected to be 1');

        $y = new Arr();
        $y[INF] = 1;
        self::assertNull($y[0], 'The value of $y[0] is expected to equal null');
        self::assertSame(1, $y['INF'], 'The value of $y["INF"] is expected to be 1');

        $z = new Arr();
        $z[-INF] = 1;
        self::assertNull($z[0], 'The value of $z[0] is expected to equal null');
        self::assertSame(1, $z['-INF'], 'The value of $z["-INF"] is expected to be 1');
    }

    /**
     * test/built-ins/Array/property-cast-number.js.
     */
    public function testPropertyCastNumber(): void
    {
        $x = new Arr();
        $x[4294967296] = 1;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');
        self::assertSame(1, $x[4294967296], 'The value of $x["4294967296"] is expected to be 1');

        $y = new Arr();
        $y[4294967297] = 1;
        if (isset($y[1])) {
            throw new \Exception('#3: $y = []; $y[4294967297] = 1; $y[1] === null. Actual: '.$y[1]);
        }

        // CHECK#4
        if (1 !== $y['4294967297']) {
            throw new \Exception('#4: y = []; y[4294967297] = 1; y["4294967297"] === 1. Actual: '.$y['4294967297']);
        }

        // CHECK#5
        $z = new Arr();
        $z[1.1] = 1;
        if (isset($z[1])) {
            throw new \Exception('#5: z = []; z[1.1] = 1; z[1] === undefined. Actual: '.$z[1]);
        }

        // CHECK#6
        if (1 !== $z['1.1']) {
            throw new \Exception('#6: z = []; z[1.1] = 1; z["1.1"] === 1. Actual: '.$z['1.1']);
        }
    }

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-one.js

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-two.js

    // SKIPPED: test/built-ins/Array/proto-from-ctor-realm-zero.js

    // SKIPPED: test/built-ins/Array/proto.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.2_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A1.3_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A2.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A2.2_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.1_A3.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.2.1_A1.2_T1.js

    /**
     * test/built-ins/Array/S15.4.2.1_A1.3_T1.js.
     */
    public function testS15421A13T1(): void
    {
        $x = new Arr(2);

        self::assertNotSame(1, $x->length, 'The value of $x->length is not 1');
        self::assertNotSame(2, $x[0], 'The value of $x[0] is not 2');
    }

    /**
     * test/built-ins/Array/S15.4.2.1_A2.1_T1.js.
     */
    public function testS15421A21T1(): void
    {
        self::assertSame(0, (new Arr())->length, 'The value of new Arr()->length is expected to be 0');
        self::assertSame(4, (new Arr(0, 1, 0, 1))->length, 'The value of new Arr(0, 1, 0, 1)->length is expected to be 4');

        self::assertSame(2, (new Arr(null, null))->length, 'The value of new Arr(null, null)->length is expected to be 2');
    }

    /**
     * test/built-ins/Array/S15.4.2.1_A2.2_T1.js.
     */
    public function testS15421A22T1(): void
    {
        $x = new Arr(...range(0, 99));

        for ($i = 0; $i < 100; ++$i) {
            $result = true;
            if ($x[$i] !== $i) {
                $result = false;
            }
        }

        self::assertTrue($result, 'The value of result is expected to be true');
    }

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T1.js

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T2.js

    // SKIPPED: test/built-ins/Array/S15.4.3_A1.1_T3.js

    // SKIPPED: test/built-ins/Array/S15.4.5.1_A1.2_T2.js

    /**
     * test/built-ins/Array/S15.4.5.1_A2.1_T1.js.
     */
    public function testS15451A21T1(): void
    {
        $x = new Arr();
        $x[4294967295] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[4294967295], 'The value of $x[4294967295] is expected to be 1');

        $x = new Arr();
        $x[-1] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[-1], 'The value of x[-1] is expected to be 1');

        $x = new Arr();
        $x[true] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');
        self::assertSame(1, $x[true], 'The value of $x[true] is expected to be 1');
    }

    /**
     * test/built-ins/Array/S15.4.5.1_A2.2_T1.js.
     */
    public function testS15451A22T1(): void
    {
        $x = new Arr(100);
        $x[0] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');

        $x[98] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');

        $x[99] = 1;
        self::assertSame(100, $x->length, 'The value of $x->length is expected to be 100');
    }

    /**
     * test/built-ins/Array/S15.4.5.1_A2.3_T1.js.
     */
    public function testS15451A23T1(): void
    {
        $x = new Arr(100);
        $x[100] = 1;
        self::assertSame(101, $x->length, 'The value of $x->length is expected to be 101');

        $x[199] = 1;
        self::assertSame(200, $x->length, 'The value of $x->length is expected to be 200');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A1_T1.js.
     */
    public function testS15452A1T1(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x[0] = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[1] = 1;
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');

        $x[2147483648] = 1;
        self::assertSame(2147483649, $x->length, 'The value of $x->length is expected to be 2147483649');

        $x[4294967294] = 1;
        self::assertSame(4294967295, $x->length, 'The value of $x->length is expected to be 4294967295');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A1_T2.js.
     */
    public function testS15452A1T2(): void
    {
        $x = new Arr();
        $x[4294967295] = 1;
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $y = new Arr();
        $y[1] = 1;
        $y[4294967295] = 1;
        self::assertSame(2, $y->length, 'The value of $y->length is expected to be 2');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A2_T1.js.
     */
    public function testS15452A2T1(): void
    {
        $x = new Arr();
        self::assertSame(0, $x->length, 'The value of $x->length is expected to be 0');

        $x[0] = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[1] = 1;
        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');

        $x[9] = 1;
        self::assertSame(10, $x->length, 'The value of $x->length is expected to be 10');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T1.js.
     */
    public function testS15452A3T1(): void
    {
        $x = new Arr();
        $x->length = 1;
        self::assertSame(1, $x->length, 'The value of $x->length is expected to be 1');

        $x[5] = 1;
        $x->length = 10;
        self::assertSame(10, $x->length, 'The value of $x->length is expected to be 10');
        self::assertSame(1, $x[5], 'The value of $x[5] is expected to be 1');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T2.js.
     */
    public function testS15452A3T2(): void
    {
        $x = new Arr();
        $x[1] = 1;
        $x[3] = 3;
        $x[5] = 5;
        $x->length = 4;

        self::assertSame(4, $x->length, 'The value of $x->length is expected to be 4');
        self::assertNull($x[5], 'The value of $x[5] is expected to equal null');
        self::assertSame(3, $x[3], 'The value of $x[3] is expected to be 3');

        $x->length = 6;
        self::assertNull($x[5], 'The value of $x[5] is expected to equal null');

        $x->length = 0;
        self::assertNull($x[0], 'The value of $x[0] is expected to equal null');

        $x->length = 1;
        self::assertNull($x[1], 'The value of $x[1] is expected to equal null');
    }

    /**
     * test/built-ins/Array/S15.4.5.2_A3_T3.js.
     */
    public function testS15452A3T3(): void
    {
        $x = new Arr();
        $x->length = 4294967295;
        self::assertSame(4294967295, $x->length, 'The value of $x->length is expected to be 4294967295');

        try {
            $x = new Arr();
            $x->length = 4294967296;

            throw new \Exception('#2.1:$x = new Arr(); $x->length = 4294967296 throw RangeError. Actual: $x->length === '.$x->length);
        } catch (\Throwable $e) {
            self::assertInstanceOf(RangeError::class, $e, 'The result of evaluating ($e instanceof RangeError) is expected to be true');
        }
    }

    /**
     * test/built-ins/Array/S15.4_A1.1_T10.js.
     */
    public function testS154A11T10(): void
    {
        $x = new Arr();
        $k = 1;
        for ($i = 0; $i < 32; ++$i) {
            $k *= 2;
            $x[$k - 2] = $k;
        }

        $k = 1;
        for ($i = 0; $i < 32; ++$i) {
            $k *= 2;
            self::assertSame($k, $x[$k - 2], 'The value of $x[k - 2] is expected to equal the value of $k');
        }
    }

    /**
     * test/built-ins/Array/S15.4_A1.1_T4.js.
     */
    public function testS154A11T4(): void
    {
        $x = new Arr();
        $x['0'] = 0;
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');

        $y = new Arr();
        $y['1'] = 1;
        self::assertSame(1, $y[1], 'The value of $y[1] is expected to be 1');
    }

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T5.js
    // Reason: $x[] = 1 and $x[null] = 1 are the same, therefore this JS feature cannot be implemented

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T6.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T7.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T8.js

    // SKIPPED: test/built-ins/Array/S15.4_A1.1_T9.js

    // SKIPPED: test/built-ins/Array/Symbol.species/length.js

    // SKIPPED: test/built-ins/Array/Symbol.species/return-value.js

    // SKIPPED: test/built-ins/Array/Symbol.species/symbol-species.js

    // SKIPPED: test/built-ins/Array/Symbol.species/symbol-species-name.js
}
