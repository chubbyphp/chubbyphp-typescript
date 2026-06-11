<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\Typescript\Unit;

use Chubbyphp\Typescript\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Ported from Test262 Array.prototype.concat tests.
 *
 * @covers \Chubbyphp\Typescript\Arr
 *
 * @internal
 */
final class Test262ArrayPrototypeConcatTest extends TestCase
{
    // SKIPPED: test/built-ins/Array/prototype/concat/15.4.4.4-5-b-iii-3-b-1.js
    // Reason: read-only index property on Array.prototype; no prototype chain in PHP

    // SKIPPED: test/built-ins/Array/prototype/concat/15.4.4.4-5-c-i-1.js
    // Reason: concat called on a number primitive; ToObject coercion is JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-length-to-string-throws.js
    // Reason: Symbol.isConcatSpreadable / array-like; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-length-value-of-throws.js
    // Reason: Symbol.isConcatSpreadable / array-like; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-negative-length.js
    // Reason: Symbol.isConcatSpreadable / array-like; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-primitive-non-number-length.js
    // Reason: Symbol.isConcatSpreadable / array-like; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-string-length.js
    // Reason: Symbol.isConcatSpreadable / array-like `this`; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like-to-length-throws.js
    // Reason: Symbol.isConcatSpreadable / array-like; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_array-like.js
    // Reason: Symbol.isConcatSpreadable / array-like `this`; not supported by Arr

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_holey-sloppy-arguments.js
    // Reason: arguments object with Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_large-typed-array.js
    // Reason: TypedArrays; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_length-throws.js
    // Reason: poisoned length getter on spreadable object; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_no-prototype.js
    // Reason: function `prototype` property; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_non-array.js
    // Reason: concat called on a non-Array class instance; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_sloppy-arguments-throws.js
    // Reason: arguments object with poisoned index getter; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_sloppy-arguments-with-dupes.js
    // Reason: arguments object with Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_sloppy-arguments.js
    // Reason: arguments object with Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_small-typed-array.js
    // Reason: TypedArrays; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-boolean-wrapper.js
    // Reason: Boolean wrapper objects and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-function.js
    // Reason: functions as spreadable objects via Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-getter-throws.js
    // Reason: poisoned Symbol.isConcatSpreadable getter; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-number-wrapper.js
    // Reason: Number wrapper objects and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-reg-exp.js
    // Reason: RegExp objects and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-sparse-object.js
    // Reason: plain objects made spreadable via Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_spreadable-string-wrapper.js
    // Reason: String wrapper objects and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/Array.prototype.concat_strict-arguments.js
    // Reason: arguments object with Symbol.isConcatSpreadable; JS-only

