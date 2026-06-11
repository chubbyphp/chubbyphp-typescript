<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.from tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayFromTest extends TestCase
{
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

    // SKIPPED: test/built-ins/Array/fromAsync/*
    // Reason: Array.fromAsync relies on Promises, async iteration (@@asyncIterator),
    // and thenables, which have no equivalent in PHP's synchronous Arr. There is no
    // Arr::fromAsync method, so none of the following tests make sense in PHP:
    // SKIPPED: test/built-ins/Array/fromAsync/async-iterable-async-mapped-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/async-iterable-input-does-not-await-input.js
    // SKIPPED: test/built-ins/Array/fromAsync/async-iterable-input-iteration-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/async-iterable-input.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-array-add-to-empty.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-array-add-to-singleton.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-array-add.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-array-mutate.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-array-remove.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-arraybuffer.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-arraylike-holes.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-arraylike-length-accessor-throws.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-arraylike-promise.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-arraylike-too-long.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-asynciterator-exists.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-asynciterator-not-callable.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-asynciterator-null.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-asynciterator-sync.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-asynciterator-throws.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-bigint.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-boolean.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-function.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-iterator-exists.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-iterator-not-callable.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-iterator-null.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-iterator-promise.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-iterator-throws.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-null-undefined.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-number.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-object-not-arraylike.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-operations.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-string.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-symbol.js
    // SKIPPED: test/built-ins/Array/fromAsync/asyncitems-uses-intrinsic-iterator-symbols.js
    // SKIPPED: test/built-ins/Array/fromAsync/builtin.js
    // SKIPPED: test/built-ins/Array/fromAsync/length.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-arraylike.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-iterable-async.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-iterable-sync.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-throws-close-async-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-throws-close-sync-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-async-throws.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-not-callable.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-result-awaited-once-per-iteration.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-arraylike.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-iterable-async.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-iterable-sync.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-throws-close-async-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-throws-close-sync-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/mapfn-sync-throws.js
    // SKIPPED: test/built-ins/Array/fromAsync/name.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-does-not-use-array-prototype.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-element-access-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-with-thenable-async-mapped-awaits-callback-result-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-with-thenable-async-mapped-callback-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-with-thenable-element-rejects.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-with-thenable-sync-mapped-callback-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input-with-thenable.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-input.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-sync-mapped-callback-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-with-non-promise-thenable.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-with-thenable-async-mapped-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-with-thenable-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-with-thenable-sync-mapped-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/non-iterable-with-thenable-then-method-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/not-a-constructor.js
    // SKIPPED: test/built-ins/Array/fromAsync/prop-desc.js
    // SKIPPED: test/built-ins/Array/fromAsync/returned-promise-resolves-to-array.js
    // SKIPPED: test/built-ins/Array/fromAsync/returns-promise.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-input-with-non-promise-thenable.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-input-with-thenable.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-input.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-iteration-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-rejecting-thenable-closes.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-rejecting-thenable-rejects.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-async-mapped-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-async-mapped-callback-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-sync-mapped-awaits-once.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-sync-mapped-callback-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/sync-iterable-with-thenable-then-method-err.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-operations.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-bad-length-setter.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-readonly-elements.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-readonly-length.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-unsettable-element-closes-async-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-unsettable-element-closes-sync-iterator.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor-with-unsettable-element.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-constructor.js
    // SKIPPED: test/built-ins/Array/fromAsync/this-non-constructor.js
    // SKIPPED: test/built-ins/Array/fromAsync/thisarg-object.js
    // SKIPPED: test/built-ins/Array/fromAsync/thisarg-omitted-sloppy.js
    // SKIPPED: test/built-ins/Array/fromAsync/thisarg-omitted-strict.js
    // SKIPPED: test/built-ins/Array/fromAsync/thisarg-primitive-sloppy.js
    // SKIPPED: test/built-ins/Array/fromAsync/thisarg-primitive-strict.js
}
