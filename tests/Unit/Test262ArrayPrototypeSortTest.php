<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.sort tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeSortTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.1_T1.js.
     */
    public function testS154411A11T1(): void
    {
        $x = new Arr(2);
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertNull($x[0], 'The value of $x[0] is expected to be null');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.2_T1.js.
     */
    public function testS154411A12T1(): void
    {
        $x = new Arr(2);
        $x[1] = 1;
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');

        $x = new Arr(2);
        $x[0] = 1;
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.2_T2.js.
     */
    public function testS154411A12T2(): void
    {
        $myComparefn = static function (mixed $x, mixed $y): int {
            if (null === $x) {
                return -1;
            }

            if (null === $y) {
                return 1;
            }

            return 0;
        };

        $x = new Arr(2);
        $x[1] = 1;
        $x->sort($myComparefn);

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');

        $x = new Arr(2);
        $x[0] = 1;
        $x->sort($myComparefn);

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.3_T1.js.
     */
    public function testS154411A13T1(): void
    {
        $x = new Arr(null, null);
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertNull($x[0], 'The value of $x[0] is expected to be null');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.4_T1.js.
     */
    public function testS154411A14T1(): void
    {
        $x = new Arr(null, 1);
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');

        $x = new Arr(1, null);
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.4_T2.js.
     */
    public function testS154411A14T2(): void
    {
        $myComparefn = static function (mixed $x, mixed $y): int {
            if (null === $x) {
                return -1;
            }

            if (null === $y) {
                return 1;
            }

            return 0;
        };

        $x = new Arr(null, 1);
        $x->sort($myComparefn);

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');

        $x = new Arr(1, null);
        $x->sort($myComparefn);

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(1, $x[0], 'The value of $x[0] is expected to be 1');
        self::assertNull($x[1], 'The value of $x[1] is expected to be null');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A1.5_T1.js.
     */
    public function testS154411A15T1(): void
    {
        $x = new Arr(1, 0);
        $x->sort();

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');

        $x = new Arr(1, 0);
        $x->sort(null);

        self::assertSame(2, $x->length, 'The value of $x->length is expected to be 2');
        self::assertSame(0, $x[0], 'The value of $x[0] is expected to be 0');
        self::assertSame(1, $x[1], 'The value of $x[1] is expected to be 1');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.1_T1.js.
     */
    public function testS154411A21T1(): void
    {
        $alphabetR = new Arr('z', 'y', 'x', 'w', 'v', 'u', 't', 's', 'r', 'q', 'p', 'o', 'n', 'M', 'L', 'K', 'J', 'I', 'H', 'G', 'F', 'E', 'D', 'C', 'B', 'A');
        $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

        $alphabetR->sort();

        for ($i = 0; $i < 26; ++$i) {
            self::assertSame($alphabet[$i], $alphabetR[$i], 'CHECK ENGLISH ALPHABET');
        }
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.1_T2.js.
     */
    public function testS154411A21T2(): void
    {
        $alphabetR = new Arr('ё', 'я', 'ю', 'э', 'ь', 'ы', 'ъ', 'щ', 'ш', 'ч', 'ц', 'х', 'ф', 'у', 'т', 'с', 'р', 'П', 'О', 'Н', 'М', 'Л', 'К', 'Й', 'И', 'З', 'Ж', 'Е', 'Д', 'Г', 'В', 'Б', 'А');
        $alphabet = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'ё'];

        $alphabetR->sort();

        for ($i = 0; $i < 33; ++$i) {
            self::assertSame($alphabet[$i], $alphabetR[$i], 'CHECK RUSSIAN ALPHABET');
        }
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.1_T3.js.
     */
    public function testS154411A21T3(): void
    {
        $obj = new class implements \Stringable {
            public function __toString(): string
            {
                return '-2';
            }
        };

        $alphabetR = new Arr(null, 2, 1, 'X', -1, 'a', true, $obj, NAN, INF);

        $alphabetR->sort();

        self::assertSame(-1, $alphabetR[0], 'Check ToString operator');
        self::assertSame($obj, $alphabetR[1], 'Check ToString operator');
        self::assertSame(1, $alphabetR[2], 'Check ToString operator');
        self::assertSame(2, $alphabetR[3], 'Check ToString operator');
        self::assertSame(INF, $alphabetR[4], 'Check ToString operator');
        self::assertNan($alphabetR[5], 'Check ToString operator');
        self::assertSame('X', $alphabetR[6], 'Check ToString operator');
        self::assertSame('a', $alphabetR[7], 'Check ToString operator');
        self::assertTrue($alphabetR[8], 'Check ToString operator');
        self::assertNull($alphabetR[9], 'Check ToString operator');
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.2_T1.js.
     */
    public function testS154411A22T1(): void
    {
        $alphabetR = ['z', 'y', 'x', 'w', 'v', 'u', 't', 's', 'r', 'q', 'p', 'o', 'n', 'M', 'L', 'K', 'J', 'I', 'H', 'G', 'F', 'E', 'D', 'C', 'B', 'A'];
        $alphabet = new Arr('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

        $myComparefn = static fn (mixed $x, mixed $y): int => strcmp(self::jsString($y), self::jsString($x));

        $alphabet->sort($myComparefn);

        for ($i = 0; $i < 26; ++$i) {
            self::assertSame($alphabetR[$i], $alphabet[$i], 'CHECK ENGLISH ALPHABET');
        }
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.2_T2.js.
     */
    public function testS154411A22T2(): void
    {
        $alphabetR = ['ё', 'я', 'ю', 'э', 'ь', 'ы', 'ъ', 'щ', 'ш', 'ч', 'ц', 'х', 'ф', 'у', 'т', 'с', 'р', 'П', 'О', 'Н', 'М', 'Л', 'К', 'Й', 'И', 'З', 'Ж', 'Е', 'Д', 'Г', 'В', 'Б', 'А'];
        $alphabet = new Arr('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'ё');

        $myComparefn = static fn (mixed $x, mixed $y): int => strcmp(self::jsString($y), self::jsString($x));

        $alphabet->sort($myComparefn);

        for ($i = 0; $i < 33; ++$i) {
            self::assertSame($alphabetR[$i], $alphabet[$i], 'CHECK RUSSIAN ALPHABET');
        }
    }

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A2.2_T3.js.
     */
    public function testS154411A22T3(): void
    {
        $obj = new class implements \Stringable {
            public function __toString(): string
            {
                return '-2';
            }
        };

        $alphabetR = new Arr(null, 2, 1, 'X', -1, 'a', true, $obj, NAN, INF);

        $myComparefn = static fn (mixed $x, mixed $y): int => strcmp(self::jsString($y), self::jsString($x));

        $alphabetR->sort($myComparefn);

        self::assertTrue($alphabetR[0], 'Check ToString operator');
        self::assertSame('a', $alphabetR[1], 'Check ToString operator');
        self::assertSame('X', $alphabetR[2], 'Check ToString operator');
        self::assertNan($alphabetR[3], 'Check ToString operator');
        self::assertSame(INF, $alphabetR[4], 'Check ToString operator');
        self::assertSame(2, $alphabetR[5], 'Check ToString operator');
        self::assertSame(1, $alphabetR[6], 'Check ToString operator');
        self::assertSame($obj, $alphabetR[7], 'Check ToString operator');
        self::assertSame(-1, $alphabetR[8], 'Check ToString operator');
        self::assertNull($alphabetR[9], 'Check ToString operator');
    }

    // SKIPPED: test/built-ins/Array/prototype/sort/S15.4.4.11_A3_T1.js
    // Reason: sort called generically on a non-array object via Array.prototype.sort

    // SKIPPED: test/built-ins/Array/prototype/sort/S15.4.4.11_A3_T2.js
    // Reason: sort called generically on a non-array object via Array.prototype.sort

    // SKIPPED: test/built-ins/Array/prototype/sort/S15.4.4.11_A4_T3.js
    // Reason: ToLength(length) coercion on a non-array object

    /**
     * test/built-ins/Array/prototype/sort/S15.4.4.11_A5_T1.js.
     */
    public function testS154411A5T1(): void
    {
        $exception = new \Exception();

        $myComparefn = static function () use ($exception): int {
            throw $exception;
        };

        try {
            $x = new Arr(1, 0);
            $x->sort($myComparefn);

            throw new \Exception('Should not be reached');
        } catch (\Throwable $e) {
            self::assertSame($exception, $e, 'Array.sort should not eat exceptions');
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/sort/S15.4.4.11_A6_T2.js
    // Reason: elements inherited from Array.prototype/Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/S15.4.4.11_A8.js
    // Reason: asserts `this` is undefined inside comparefn; JS-only this-binding

    /**
     * test/built-ins/Array/prototype/sort/bug_596_1.js.
     */
    public function testBug5961(): void
    {
        $object = new class implements \Stringable {
            public int $counter = 0;

            public function __toString(): string
            {
                ++$this->counter;

                return '';
            }
        };

        $x = new Arr($object, $object);
        $x->sort();

        self::assertGreaterThanOrEqual(2, $object->counter, '[$object, $object]->sort(); $object->counter is expected to be at least 2');
    }

    /**
     * test/built-ins/Array/prototype/sort/bug_596_2.js.
     */
    public function testBug5962(): void
    {
        $array = new Arr(3);
        $array[0] = 'a';
        $array[2] = null;

        self::assertSame(3, $array->length, 'The value of $array->length is expected to be 3');
        self::assertTrue(isset($array[0]), 'isset($array[0]) is expected to be true');
        self::assertFalse(isset($array[1]), 'isset($array[1]) is expected to be false');
        self::assertTrue(isset($array[2]), 'isset($array[2]) is expected to be true');

        $array->sort();

        self::assertSame(3, $array->length, 'The value of $array->length is expected to be 3');
        self::assertTrue(isset($array[0]), 'isset($array[0]) is expected to be true');
        self::assertTrue(isset($array[1]), 'isset($array[1]) is expected to be true');
        self::assertFalse(isset($array[2]), 'isset($array[2]) is expected to be false');
    }

    // SKIPPED: test/built-ins/Array/prototype/sort/call-with-primitive.js
    // Reason: ToObject coercion of primitive this values

    // SKIPPED: test/built-ins/Array/prototype/sort/comparefn-grow.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/sort/comparefn-nonfunction-call-throws.js
    // Reason: comparefn given as non-callable; Arr::sort() is typed ?callable

    // SKIPPED: test/built-ins/Array/prototype/sort/comparefn-resizable-buffer.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/sort/comparefn-shrink.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/sort/length.js
    // Reason: accessor property defined on Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/name.js
    // Reason: accessor property defined on Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/not-a-constructor.js
    // Reason: accessor property defined on Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-comparefn-throws.js
    // Reason: accessor property defined on Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-appends-elements.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-decreases-length.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-deletes-predecessor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-deletes-successor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-increases-length.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-pops-elements.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-sets-predecessor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-getter-sets-successor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-prototype-accessors.js
    // Reason: accessor properties on Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-prototype-element.js
    // Reason: elements inherited from Object.prototype

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-appends-elements.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-decreases-length.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-deletes-predecessor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-deletes-successor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-increases-length.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-pops-elements.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-sets-predecessor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/precise-setter-sets-successor.js
    // Reason: accessor properties on indexes via Object.defineProperty

    // SKIPPED: test/built-ins/Array/prototype/sort/prop-desc.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    // SKIPPED: test/built-ins/Array/prototype/sort/resizable-buffer-default-comparator.js
    // Reason: TypedArrays backed by resizable ArrayBuffers

    /**
     * test/built-ins/Array/prototype/sort/stability-11-elements.js.
     */
    public function testStability11Elements(): void
    {
        $array = new Arr(
            ['name' => 'A', 'rating' => 2],
            ['name' => 'B', 'rating' => 3],
            ['name' => 'C', 'rating' => 2],
            ['name' => 'D', 'rating' => 4],
            ['name' => 'E', 'rating' => 3],
            ['name' => 'F', 'rating' => 3],
            ['name' => 'G', 'rating' => 4],
            ['name' => 'H', 'rating' => 3],
            ['name' => 'I', 'rating' => 2],
            ['name' => 'J', 'rating' => 2],
            ['name' => 'K', 'rating' => 2],
        );

        self::assertSame(11, $array->length, 'The value of $array->length is expected to be 11');

        // Sort the elements by `rating` in descending order.
        // (This updates `$array` in place.)
        $array->sort(static fn (array $a, array $b): int => $b['rating'] <=> $a['rating']);

        $reduced = $array->reduce(static fn (string $acc, array $element): string => $acc.$element['name'], '');

        self::assertSame('DGBEFHACIJK', $reduced, 'The value of $reduced is expected to be "DGBEFHACIJK"');
    }

    /**
     * test/built-ins/Array/prototype/sort/stability-2048-elements.js.
     */
    public function testStability2048Elements(): void
    {
        // The original test spells out all 2048 elements; they are generated
        // here instead: letters A-J appear 187 times each, K appears 178 times.
        $array = self::createStabilityFixture(187, 178, '%s%03d');

        self::assertSame(2048, $array->length, 'The value of $array->length is expected to be 2048');

        // Sort the elements by `rating` in descending order.
        // (This updates `$array` in place.)
        $array->sort(static fn (array $a, array $b): int => $b['rating'] <=> $a['rating']);

        $reduced = $array->reduce(static function (string $acc, array $element): string {
            $letter = substr($element['name'], 0, 1);

            if (str_ends_with($acc, $letter)) {
                return $acc;
            }

            return $acc.$letter;
        }, '');

        self::assertSame('DGBEFHACIJK', $reduced, 'The value of $reduced is expected to be "DGBEFHACIJK"');
    }

    /**
     * test/built-ins/Array/prototype/sort/stability-5-elements.js.
     */
    public function testStability5Elements(): void
    {
        $array = new Arr(
            ['name' => 'A', 'rating' => 2],
            ['name' => 'B', 'rating' => 3],
            ['name' => 'C', 'rating' => 2],
            ['name' => 'D', 'rating' => 3],
            ['name' => 'E', 'rating' => 3],
        );

        self::assertSame(5, $array->length, 'The value of $array->length is expected to be 5');

        // Sort the elements by `rating` in descending order.
        // (This updates `$array` in place.)
        $array->sort(static fn (array $a, array $b): int => $b['rating'] <=> $a['rating']);

        $reduced = $array->reduce(static fn (string $acc, array $element): string => $acc.$element['name'], '');

        self::assertSame('BDEAC', $reduced, 'The value of $reduced is expected to be "BDEAC"');
    }

    /**
     * test/built-ins/Array/prototype/sort/stability-513-elements.js.
     */
    public function testStability513Elements(): void
    {
        // The original test spells out all 513 elements; they are generated
        // here instead: letters A-J appear 47 times each, K appears 43 times.
        $array = self::createStabilityFixture(47, 43, '%s%02d');

        self::assertSame(513, $array->length, 'The value of $array->length is expected to be 513');

        // Sort the elements by `rating` in descending order.
        // (This updates `$array` in place.)
        $array->sort(static fn (array $a, array $b): int => $b['rating'] <=> $a['rating']);

        $reduced = $array->reduce(static function (string $acc, array $element): string {
            $letter = substr($element['name'], 0, 1);

            if (str_ends_with($acc, $letter)) {
                return $acc;
            }

            return $acc.$letter;
        }, '');

        self::assertSame('DGBEFHACIJK', $reduced, 'The value of $reduced is expected to be "DGBEFHACIJK"');
    }

    /**
     * Converts a value to a string the way JavaScript's String() does, for
     * comparators ported from JS tests that compare String(x) with String(y).
     */
    private static function jsString(mixed $value): string
    {
        return match (true) {
            true === $value => 'true',
            false === $value => 'false',
            \is_float($value) && is_nan($value) => 'NaN',
            INF === $value => 'Infinity',
            -INF === $value => '-Infinity',
            \is_int($value) => (string) $value,
            \is_float($value) => (string) $value,
            \is_string($value) => $value,
            $value instanceof \Stringable => (string) $value,
            default => throw new \InvalidArgumentException('Unsupported value'),
        };
    }

    /**
     * @return Arr<array{name: string, rating: int}>
     */
    private static function createStabilityFixture(int $countPerLetter, int $countForK, string $nameFormat): Arr
    {
        $ratings = ['A' => 2, 'B' => 3, 'C' => 2, 'D' => 4, 'E' => 3, 'F' => 3, 'G' => 4, 'H' => 3, 'I' => 2, 'J' => 2, 'K' => 2];

        /** @var Arr<array{name: string, rating: int}> $array */
        $array = new Arr();

        foreach ($ratings as $letter => $rating) {
            $count = 'K' === $letter ? $countForK : $countPerLetter;
            for ($i = 0; $i < $count; ++$i) {
                $array->push(['name' => \sprintf($nameFormat, $letter, $i), 'rating' => $rating]);
            }
        }

        return $array;
    }
}