    /**
     * test/built-ins/Array/prototype/concat/S15.4.4.4_A1_T1.js.
     */
    public function testS154444A1T1(): void
    {
        $x = new Arr();
        $y = new Arr(0, 1);
        $z = new Arr(2, 3, 4);
        $arr = $x->concat($y, $z);

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr[2], 'The value of $arr[2] is expected to be 2');
        self::assertSame(3, $arr[3], 'The value of $arr[3] is expected to be 3');
        self::assertSame(4, $arr[4], 'The value of $arr[4] is expected to be 4');
        self::assertSame(5, $arr->length, 'The value of $arr->length is expected to be 5');
    }

    /**
     * test/built-ins/Array/prototype/concat/S15.4.4.4_A1_T2.js.
     */
    public function testS154444A1T2(): void
    {
        $x = Arr::of(0);
        $y = new \stdClass();
        $z = new Arr(1, 2);
        $arr = $x->concat($y, $z, -1, true, 'NaN');

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame($y, $arr[1], 'The value of $arr[1] is expected to equal the value of $y');
        self::assertSame(1, $arr[2], 'The value of $arr[2] is expected to be 1');
        self::assertSame(2, $arr[3], 'The value of $arr[3] is expected to be 2');
        self::assertSame(-1, $arr[4], 'The value of $arr[4] is expected to be -1');
        self::assertTrue($arr[5], 'The value of $arr[5] is expected to be true');
        self::assertSame('NaN', $arr[6], 'The value of $arr[6] is expected to be "NaN"');
        self::assertSame(7, $arr->length, 'The value of $arr->length is expected to be 7');
    }

    /**
     * test/built-ins/Array/prototype/concat/S15.4.4.4_A1_T3.js.
     */
    public function testS154444A1T3(): void
    {
        $x = new Arr(0, 1);
        $arr = $x->concat();

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertSame(0, $arr[0], 'The value of $arr[0] is expected to be 0');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertSame(2, $arr->length, 'The value of $arr->length is expected to be 2');
        self::assertNotSame($x, $arr, 'The value of $arr is expected to not equal the value of `$x`');
    }

    /**
     * test/built-ins/Array/prototype/concat/S15.4.4.4_A1_T4.js.
     */
    public function testS154444A1T4(): void
    {
        $x = new Arr(2);
        $x[1] = 1;
        $arr = $x->concat(new Arr(), new Arr(1));

        self::assertInstanceOf(Arr::class, $arr, '$arr is expected to be an Arr object');
        self::assertNull($arr[0], 'The value of $arr[0] is expected to equal null');
        self::assertSame(1, $arr[1], 'The value of $arr[1] is expected to be 1');
        self::assertNull($arr[2], 'The value of $arr[2] is expected to equal null');
        self::assertSame(3, $arr->length, 'The value of $arr->length is expected to be 3');
    }

    // SKIPPED: test/built-ins/Array/prototype/concat/S15.4.4.4_A2_T1.js
    // Reason: concat called with a plain object as `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/S15.4.4.4_A2_T2.js
    // Reason: concat called with a plain object as `this`; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/S15.4.4.4_A3_T1.js
    // Reason: elements inherited from Array.prototype/Object.prototype; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/S15.4.4.4_A3_T2.js
    // Reason: elements inherited from Array.prototype; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/S15.4.4.4_A3_T3.js
    // Reason: elements inherited from Object.prototype; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/arg-length-exceeding-integer-limit.js
    // Reason: array-like with length near 2^53-1 and Proxy; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/arg-length-near-integer-limit.js
    // Reason: array-like with poisoned index getter; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/call-with-boolean.js
    // Reason: concat called on a boolean primitive; ToObject coercion is JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-ctor-non-object.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-ctor-poisoned.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-non-array.js
    // Reason: `constructor` property / ArraySpeciesCreate; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-proto-from-ctor-realm-array.js
    // Reason: realms and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-proto-from-ctor-realm-non-array.js
    // Reason: realms and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-proxy.js
    // Reason: Proxy and @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-revoked-proxy.js
    // Reason: revoked Proxy; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-abrupt.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-non-ctor.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-non-extensible-spreadable.js
    // Reason: @@species and non-extensible objects; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-non-extensible.js
    // Reason: @@species and non-extensible objects; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-null.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-poisoned.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-undef.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-with-non-configurable-property-spreadable.js
    // Reason: @@species and property descriptors; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-with-non-configurable-property.js
    // Reason: @@species and property descriptors; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-with-non-writable-property-spreadable.js
    // Reason: @@species and property descriptors; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species-with-non-writable-property.js
    // Reason: @@species and property descriptors; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/create-species.js
    // Reason: @@species; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-get-err.js
    // Reason: Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-get-order.js
    // Reason: Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-is-array-proxy-revoked.js
    // Reason: Proxy and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-proxy-revoked.js
    // Reason: Proxy and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-proxy.js
    // Reason: Proxy and Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-val-falsey.js
    // Reason: Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-val-truthy.js
    // Reason: Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/is-concat-spreadable-val-undefined.js
    // Reason: Symbol.isConcatSpreadable; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/length.js
    // Reason: `length` property of the function; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/name.js
    // Reason: `name` property of the function; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/not-a-constructor.js
    // Reason: [[Construct]] internal method; JS-only

    // SKIPPED: test/built-ins/Array/prototype/concat/prop-desc.js
    // Reason: property descriptor of Array.prototype.concat; JS-only
}
