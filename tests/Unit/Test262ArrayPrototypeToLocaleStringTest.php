<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.toLocaleString tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeToLocaleStringTest extends TestCase
{
    /**
     * test/built-ins/Array/prototype/toLocaleString/S15.4.4.3_A1_T1.js.
     */
    public function testS154443A1T1(): void
    {
        $obj = new class {
            public int $n = 0;

            public function toLocaleString(): string
            {
                ++$this->n;

                return '';
            }
        };

        $arr = new Arr(null, $obj, null, $obj, $obj);
        $arr->toLocaleString();

        self::assertSame(3, $obj->n, '#1: $arr = new Arr(null, $obj, null, $obj, $obj); $arr->toLocaleString(); $n === 3');
    }

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/S15.4.4.3_A3_T1.js
    // Reason: test262 semantics are not portable to PHP

    /**
     * test/built-ins/Array/prototype/toLocaleString/invoke-element-tolocalestring.js.
     */
    public function testInvokeElementTolocalestring(): void
    {
        // Adapted: Arr::toLocaleString(?string $locales, ?array $options) is typed,
        // so the object-locale/extra-arguments test cases are not representable.
        $testCases = [
            ['label' => 'no arguments', 'args' => []],
            ['label' => 'null locale', 'args' => [null]],
            ['label' => 'string locale', 'args' => ['ar']],
            ['label' => 'null locale and options', 'args' => [null, ['style' => 'decimal']]],
            ['label' => 'string locale and options', 'args' => ['zh', ['style' => 'decimal']]],
        ];

        foreach ($testCases as ['label' => $label, 'args' => $args]) {
            self::assertSame('', (new Arr(null))->toLocaleString(...$args), \sprintf('must skip null elements when provided %s', $label));
        }

        $spy = new class {
            /**
             * @var null|list<mixed>
             */
            public ?array $receivedArgs = null;

            public function toLocaleString(mixed ...$args): string
            {
                $this->receivedArgs = $args;

                return 'ok';
            }
        };

        foreach ($testCases as ['label' => $label, 'args' => $args]) {
            $spy->receivedArgs = null;
            self::assertSame('ok', (new Arr($spy))->toLocaleString(...$args));
            self::assertSame([], $spy->receivedArgs, \sprintf('must invoke element toLocaleString with no arguments when provided %s', $label));
        }
    }

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/length.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/name.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/not-a-constructor.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/primitive_this_value.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/primitive_this_value_getter.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/prop-desc.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/resizable-buffer.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/user-provided-tolocalestring-grow.js
    // Reason: test262 semantics are not portable to PHP

    // SKIPPED: test/built-ins/Array/prototype/toLocaleString/user-provided-tolocalestring-shrink.js
    // Reason: test262 semantics are not portable to PHP
}
